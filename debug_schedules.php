<?php
// Debug script to check user IDs and schedules
session_start();

require_once __DIR__ . '/vendor/autoload.php';

// Function to convert time to minutes for easy comparison
function timeToMinutes($time) {
    $parts = explode(':', $time);
    return intval($parts[0]) * 60 + intval($parts[1]);
}

// Function to convert minutes back to time format
function minutesToTime($minutes) {
    $hours = floor($minutes / 60);
    $mins = $minutes % 60;
    return sprintf('%02d:%02d', $hours, $mins);
}

// Function to check if two time ranges overlap
function timeRangesOverlap($start1, $end1, $start2, $end2) {
    $start1Min = timeToMinutes($start1);
    $end1Min = timeToMinutes($end1);
    $start2Min = timeToMinutes($start2);
    $end2Min = timeToMinutes($end2);
    
    return ($start1Min < $end2Min) && ($start2Min < $end1Min);
}

// Function to find free time slots
function findFreeTimeSlots($teamSchedules, $day) {
    $workingHours = [
        'start' => timeToMinutes('08:00'),
        'end' => timeToMinutes('18:00')
    ];
    
    $busySlots = [];
    
    // Collect all busy time slots for the specific day
    foreach ($teamSchedules as $memberName => $schedules) {
        foreach ($schedules as $schedule) {
            if ($schedule['day'] === $day) {
                $busySlots[] = [
                    'start' => timeToMinutes($schedule['startTime']),
                    'end' => timeToMinutes($schedule['endTime']),
                    'member' => $memberName,
                    'title' => $schedule['title']
                ];
            }
        }
    }
    
    // Sort busy slots by start time
    usort($busySlots, function($a, $b) {
        return $a['start'] - $b['start'];
    });
    
    // Find free slots
    $freeSlots = [];
    $currentTime = $workingHours['start'];
    
    foreach ($busySlots as $busySlot) {
        if ($currentTime < $busySlot['start']) {
            // There's a free slot before this busy period
            $duration = $busySlot['start'] - $currentTime;
            if ($duration >= 60) { // At least 1 hour free
                $freeSlots[] = [
                    'start' => minutesToTime($currentTime),
                    'end' => minutesToTime($busySlot['start']),
                    'duration' => $duration,
                    'conflicts' => []
                ];
            }
        }
        $currentTime = max($currentTime, $busySlot['end']);
    }
    
    // Check for free time after the last busy slot
    if ($currentTime < $workingHours['end']) {
        $duration = $workingHours['end'] - $currentTime;
        if ($duration >= 60) { // At least 1 hour free
            $freeSlots[] = [
                'start' => minutesToTime($currentTime),
                'end' => minutesToTime($workingHours['end']),
                'duration' => $duration,
                'conflicts' => []
            ];
        }
    }
    
    return $freeSlots;
}

