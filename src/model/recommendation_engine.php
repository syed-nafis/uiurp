<?php
require_once __DIR__ . '/user_preferences.php';

class RecommendationEngine {
    private $db;
    private $preferences;
    
    public function __construct() {
        try {
            $mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
            $this->db = $mongoClient->uiurp;
            $this->preferences = new UserPreferences();
        } catch (Exception $e) {
            error_log("MongoDB connection failed in RecommendationEngine: " . $e->getMessage());
            $this->db = null;
        }
    }
    
    /**
     * Get personalized project recommendations
     */
    public function getRecommendedProjects($userId, $limit = 6) {
        if (!$this->db) return $this->getFallbackProjects($limit);
        
        try {
            $userProfile = $this->preferences->getUserProfile($userId);
            if (!$userProfile) return $this->getFallbackProjects($limit);
            
            $collection = $this->db->projectsV2;
            
            // Get user's interest keywords and categories
            $interests = $userProfile['interests'] ?? [];
            
            // Convert MongoDB BSONDocument/BSONArray to PHP array
            if ($interests instanceof MongoDB\Model\BSONDocument) {
                $interests = iterator_to_array($interests);
            }
            
            $keywordsData = $userProfile['keywords'] ?? [];
            if ($keywordsData instanceof MongoDB\Model\BSONDocument) {
                $keywordsData = iterator_to_array($keywordsData);
            }
            $keywords = is_array($keywordsData) ? array_keys($keywordsData) : [];
            
            // Build recommendation query
            $pipeline = [];
            
            // Match public projects first
            $pipeline[] = ['$match' => ['privacy' => 0]];
            
            // Add scoring based on user interests
            if (!empty($interests) || !empty($keywords)) {
                $pipeline[] = [
                    '$addFields' => [
                        'relevance_score' => [
                            '$sum' => array_merge(
                                $this->buildTagScoring($interests, 'keywords'), // Use keywords field for projects
                                $this->buildKeywordScoring($keywords, ['title', 'description', 'abstract'])
                            )
                        ]
                    ]
                ];
                
                // Sort by relevance score and creation date
                $pipeline[] = [
                    '$sort' => [
                        'relevance_score' => -1,
                        'createdAt' => -1
                    ]
                ];
            } else {
                // Fallback to recent projects
                $pipeline[] = ['$sort' => ['createdAt' => -1]];
            }
            
            // Limit results
            $pipeline[] = ['$limit' => $limit];
            
            // Project only needed fields
            $pipeline[] = [
                '$project' => [
                    'title' => 1,
                    'description' => 1,
                    'createdAt' => 1,
                    'members' => 1,
                    'tags' => 1,
                    'relevance_score' => 1
                ]
            ];
            
            $results = iterator_to_array($collection->aggregate($pipeline));
            
            // Debug logging
            error_log("DEBUG Projects: User $userId - Found " . count($results) . " personalized results");
            if (!empty($results)) {
                foreach (array_slice($results, 0, 3) as $i => $result) {
                    $score = $result['relevance_score'] ?? 0;
                    error_log("DEBUG Projects: #" . ($i+1) . " - '{$result['title']}' (Score: $score)");
                }
            }
            
            // If not enough personalized results, supplement with popular projects
            if (count($results) < $limit) {
                $remaining = $limit - count($results);
                $popularProjects = $this->getPopularProjects($remaining, array_column($results, '_id'));
                $results = array_merge($results, $popularProjects);
            }
            
            return array_slice($results, 0, $limit);
            
        } catch (Exception $e) {
            error_log("Error getting recommended projects: " . $e->getMessage());
            return $this->getFallbackProjects($limit);
        }
    }
    
