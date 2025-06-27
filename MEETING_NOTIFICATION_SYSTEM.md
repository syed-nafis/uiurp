# Enhanced Meeting Notification System

## Overview
The Enhanced Meeting Notification System automatically sends system messages to project group chats for various meeting scenarios. It runs continuously in the background on all pages and provides comprehensive meeting awareness including meetings starting soon, currently happening, and scheduled for today.

## How It Works

### 1. **Global Background Operation**
- Runs automatically on **ALL pages** (not just project pages)
- Continuous background checks every 3 minutes
- Smart project ID detection from URL parameters and page content
- Automatic activation when users switch back to browser tabs

### 2. **Multi-Scenario Detection**
- **Urgent Notifications**: Meetings starting in 5 minutes
- **Live Notifications**: Meetings currently happening  
- **Daily Reminders**: All meetings scheduled for today
- **Browser Notifications**: Desktop alerts when supported

### 3. **Smart Notifications**
- Notifications are sent only once per meeting per scenario type
- Uses the existing system message infrastructure
- Messages include meeting title, time, date, and clickable join links
- Different message styles for different scenarios

### 3. **Database Collections Used**
- `project_meetings` - Contains meeting data
- `project_chat_messages` - Where system messages are sent
- `meeting_notifications` - Tracks sent notifications (prevents duplicates)

## Files Involved

### Core Files
- `src/model/send_meeting_notifications.php` - Main notification engine with scenario support
- `src/model/send_system_chat_message_helper.php` - Enhanced with meeting-specific functions
- `assets/js/global-meeting-notifications.js` - Global background notification client
- `src/includes/global-meeting-notifications.php` - Easy include for any page

### Key Functions
- `checkAndSendMeetingNotifications($projectId, $notificationType)` - Multi-scenario notification engine
- `sendScenarioNotification($scenarioType, $meeting, $projectId)` - Scenario-specific messaging
- `GlobalMeetingNotifications` - JavaScript class for background operation
- `sendDailyMeetingReminder()` - Today's meeting notifications

## Meeting Collection Structure
```json
{
  "_id": ObjectId,
  "projectId": ObjectId,
  "title": "Meeting Title",
  "description": "Meeting Description", 
  "date": "2025-01-26",
  "startTime": "14:30",
  "endTime": "15:30",
  "meetingLink": "http://localhost:3000/Project_details.php?joinMeeting=abc-def-ghi",
  "type": "Project Meeting",
  "organizer": ObjectId,
  "attendees": [],
  "status": "Scheduled",
  "createdAt": UTCDateTime,
  "updatedAt": UTCDateTime
}
```

## System Message Structure
```json
{
  "_id": ObjectId,
  "projectId": ObjectId,
  "sender": {
    "name": "System",
    "userType": "system"
  },
  "message": "🔔 **Meeting Starting Soon!** 📅\n\n**\"Meeting Title\"** starts at **2:30 PM** on Jan 26, 2025 (in 5 minutes)\n\n🔗 **[Join Meeting](meeting-link)**\n\n⏰ Please prepare to join the meeting. Access is available 5 minutes before the scheduled time.",
  "timestamp": UTCDateTime,
  "isSystemMessage": true
}
```

## Notification Logic

### Timing
- Notifications sent when meeting starts in **5 minutes**
- Time comparison uses current server time vs meeting date/time
- Only applies to meetings with status ≠ "Cancelled"

### Duplicate Prevention
- `meeting_notifications` collection tracks sent notifications
- One notification per meeting per day maximum
- Old notification records cleaned up after 7 days

### Query Logic
```php
$query = [
    'date' => $currentDate,
    'status' => ['$ne' => 'Cancelled'],
    'startTime' => [
        '$gte' => $currentTime,
        '$lte' => $notificationTimeStr  // currentTime + 5 minutes
    ]
];
```

## Integration Points

### Project_details.php Integration
```javascript
// Runs every 2 minutes
function checkMeetingNotifications() {
    fetch('src/model/send_meeting_notifications.php', {
        method: 'POST',
        body: JSON.stringify({ projectId: projectId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.notifications_sent > 0) {
            // Refresh chat to show new system messages
            loadChatMessages();
        }
    });
}
```

