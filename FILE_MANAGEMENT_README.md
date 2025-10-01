# File Management System Documentation

## Overview

This project has been upgraded with a comprehensive, secure file management system that provides:

- **Secure File Access Control** - Files are protected and only accessible by authorized users
- **Download Proxy** - All file downloads go through a secure proxy with authentication
- **File Validation** - Comprehensive validation of file types, sizes, and MIME types
- **Centralized Management** - Consistent file handling across the application
- **Audit Logging** - All file access is logged for security auditing

## Architecture

### Components

1. **FileConfig.php** - Centralized configuration for file validation rules
2. **FileAccessControl.php** - Manages user authorization for file access
3. **FileUploadHandler.php** - Handles file uploads with validation
4. **download.php** - Secure download proxy with access control
5. **.htaccess files** - Prevents direct access to storage folders

### Security Features

#### Protected Directories

The following directories are now protected from direct web access:

- `storage/` - Project files and media
- `uploads/` - Chat files, forum attachments, profile images

All files in these directories **MUST** be accessed through `download.php`.

#### Access Control

Files are protected based on:

- **Project Files**: Accessible only to project members, supervisors, and creators
- **Chat Files**: Accessible only to project participants
- **Forum Attachments**: Accessible to all logged-in users
- **Profile Images**: Publicly accessible

#### Authentication

- All file downloads require an active user session
- User ID is extracted from PHP session
- Unauthorized access attempts are logged

## File Upload

### Using FileUploadHandler

The new `FileUploadHandler` class provides a consistent, validated way to upload files:

```php
<?php
require_once 'src/model/FileUploadHandler.php';
require_once 'src/model/FileConfig.php';

use UIURP\Model\FileUploadHandler;
use UIURP\Model\FileConfig;

// Initialize handler
$uploadHandler = new FileUploadHandler();

// Define upload directory and options
$uploadDir = FileConfig::DIR_PROJECT_FILES;
$options = [
    'prefix' => 'file',              // Filename prefix
    'requiredType' => 'document',    // Optional: restrict to specific type
    'maxSize' => 26214400            // Optional: custom max size (25MB)
];

// Handle single file upload
$result = $uploadHandler->handleUpload($_FILES['file'], $uploadDir, $options);

if ($result['success']) {
    $fileData = $result['fileData'];
    // Contains: name, path, size, type, category, extension, iconClass, uploadedAt
} else {
    $errorMessage = $result['message'];
}
```

### Allowed File Types

#### Documents (Max 25MB)
- PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, CSV, ODT, RTF

#### Images (Max 5MB)
- JPG, JPEG, PNG, GIF, SVG, WEBP, BMP

#### Videos (Max 100MB)
- MP4, AVI, MOV, WMV, FLV, WEBM, MKV

#### Audio (Max 10MB)
- MP3, WAV, OGG, FLAC, AAC, M4A

#### Archives (Max 50MB)
- ZIP, RAR, 7Z, TAR, GZ

### Validation

File validation includes:

1. **Upload Error Checking** - Detects PHP upload errors
2. **File Size Validation** - Enforces size limits per file type
3. **MIME Type Validation** - Verifies actual file type using `finfo`
4. **Extension Validation** - Checks file extension against whitelist
5. **Zero-byte Detection** - Prevents empty file uploads

## File Download

### Using Download Proxy

All file downloads should use the secure download proxy:

```html
<!-- Old (Direct Access - NO LONGER WORKS) -->
<a href="/storage/files/myfile.pdf">Download</a>

<!-- New (Secure Proxy) -->
<a href="/download.php?file=storage/files/myfile.pdf">Download</a>

<!-- Inline Display (for PDFs, images, videos) -->
<a href="/download.php?file=storage/files/myfile.pdf&inline=1">View</a>
```

### JavaScript Download

```javascript
// Download with proper URL encoding
function downloadFile(filePath) {
    const encodedPath = encodeURIComponent(filePath);
    window.location.href = `/download.php?file=${encodedPath}`;
}

// Or fetch for more control
async function downloadFile(filePath) {
    try {
        const response = await fetch(`/download.php?file=${encodeURIComponent(filePath)}`);
        
        if (!response.ok) {
            throw new Error('Download failed: ' + response.statusText);
        }
        
        const blob = await response.blob();
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filePath.split('/').pop();
        a.click();
        window.URL.revokeObjectURL(url);
    } catch (error) {
        console.error('Download error:', error);
        alert('Failed to download file: ' + error.message);
    }
}
```

## Migration Guide

### Updating Existing Upload Handlers

To update an existing upload handler to use the new system:

1. **Add required imports:**
```php
require_once __DIR__ . '/FileUploadHandler.php';
require_once __DIR__ . '/FileConfig.php';

use UIURP\Model\FileUploadHandler;
use UIURP\Model\FileConfig;
```

2. **Replace manual upload logic with FileUploadHandler:**
```php
// Old code
$file = $_FILES['file'];
$fileName = $file['name'];
$targetPath = 'uploads/' . uniqid() . '_' . $fileName;
move_uploaded_file($file['tmp_name'], $targetPath);

// New code
$uploadHandler = new FileUploadHandler();
$result = $uploadHandler->handleUpload(
    $_FILES['file'], 
    'uploads/', 
    ['prefix' => 'file']
);

if ($result['success']) {
    $fileData = $result['fileData'];
    $targetPath = $fileData['path'];
}
```