    /**
     * Get personalized event recommendations
     */
    public function getRecommendedEvents($userId, $limit = 6) {
        if (!$this->db) return $this->getFallbackEvents($limit);
        
        try {
            $userProfile = $this->preferences->getUserProfile($userId);
            $collection = $this->db->events;
            
            $pipeline = [];
            
            // Match upcoming events
            $pipeline[] = [
                '$match' => [
                    'eventDate' => ['$gte' => new MongoDB\BSON\UTCDateTime()],
                    'status' => ['$ne' => 'cancelled']
                ]
            ];
            
            if ($userProfile && (!empty($userProfile['interests']) || !empty($userProfile['keywords']))) {
                $interests = $userProfile['interests'] ?? [];
                $keywordsData = $userProfile['keywords'] ?? [];
                
                // Convert MongoDB BSONDocument to PHP array
                if ($interests instanceof MongoDB\Model\BSONDocument) {
                    $interests = iterator_to_array($interests);
                }
                if ($keywordsData instanceof MongoDB\Model\BSONDocument) {
                    $keywordsData = iterator_to_array($keywordsData);
                }
                $keywords = is_array($keywordsData) ? array_keys($keywordsData) : [];
                
                $pipeline[] = [
                    '$addFields' => [
                        'relevance_score' => [
                            '$sum' => array_merge(
                                $this->buildTagScoring($interests, 'tags'),
                                $this->buildKeywordScoring($keywords, ['title', 'description'])
                            )
                        ]
                    ]
                ];
                
                $pipeline[] = [
                    '$sort' => [
                        'relevance_score' => -1,
                        'eventDate' => 1
                    ]
                ];
            } else {
                $pipeline[] = ['$sort' => ['eventDate' => 1]];
            }
            
            $pipeline[] = ['$limit' => $limit];
            $pipeline[] = [
                '$project' => [
                    'title' => 1,
                    'description' => 1,
                    'eventDate' => 1,
                    'eventType' => 1,
                    'status' => 1,
                    'tags' => 1,
                    'relevance_score' => 1
                ]
            ];
            
            $results = iterator_to_array($collection->aggregate($pipeline));
            
            // Debug logging
            error_log("DEBUG Events: User $userId - Found " . count($results) . " results");
            if (!empty($results)) {
                foreach (array_slice($results, 0, 3) as $i => $result) {
                    $score = $result['relevance_score'] ?? 0;
                    error_log("DEBUG Events: #" . ($i+1) . " - '{$result['title']}' (Score: $score)");
                }
            }
            
            return $results;
            
        } catch (Exception $e) {
            error_log("Error getting recommended events: " . $e->getMessage());
            return $this->getFallbackEvents($limit);
        }
    }
    
    /**
     * Get personalized forum post recommendations
     */
    public function getRecommendedForumPosts($userId, $limit = 6) {
        if (!$this->db) return $this->getFallbackForumPosts($limit);
        
        try {
            $userProfile = $this->preferences->getUserProfile($userId);
            $collection = $this->db->forum_posts;
            
            $pipeline = [];
            
            if ($userProfile && (!empty($userProfile['interests']) || !empty($userProfile['keywords']))) {
                $interests = $userProfile['interests'] ?? [];
                $keywordsData = $userProfile['keywords'] ?? [];
                
                // Convert MongoDB BSONDocument to PHP array
                if ($interests instanceof MongoDB\Model\BSONDocument) {
                    $interests = iterator_to_array($interests);
                }
                if ($keywordsData instanceof MongoDB\Model\BSONDocument) {
                    $keywordsData = iterator_to_array($keywordsData);
                }
                $keywords = is_array($keywordsData) ? array_keys($keywordsData) : [];
                
                $pipeline[] = [
                    '$addFields' => [
                        'relevance_score' => [
                            '$add' => [
                                ['$sum' => array_merge(
                                    $this->buildTagScoring($interests, 'tags'),
                                    $this->buildKeywordScoring($keywords, ['title', 'content'])
                                )],
                                ['$multiply' => [['$ifNull' => ['$upvotes', 0]], 0.1]]
                            ]
                        ]
                    ]
                ];
                
                $pipeline[] = [
                    '$sort' => [
                        'relevance_score' => -1,
                        'created_at' => -1
                    ]
                ];
            } else {
                $pipeline[] = [
                    '$sort' => [
                        'upvotes' => -1,
                        'created_at' => -1
                    ]
                ];
            }
            
            $pipeline[] = ['$limit' => $limit];
            $pipeline[] = [
                '$project' => [
                    'title' => 1,
                    'content' => 1,
                    'user_name' => 1,
                    'created_at' => 1,
                    'upvotes' => 1,
                    'tags' => 1,
                    'relevance_score' => 1
                ]
            ];
            
            return iterator_to_array($collection->aggregate($pipeline));
            
        } catch (Exception $e) {
            error_log("Error getting recommended forum posts: " . $e->getMessage());
            return $this->getFallbackForumPosts($limit);
        }
    }
    
