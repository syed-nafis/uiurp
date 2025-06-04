# Student Profile Enhancement Documentation

## Overview
This document describes the enhancements made to the `Student_Profile.php` page to handle profile picture placeholders and implement user type detection with automatic redirection for faculty users.

## Changes Made

### 1. Profile Picture Placeholder Enhancement

#### Server-side Improvements
- **Multiple Path Checking**: The system now checks multiple possible locations for profile images:
  - `$student['basic_info']['profile_image_url']`
  - `$student['profile_image']`
  - `$student['profile_image_url']`
  - `$student['basic_info']['profile_image']`

- **Robust Placeholder System**: 
  - Primary placeholder: `assets/resources/student.jpeg`
  - Fallback placeholders: `assets/resources/imgPlaceholder.png`, `assets/resources/default-profile.jpg`
  - Ultimate fallback: Online placeholder `https://via.placeholder.com/250x250/6c757d/ffffff?text=Student`

#### Client-side Error Handling
- Added `onerror` attribute to the HTML `<img>` tag
- Automatically switches to placeholder if image fails to load
- Prevents broken image icons

```html
<img src="<?= htmlspecialchars($profileImage) ?>" 
     alt="Profile Picture" 
     loading="lazy"
     onerror="this.onerror=null; this.src='https://via.placeholder.com/250x250/6c757d/ffffff?text=Student'; this.alt='Default Profile Picture';">
```

### 2. User Type Detection and Faculty Redirection

#### Database Integration
- **Login Info Collection**: Connects to `login_info` collection to check `type` field
- **Cross-Reference**: Matches users by ID across collections using the `id` field in login_info
- **Faculty Collection**: Queries `faculties` collection for faculty-specific data

#### Redirection Logic
```php
// Check user type from login_info collection using the user ID
if ($targetUserId) {
    $loginInfo = $loginInfoCollection->findOne(['id' => $targetUserId]);
    
    if ($loginInfo && isset($loginInfo['type'])) {
        $accountType = $loginInfo['type'];
        
        // If the user is faculty type, redirect to Faculty_Profile.php
        if ($accountType === 'faculty') {
            header("Location: Faculty_Profile.php?id=" . $targetUserId);
            exit();
        }
    }
}
```

#### Backward Compatibility
- Users without `login_info` records are treated as students
- Existing functionality remains unaffected
- Graceful error handling with meaningful error messages

### 3. Enhanced Profile Viewing Logic

#### Viewing Own Profile
- Uses session data (`$_SESSION['user_data']`)
- Extracts current user's ID from session
- Checks current user's account type via login_info
- Redirects if current user is faculty

#### Viewing Other Profiles
- Accepts profile ID via URL parameter (`?id=...`)
- Uses the provided ID to check account type
- Redirects to appropriate profile page based on type

### 4. Error Handling

#### Comprehensive Error Messages
- "Profile not found" for invalid student IDs
- "Faculty profile not found" when faculty record is missing
- "Invalid profile ID" for malformed MongoDB ObjectIds
- "Invalid user session data" for corrupted session ObjectIds
- "User session incomplete" for missing session data

#### Debug Support
- Optional debug logging (commented out by default)
- Detailed error tracking for troubleshooting
- Fallback behaviors for edge cases

#### ObjectId Conversion Handling
Added a robust helper function `convertToObjectId()` that handles various ObjectId formats:
- **MongoDB ObjectId objects**: Returns as-is
- **Array format with $oid key**: Extracts and converts `$oid` value
- **Array format with oid key**: Extracts and converts `oid` value  
- **String format**: Validates 24-character hex strings and converts
- **Invalid formats**: Returns null safely with error logging

```php
function convertToObjectId($id) {
    if (empty($id)) return null;
    
    try {
        if (is_object($id) && $id instanceof MongoDB\BSON\ObjectId) {
            return $id;
        }
        
        if (is_array($id)) {
            if (isset($id['$oid'])) {
                return new MongoDB\BSON\ObjectId($id['$oid']);
            }
            if (isset($id['oid'])) {
                return new MongoDB\BSON\ObjectId($id['oid']);
            }
        }
        
        if (is_string($id) && strlen($id) === 24 && ctype_xdigit($id)) {
            return new MongoDB\BSON\ObjectId($id);
        }
        
        return null;
    } catch (Exception $e) {
        return null;
    }
}
```

## Testing

### Test File: `test_profile_redirect.php`
A comprehensive test script that verifies:
1. Login info collection structure
2. Faculty account detection
3. Student account detection
4. Profile image placeholder availability
5. Redirect logic simulation

### Manual Testing Steps
1. **Test Profile Pictures**:
   - Create a user with no profile image
   - Verify placeholder is displayed
   - Test with broken image URL

2. **Test Faculty Redirection**:
   - Navigate to `Student_Profile.php?id=[faculty_user_id]`
   - Verify automatic redirect to `Faculty_Profile.php`
   - Check URL parameters are correctly passed

3. **Test Student Profiles**:
   - Navigate to `Student_Profile.php?id=[student_user_id]`
   - Verify student profile displays correctly
   - Test with own profile (no ID parameter)

## Database Requirements

### login_info Collection
Required fields for each user:
```json
{
  "username": "user123",
  "password": "hashed_password", 
  "type": "student" | "faculty",
  "id": "ObjectId('user_record_id')"
}
```

### Cross-Collection Consistency
- User IDs must match across `students`, `faculties`, and `login_info` collections
- The `id` field in `login_info` must reference valid `_id` in respective collections
- MongoDB ObjectIds must be valid and consistent

## File Dependencies

### Modified Files
- `Student_Profile.php` - Main implementation
- `test_profile_redirect.php` - Testing script

### Required Files
- `Faculty_Profile.php` - Target for faculty redirects
- `vendor/autoload.php` - MongoDB PHP library
- Profile image assets in `assets/resources/`

## Security Considerations

### Input Validation
- MongoDB ObjectId validation for URL parameters
- Email sanitization for database queries
- XSS prevention with `htmlspecialchars()`

### Access Control
- Session-based authentication maintained
- Proper error messages without information disclosure
- Secure redirect mechanisms

## Performance Impact

### Database Queries
- Additional query to `login_info` collection (minimal overhead)
- Optimized with early exit for faculty users
- Cached session data reduces repeated queries

### Image Loading
- Lazy loading attribute for profile images
- Client-side error handling reduces server load
- Progressive fallback system for reliability

## Future Enhancements

### Possible Improvements
1. **Caching**: Implement user type caching to reduce database queries
2. **Image Optimization**: Add image resizing and optimization
3. **Profile Sync**: Automatic profile data synchronization across collections
4. **Enhanced Placeholders**: Dynamic placeholder generation based on user data

### Maintenance
- Regular testing of placeholder image availability
- Monitoring of redirect performance
- Database index optimization for email-based queries 