try {
    // Connect to MongoDB
    $client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
    $db = $client->uiurp;
    
    echo "<h2>Project Team Schedule Analysis & Meeting Time Suggestions</h2>";
    
    // Check if project exists
    if (isset($_GET['projectId'])) {
        $projectId = $_GET['projectId'];
        echo "<h3>Project ID: $projectId</h3>";
        
        // Get project details
        $projectsCollection = $db->projectsV2;
        $project = $projectsCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($projectId)]);
        
        if (!$project) {
            // Try old projects collection
            $projectsCollection = $db->projects;
            $project = $projectsCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($projectId)]);
        }
        
        if ($project) {
            echo "<h4>Project: " . ($project['title'] ?? 'N/A') . "</h4>";
            
            $teamSchedules = [];
            $scheduleCollection = $db->schedule;
            
            // Collect schedules for all team members
            echo "<h4>Team Member Schedules:</h4>";
            if (isset($project['members']) && is_array($project['members'])) {
                foreach ($project['members'] as $index => $member) {
                    $memberName = $member['name'] ?? "Member " . ($index + 1);
                    echo "<div style='border: 1px solid #ddd; padding: 10px; margin: 5px; background: #f9f9f9;'>";
                    echo "<p><strong>$memberName</strong> (" . ($member['role'] ?? 'N/A') . ")</p>";
                    
                    if (isset($member['userId'])) {
                        $userId = $member['userId'];
                        if (is_object($userId) && isset($userId->oid)) {
                            $userId = $userId->oid;
                        } elseif (is_array($userId) && isset($userId['$oid'])) {
                            $userId = $userId['$oid'];
                        }
                        
                        $userObjectId = new MongoDB\BSON\ObjectId($userId);
                        $schedules = $scheduleCollection->find(['userId' => $userObjectId])->toArray();
                        
                        $teamSchedules[$memberName] = [];
                        
                        if (count($schedules) > 0) {
                            echo "<ul>";
                            foreach ($schedules as $schedule) {
                                $scheduleData = [
                                    'title' => $schedule['title'] ?? 'N/A',
                                    'day' => $schedule['day'] ?? 'N/A',
                                    'startTime' => $schedule['startTime'] ?? 'N/A',
                                    'endTime' => $schedule['endTime'] ?? 'N/A',
                                    'type' => $schedule['type'] ?? 'N/A'
                                ];
                                $teamSchedules[$memberName][] = $scheduleData;
                                echo "<li>" . $scheduleData['title'] . " - " . $scheduleData['day'] . " " . $scheduleData['startTime'] . "-" . $scheduleData['endTime'] . "</li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "<p>No scheduled items</p>";
                        }
                    }
                    echo "</div>";
                }
            }
            
            // Collect supervisor schedule
            echo "<h4>Supervisor Schedule:</h4>";
            if (isset($project['supervisor'])) {
                $supervisorName = $project['supervisor']['name'] ?? 'Supervisor';
                echo "<div style='border: 1px solid #ddd; padding: 10px; margin: 5px; background: #f9f9f9;'>";
                echo "<p><strong>$supervisorName</strong></p>";
                
                if (isset($project['supervisor']['userId'])) {
                    $userId = $project['supervisor']['userId'];
                    if (is_object($userId) && isset($userId->oid)) {
                        $userId = $userId->oid;
                    } elseif (is_array($userId) && isset($userId['$oid'])) {
                        $userId = $userId['$oid'];
                    }
                    
                    $userObjectId = new MongoDB\BSON\ObjectId($userId);
                    $schedules = $scheduleCollection->find(['userId' => $userObjectId])->toArray();
                    
                    $teamSchedules[$supervisorName] = [];
                    
                    if (count($schedules) > 0) {
                        echo "<ul>";
                        foreach ($schedules as $schedule) {
                            $scheduleData = [
                                'title' => $schedule['title'] ?? 'N/A',
                                'day' => $schedule['day'] ?? 'N/A',
                                'startTime' => $schedule['startTime'] ?? 'N/A',
                                'endTime' => $schedule['endTime'] ?? 'N/A',
                                'type' => $schedule['type'] ?? 'N/A'
                            ];
                            $teamSchedules[$supervisorName][] = $scheduleData;
                            echo "<li>" . $scheduleData['title'] . " - " . $scheduleData['day'] . " " . $scheduleData['startTime'] . "-" . $scheduleData['endTime'] . "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>No scheduled items</p>";
                    }
                }
                echo "</div>";
            }
            
            // Analyze and suggest meeting times
            echo "<h3>📅 Suggested Meeting Times (When Everyone is Free)</h3>";
            
            $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            $suggestedMeetings = [];
            
            foreach ($daysOfWeek as $day) {
                echo "<h4>$day</h4>";
                $freeSlots = findFreeTimeSlots($teamSchedules, $day);
                
                if (count($freeSlots) > 0) {
                    echo "<div style='background: #e8f5e8; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
                    echo "<p><strong>✅ Available time slots:</strong></p>";
                    echo "<ul>";
                    foreach ($freeSlots as $slot) {
                        $durationHours = floor($slot['duration'] / 60);
                        $durationMins = $slot['duration'] % 60;
                        $durationText = $durationHours > 0 ? "{$durationHours}h " : "";
                        $durationText .= $durationMins > 0 ? "{$durationMins}min" : "";
                        
                        echo "<li><strong>" . $slot['start'] . " - " . $slot['end'] . "</strong> ({$durationText} available)</li>";
                        
                        // Store best suggestions (2+ hours)
                        if ($slot['duration'] >= 120) {
                            $suggestedMeetings[] = [
                                'day' => $day,
                                'start' => $slot['start'],
                                'end' => $slot['end'],
                                'duration' => $slot['duration']
                            ];
                        }
                    }
                    echo "</ul>";
                    echo "</div>";
                } else {
                    echo "<div style='background: #ffe8e8; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
                    echo "<p><strong>❌ No free time slots available (everyone is busy)</strong></p>";
                    echo "</div>";
                }
            }
            
            // Show top meeting recommendations
            if (count($suggestedMeetings) > 0) {
                // Sort by duration (longest first)
                usort($suggestedMeetings, function($a, $b) {
                    return $b['duration'] - $a['duration'];
                });
                
                echo "<h3>🏆 Top Meeting Recommendations</h3>";
                echo "<div style='background: #f0f8ff; padding: 20px; margin: 15px 0; border-radius: 8px; border: 2px solid #4CAF50;'>";
                echo "<p><strong>Best times for team meetings (2+ hours available):</strong></p>";
                echo "<ol>";
                
                $count = 0;
                foreach ($suggestedMeetings as $meeting) {
                    if ($count >= 5) break; // Show top 5
                    
                    $durationHours = floor($meeting['duration'] / 60);
                    $durationMins = $meeting['duration'] % 60;
                    $durationText = $durationHours > 0 ? "{$durationHours}h " : "";
                    $durationText .= $durationMins > 0 ? "{$durationMins}min" : "";
                    
                    echo "<li><strong>" . $meeting['day'] . " " . $meeting['start'] . " - " . $meeting['end'] . "</strong> ({$durationText} free)</li>";
                    $count++;
                }
                echo "</ol>";
                echo "</div>";
            } else {
                echo "<h3>⚠️ Meeting Challenge</h3>";
                echo "<div style='background: #fff3cd; padding: 20px; margin: 15px 0; border-radius: 8px; border: 2px solid #ffc107;'>";
                echo "<p><strong>No long free time slots found (2+ hours).</strong></p>";
                echo "<p>Consider:</p>";
                echo "<ul>";
                echo "<li>Shorter meeting durations (1 hour)</li>";
                echo "<li>Weekend meetings</li>";
                echo "<li>Adjusting individual schedules</li>";
                echo "<li>Virtual meetings during lunch breaks</li>";
                echo "</ul>";
                echo "</div>";
            }
            
        } else {
            echo "<p>❌ Project not found</p>";
        }
    } else {
        echo "<p>Please provide a projectId parameter: <code>debug_schedules.php?projectId=YOUR_PROJECT_ID</code></p>";
        echo "<p>Example: <code>debug_schedules.php?projectId=683ee98f2ac509172f01017b</code></p>";
    }
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}
?> 