    /**
     * Get personalized faculty recommendations
     */
    public function getRecommendedFaculties($userId, $limit = 8) {
        if (!$this->db) return $this->getFallbackFaculties($limit);
        
        try {
            $userProfile = $this->preferences->getUserProfile($userId);
            $collection = $this->db->faculties;
            
            $pipeline = [];
            
            if ($userProfile && !empty($userProfile['keywords'])) {
                $keywordsData = $userProfile['keywords'] ?? [];
                
                // Convert MongoDB BSONDocument to PHP array
                if ($keywordsData instanceof MongoDB\Model\BSONDocument) {
                    $keywordsData = iterator_to_array($keywordsData);
                }
                $keywords = is_array($keywordsData) ? array_keys($keywordsData) : [];
                
                $pipeline[] = [
                    '$addFields' => [
                        'relevance_score' => [
                            '$sum' => $this->buildKeywordScoring($keywords, ['bio', 'interested_fields_of_research'])
                        ]
                    ]
                ];
                
                $pipeline[] = [
                    '$sort' => [
                        'relevance_score' => -1,
                        'name' => 1
                    ]
                ];
            } else {
                $pipeline[] = ['$sort' => ['name' => 1]];
            }
            
            $pipeline[] = ['$limit' => $limit];
            $pipeline[] = [
                '$project' => [
                    'name' => 1,
                    'bio' => 1,
                    'profile_image' => 1,
                    'specialty' => 1,
                    'research_interests' => 1,
                    'relevance_score' => 1
                ]
            ];
            
            return iterator_to_array($collection->aggregate($pipeline));
            
        } catch (Exception $e) {
            error_log("Error getting recommended faculties: " . $e->getMessage());
            return $this->getFallbackFaculties($limit);
        }
    }
    