### API Endpoints
- `GET/POST src/model/send_meeting_notifications.php` - Run notification check
  - Parameters: `projectId` (optional), `notificationType` (urgent/live/daily/all)
- `GET src/model/send_meeting_notifications.php?cleanup=true` - Cleanup old records

### Page Integration
Simply add this line before closing `</body>` tag:
```php
<?php include 'src/includes/global-meeting-notifications.php'; ?>
```

### JavaScript API
```javascript
// Manual notification check
window.globalMeetingNotifications.triggerCheck();

// Update project ID for focused notifications
window.globalMeetingNotifications.setProjectId('your-project-id');

// Listen for notification events
document.addEventListener('meetingNotificationsProcessed', function(event) {
    console.log('Notifications processed:', event.detail);
});
```

## Message Formatting

### Urgent Notification (5 minutes before)
```
🔔 **Meeting Starting Soon!** 📅

**"Weekly Team Standup"** starts at **2:30 PM** on Sunday, Jan 26, 2025 (in 5 minutes)

🔗 **[Join Meeting](meeting-link)**

⏰ Please prepare to join the meeting. Access is available 5 minutes before the scheduled time.
```

### Live Meeting Notification (currently happening)
```
🚀 **Meeting is Now Live!** 🎯

**"Weekly Team Standup"** has started!

🔗 **[Join Now](meeting-link)**

📞 Don't keep the team waiting - join the meeting now!
```

### Daily Meeting Reminder (morning notification)
```
📅 **Meeting Scheduled Today!** 🗓️

**"Weekly Team Standup"**
⏰ **Time:** 2:30 PM - 3:30 PM
📆 **Date:** Sunday, Jan 26, 2025

🔗 **[Meeting Link](meeting-link)**

📝 **Reminder:** Don't forget about your meeting today! You'll receive another notification 5 minutes before it starts.
```

### All Message Types Available
- `sendMeetingNotificationMessage()` - 5-minute urgent warning
- `sendMeetingStartedMessage()` - Live meeting alert
- `sendDailyMeetingReminder()` - Today's meetings overview
- `sendMeetingReminderMessage()` - Flexible timing reminder

## Testing

### Test Script
Run `test_meeting_notifications.php` to:
- Check database connectivity
- View upcoming meetings
- Test notification logic
- Verify time calculations

### Manual Testing
1. Create a meeting starting in 6 minutes
2. Wait 1 minute
3. Visit or refresh `Project_details.php`
4. Check project chat for system message

## Configuration

### Timing Settings
- **Urgent Window**: 5 minutes before meeting starts
- **Live Detection**: Currently happening meetings
- **Daily Reminder**: All meetings scheduled for today (sent once in morning)
- **Check Interval**: Every 3 minutes (global background)
- **Cleanup Period**: 7 days for old notification records

### Customization
- Modify notification scenarios in `send_meeting_notifications.php`
- Change message formats in `send_system_chat_message_helper.php`
- Adjust check interval in `global-meeting-notifications.js`
- Enable/disable browser notifications per user preference

### Notification Types
- `'urgent'` - Only 5-minute warnings
- `'live'` - Only currently happening meetings
- `'daily'` - Only today's meeting reminders
- `'all'` - All notification types (default)

## Error Handling

### Common Issues
- **Database Connection**: Falls back gracefully
- **Invalid Meeting Data**: Skips problematic meetings  
- **Missing Meeting Links**: Sends notification without link
- **Time Zone Issues**: All times stored in server timezone

### Logging
- Errors logged to MongoDB results
- Success metrics tracked per execution
- Console logging in browser for debugging

## Maintenance

### Automatic Cleanup
- Old notification records (>7 days) auto-deleted
- No manual maintenance required
- Prevents database bloat

### Monitoring
- Check `meeting_notifications` collection size
- Monitor error counts in API responses
- Verify notification delivery in project chats

## Future Enhancements

### Possible Improvements
- Multiple notification times (15 min, 5 min, 1 min warnings)
- Email/SMS integration
- Meeting attendance tracking
- Timezone-aware notifications
- Custom notification preferences per user

### Advanced Features
- Meeting analytics and reporting
- Integration with external calendar systems
- Automatic meeting recording triggers
- Post-meeting follow-up messages 