3. **Remove manual validation:**
All validation is now handled by `FileConfig::validateFile()` inside `FileUploadHandler`.

### Updating Frontend Download Links

Search for all direct file links in your HTML/PHP files and update them:

```bash
# Find files with direct storage/uploads links
grep -r 'href="storage/' .
grep -r 'href="uploads/' .
grep -r "href='storage/" .
grep -r "href='uploads/" .
```

Replace with download proxy:

```php
// Old
<a href="<?= $file['path'] ?>">Download</a>

// New
<a href="/download.php?file=<?= urlencode(ltrim($file['path'], '/')) ?>">Download</a>
```

## File Paths

### Storage Structure

```
/uiurp/
├── storage/
│   ├── .htaccess (denies direct access)
│   ├── files/
│   │   ├── file_*.* (project files)
│   │   └── literature review/
│   │       └── {projectId}/
│   │           └── lit_*.pdf
│   └── media/
│       └── media_*.* (images/videos)
├── uploads/
│   ├── .htaccess (denies direct access)
│   ├── chat_files/
│   │   └── {projectId}/
│   │       └── chat_file_*.*
│   ├── forum_attachments/
│   │   └── forum_*.*
│   └── profile_images/
│       └── *.jpg|png
└── download.php (secure download proxy)
```

### Path Format

- Store paths in database **WITH** leading slash: `/storage/files/file.pdf`
- Or **WITHOUT** leading slash: `storage/files/file.pdf`
- Download proxy handles both formats

## Configuration

### Adjusting File Size Limits

Edit `src/model/FileConfig.php`:

```php
const MAX_FILE_SIZE_DOCUMENT = 26214400; // 25MB
const MAX_FILE_SIZE_IMAGE = 5242880;     // 5MB
const MAX_FILE_SIZE_VIDEO = 104857600;   // 100MB
```

### Adding New File Types

Edit `src/model/FileConfig.php`, add to `$allowedTypes` array:

```php
'newtype' => [
    'extensions' => ['ext1', 'ext2'],
    'mime_types' => ['application/x-newtype'],
    'max_size' => self::MAX_FILE_SIZE_DEFAULT,
    'icon_class' => 'bi-file-earmark'
]
```

## Security Audit

### File Access Logging

All file access is logged in the `file_access_log` collection:

```javascript
// MongoDB query to view access logs
db.file_access_log.find({
    success: false  // View unauthorized access attempts
}).sort({ timestamp: -1 })
```

Log entries include:
- User ID
- File path
- Action (download, view, etc.)
- Success/failure
- IP address
- User agent
- Timestamp

### Security Best Practices

1. **Never expose file paths directly** - Always use download proxy
2. **Validate user permissions** - Check project membership before allowing access
3. **Sanitize file paths** - Prevent directory traversal attacks
4. **Log access attempts** - Monitor for suspicious activity
5. **Regular audits** - Review access logs periodically

## Troubleshooting

### Files not downloading

1. Check `.htaccess` files are in place in `storage/` and `uploads/`
2. Verify Apache `mod_authz_core` is enabled
3. Check file permissions (should be 644 for files, 755 for directories)

### Permission Denied Errors

1. Verify user is logged in (`$_SESSION['user_id']` is set)
2. Check user is a project member/supervisor/creator
3. Review access logs in `file_access_log` collection

### Upload Failures

1. Check PHP upload limits in `php.ini`:
   - `upload_max_filesize`
   - `post_max_size`
   - `memory_limit`
2. Verify directory permissions (755 for upload directories)
3. Check validation errors in response message

### 500 Errors

1. Check PHP error logs
2. Verify MongoDB connection is working
3. Ensure all required files are included
4. Check file paths in FileConfig match actual directories

## API Reference

### FileConfig

- `validateFile($file, $requiredType, $maxSize)` - Validate uploaded file
- `generateUniqueFileName($originalName, $prefix)` - Generate unique filename
- `formatFileSize($bytes)` - Format file size for display
- `ensureDirectoryExists($directory)` - Create directory if needed
- `getAllowedTypes($category)` - Get allowed file types
- `getIconClass($category, $extension)` - Get Bootstrap icon class

### FileAccessControl

- `checkFileAccess($filePath, $userId)` - Check if user can access file
- `logFileAccess($userId, $filePath, $action, $success)` - Log file access

### FileUploadHandler

- `handleUpload($file, $uploadDir, $options)` - Upload single file
- `handleMultipleUploads($files, $uploadDir, $options)` - Upload multiple files
- `deleteFile($filePath)` - Delete a file
- `getFileInfo($filePath)` - Get file information

## Support

For issues or questions about the file management system, please:

1. Check this documentation
2. Review error logs
3. Check MongoDB access logs
4. Contact the development team

## Changelog

### Version 1.0 (Current)

- Initial implementation of secure file management system
- Added FileConfig for centralized validation
- Added FileAccessControl for permission checking
- Created download.php secure proxy
- Protected storage and uploads directories with .htaccess
- Added comprehensive file upload validation
- Implemented audit logging for file access