    /**
     * Build tag scoring for MongoDB aggregation
     */
    private function buildTagScoring($interests, $field = 'tags') {
        $scoring = [];
        foreach ($interests as $tag => $weight) {
            // Exact match
            $scoring[] = [
                '$cond' => [
                    'if' => ['$in' => [$tag, "\$$field"]],
                    'then' => $weight * 0.2, // Higher weight for exact matches
                    'else' => 0
                ]
            ];
            
            // Partial match (case-insensitive)
            $scoring[] = [
                '$cond' => [
                    'if' => [
                        '$anyElementTrue' => [
                            [
                                '$map' => [
                                    'input' => "\$$field",
                                    'as' => 'fieldItem',
                                    'in' => [
                                        '$regexMatch' => [
                                            'input' => '$$fieldItem',
                                            'regex' => $tag,
                                            'options' => 'i'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'then' => $weight * 0.1, // Lower weight for partial matches
                    'else' => 0
                ]
            ];
        }
        return $scoring;
    }
    
    /**
     * Build keyword scoring for text fields
     */
    private function buildKeywordScoring($keywords, $fields = ['title', 'description']) {
        $scoring = [];
        foreach ($keywords as $keyword) {
            foreach ($fields as $field) {
                // Handle both string and array fields
                $scoring[] = [
                    '$cond' => [
                        'if' => [
                            '$or' => [
                                // For string fields
                                [
                                    '$and' => [
                                        ['$ne' => [['$type' => "\$$field"], 'array']],
                                        [
                                            '$regexMatch' => [
                                                'input' => ['$toString' => "\$$field"],
                                                'regex' => $keyword,
                                                'options' => 'i'
                                            ]
                                        ]
                                    ]
                                ],
                                // For array fields
                                [
                                    '$and' => [
                                        ['$eq' => [['$type' => "\$$field"], 'array']],
                                        [
                                            '$anyElementTrue' => [
                                                [
                                                    '$map' => [
                                                        'input' => "\$$field",
                                                        'as' => 'item',
                                                        'in' => [
                                                            '$regexMatch' => [
                                                                'input' => ['$toString' => '$$item'],
                                                                'regex' => $keyword,
                                                                'options' => 'i'
                                                            ]
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        'then' => 2, // Increased weight for keyword matches
                        'else' => 0
                    ]
                ];
            }
        }
        return $scoring;
    }
    
    /**
     * Get popular projects as fallback
     */
    private function getPopularProjects($limit, $excludeIds = []) {
        try {
            $popularItems = $this->preferences->getPopularItems('project', $limit * 2);
            $popularIds = array_map(function($item) { return $item['_id']; }, $popularItems);
            $popularIds = array_diff($popularIds, $excludeIds);
            
            if (empty($popularIds)) {
                return $this->getFallbackProjects($limit);
            }
            
            $collection = $this->db->projectsV2;
            $cursor = $collection->find(
                [
                    '_id' => ['$in' => array_slice($popularIds, 0, $limit)],
                    'privacy' => 0
                ],
                [
                    'projection' => ['title' => 1, 'description' => 1, 'createdAt' => 1, 'members' => 1],
                    'limit' => $limit
                ]
            );
            
            return iterator_to_array($cursor);
        } catch (Exception $e) {
            return $this->getFallbackProjects($limit);
        }
    }
    
    /**
     * Fallback methods for when recommendations fail
     */
    private function getFallbackProjects($limit) {
        try {
            $collection = $this->db->projectsV2;
            $cursor = $collection->find(
                ['privacy' => 0],
                [
                    'sort' => ['createdAt' => -1],
                    'limit' => $limit,
                    'projection' => ['title' => 1, 'description' => 1, 'createdAt' => 1, 'members' => 1]
                ]
            );
            return iterator_to_array($cursor);
        } catch (Exception $e) {
            return [];
        }
    }
    
    private function getFallbackEvents($limit) {
        try {
            $collection = $this->db->events;
            $cursor = $collection->find(
                ['eventDate' => ['$gte' => new MongoDB\BSON\UTCDateTime()]],
                [
                    'sort' => ['eventDate' => 1],
                    'limit' => $limit,
                    'projection' => ['title' => 1, 'description' => 1, 'eventDate' => 1, 'eventType' => 1, 'status' => 1]
                ]
            );
            return iterator_to_array($cursor);
        } catch (Exception $e) {
            return [];
        }
    }
    
    private function getFallbackForumPosts($limit) {
        try {
            $collection = $this->db->forum_posts;
            $cursor = $collection->find(
                [],
                [
                    'sort' => ['created_at' => -1],
                    'limit' => $limit,
                    'projection' => ['title' => 1, 'content' => 1, 'user_name' => 1, 'created_at' => 1, 'upvotes' => 1, 'tags' => 1]
                ]
            );
            return iterator_to_array($cursor);
        } catch (Exception $e) {
            return [];
        }
    }
    
    private function getFallbackFaculties($limit) {
        try {
            $collection = $this->db->faculties;
            $cursor = $collection->find(
                [],
                [
                    'sort' => ['name' => 1],
                    'limit' => $limit,
                    'projection' => ['name' => 1, 'bio' => 1, 'profile_image' => 1, 'specialty' => 1]
                ]
            );
            return iterator_to_array($cursor);
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Get mixed personalized recommendations for dashboard
     */
    public function getDashboardRecommendations($userId) {
        // Check if user has enough data for personalization
        $userProfile = $this->preferences->getUserProfile($userId);
        $hasPreferences = false;
        
        if ($userProfile) {
            $interests = $userProfile['interests'] ?? [];
            if ($interests instanceof MongoDB\Model\BSONDocument) {
                $interests = iterator_to_array($interests);
            }
            
            $categories = $userProfile['preferred_categories'] ?? [];
            if ($categories instanceof MongoDB\Model\BSONDocument) {
                $categories = iterator_to_array($categories);
            }
            
            $activityScore = $userProfile['activity_score'] ?? 0;
            
            // User needs at least 2 interests or 5 activity points for personalization
            $hasPreferences = (!empty($interests) && count($interests) >= 2) || $activityScore >= 5;
            
            error_log("DEBUG: User $userId - Interests: " . count($interests) . ", Activity: $activityScore, Personalized: " . ($hasPreferences ? 'Yes' : 'No'));
        }
        
        return [
            'projects' => $this->getRecommendedProjects($userId, 6),
            'events' => $this->getRecommendedEvents($userId, 6),
            'forum_posts' => $this->getRecommendedForumPosts($userId, 6),
            'faculties' => $this->getRecommendedFaculties($userId, 8),
            'is_personalized' => $hasPreferences
        ];
    }
    
    /**
     * Get trending items across all categories
     */
    public function getTrendingItems($timeframe = 'week') {
        $trending = [];
        
        try {
            $trending['projects'] = $this->preferences->getPopularItems('project', 5, $timeframe);
            $trending['events'] = $this->preferences->getPopularItems('event', 5, $timeframe);
            $trending['forum_posts'] = $this->preferences->getPopularItems('forum_post', 5, $timeframe);
            $trending['faculties'] = $this->preferences->getPopularItems('faculty', 5, $timeframe);
        } catch (Exception $e) {
            error_log("Error getting trending items: " . $e->getMessage());
        }
        
        return $trending;
    }
}
?> 