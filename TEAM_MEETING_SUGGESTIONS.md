# Team Meeting Suggestions Implementation

## Overview
This implementation integrates schedule filtering for project members and supervisors to suggest optimal meeting times when everyone on the team is available.

## Key Features

### 1. Team Schedule Analysis
- **File**: `src/model/get_project_meeting_suggestions.php`
- **Purpose**: Analyzes schedules of all project team members and supervisors
- **Functionality**: 
  - Fetches project members and supervisor from project data
  - Retrieves individual schedules for each team member
  - Identifies free time slots when everyone is available
  - Suggests meeting times in different durations (1h, 1.5h, 2h)

### 2. Meeting Modal Integration
- **File**: `Project_details.php` (updated)
- **Integration Points**:
  - Enhanced meeting modal with team-based suggestions
  - Real-time schedule analysis when dates are selected
  - Visual display of team member schedules and conflicts
  - Clickable suggestion cards for easy selection

### 3. Enhanced User Experience
- **Smart Suggestions**: Only shows times when ALL team members are free
- **Duration Options**: Multiple meeting lengths (1 hour, 1.5 hours, 2 hours)
- **Visual Feedback**: Color-coded cards based on meeting duration quality
- **Team Overview**: Shows individual member schedules and busy times
- **Conflict Resolution**: Clear indication of scheduling conflicts

## API Endpoint

### `get_project_meeting_suggestions.php`
```
GET /src/model/get_project_meeting_suggestions.php?projectId={id}&date={YYYY-MM-DD}
```

**Parameters:**
- `projectId`: The MongoDB ObjectId of the project
- `date`: Date in YYYY-MM-DD format

**Response:**
```json
{
  "success": true,
  "project": {
    "title": "Project Name",
    "id": "project_id"
  },
  "date": "2024-01-15",
  "dayOfWeek": "Monday",
  "teamMembers": [
    {
      "name": "Member Name",
      "role": "Student/Supervisor",
      "type": "member/supervisor"
    }
  ],
  "suggestions": [
    {
      "startTime": "09:00",
      "endTime": "10:00",
      "duration": 60,
      "durationText": "1h",
      "quality": "short/medium/long"
    }
  ],
  "memberConflicts": {
    "Member Name": [
      {
        "title": "Schedule Item",
        "startTime": "14:00",
        "endTime": "15:00",
        "type": "class/meeting/etc"
      }
    ]
  }
}
```

## Implementation Details

### Schedule Collection Process
1. **Project Retrieval**: Fetches project from `projectsV2` or fallback to `projects` collection
2. **Member Identification**: Extracts team members and supervisor information
3. **Schedule Fetching**: Queries `schedule` collection for each team member's availability
4. **Conflict Analysis**: Identifies busy periods for the requested day
5. **Free Slot Calculation**: Finds time periods when everyone is available

### Meeting Suggestion Algorithm
1. **Working Hours**: Defines business hours (8:00 AM - 6:00 PM)
2. **Conflict Mapping**: Maps all team member conflicts for the day
3. **Gap Analysis**: Identifies time gaps between conflicts
4. **Duration Filtering**: Suggests meetings of varying lengths based on available time
5. **Quality Scoring**: Prioritizes longer available time slots

### Frontend Integration
1. **Date Selection**: Triggers team schedule analysis via AJAX call
2. **Suggestion Display**: Renders clickable cards with meeting options
3. **Team Overview**: Shows individual member schedules and conflicts
4. **Selection Handling**: Updates form fields when suggestion is selected
5. **Visual Feedback**: Provides clear indication of selected time slot

## Usage in Project Details Page

1. **Open Meeting Modal**: Click "Schedule Meeting" button
2. **Select Date**: Choose a date from the calendar widget
3. **View Suggestions**: System automatically analyzes team schedules
4. **Review Team Status**: See individual member availability
5. **Select Time**: Click on a suggested time slot
6. **Complete Meeting**: Fill in title, description, and save

## Benefits

- **Eliminates Scheduling Conflicts**: Only suggests times when everyone is free
- **Saves Time**: Automated analysis instead of manual coordination
- **Improves Communication**: Clear visibility of team member schedules
- **Flexible Options**: Multiple duration choices for different meeting types
- **User-Friendly**: Intuitive interface with visual feedback

## Technical Requirements

- **MongoDB**: Access to `projectsV2`, `projects`, and `schedule` collections
- **PHP**: Version compatible with MongoDB driver
- **JavaScript**: Modern browser with fetch API support
- **Bootstrap**: For UI components and styling

## Future Enhancements

- Weekend meeting suggestions
- Custom working hours per team member
- Recurring meeting pattern suggestions
- Email notifications for suggested meeting times
- Integration with external calendar systems 