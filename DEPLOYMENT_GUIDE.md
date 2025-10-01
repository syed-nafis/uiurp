# File Management System - Deployment Guide

## Pre-Deployment Checklist

### 1. Verify All Files Are in Place

```bash
# Core classes
ls -la src/model/FileConfig.php
ls -la src/model/FileAccessControl.php
ls -la src/model/FileUploadHandler.php

# Download proxy
ls -la download.php

# Security files
ls -la storage/.htaccess
ls -la uploads/.htaccess

# Helper files
ls -la migration_helper.php
ls -la assets/js/download-helper.js

# Documentation
ls -la FILE_MANAGEMENT_README.md
ls -la IMPLEMENTATION_SUMMARY.md
ls -la DEPLOYMENT_GUIDE.md
```

### 2. Check PHP Configuration

Ensure your PHP settings support the file sizes you need:

```bash
# Check current PHP settings
php -i | grep upload_max_filesize
php -i | grep post_max_size
php -i | grep memory_limit
```

Update if needed in `php.ini`:
```ini
upload_max_filesize = 100M
post_max_size = 101M
memory_limit = 512M
max_execution_time = 300
max_input_time = 300
```

### 3. Verify Directory Permissions

```bash
# Ensure directories are writable
chmod 755 storage/
chmod 755 storage/files/
chmod 755 storage/media/
chmod 755 uploads/
chmod 755 uploads/chat_files/
chmod 755 uploads/forum_attachments/
chmod 755 uploads/profile_images/

# Ensure .htaccess files are readable
chmod 644 storage/.htaccess
chmod 644 uploads/.htaccess
```

### 4. Test MongoDB Connection

```bash
php -r "
require_once 'vendor/autoload.php';
require_once 'src/model/db_connect.php';
try {
    \$client = connectToDatabase();
    \$db = \$client->uiurp;
    echo 'MongoDB connection: SUCCESS\n';
    echo 'Database: ' . \$db->getDatabaseName() . '\n';
} catch (Exception \$e) {
    echo 'MongoDB connection: FAILED - ' . \$e->getMessage() . '\n';
}
"
```

## Deployment Steps

### Step 1: Backup Current System

```bash
# Create backup directory
mkdir -p backups/pre-file-system-$(date +%Y%m%d)

# Backup current files
cp -r storage/ backups/pre-file-system-$(date +%Y%m%d)/
cp -r uploads/ backups/pre-file-system-$(date +%Y%m%d)/

# Backup database
# (Use MongoDB backup tools or export relevant collections)
mongodump --uri="mongodb+srv://..." --out=backups/pre-file-system-$(date +%Y%m%d)/db
```

### Step 2: Deploy New Files

All new files are already in place. Verify with the checklist above.

### Step 3: Update Existing Upload Endpoints

For each upload endpoint in `src/model/` and `src/controller/`, update to use the new system:

```bash
# Find all files with move_uploaded_file
grep -r "move_uploaded_file" src/model/ src/controller/
```

Update each one following the pattern in `src/model/upload_chat_file.php` (already updated).

**Template for updating:**

```php
// Add at top
require_once __DIR__ . '/FileUploadHandler.php';
require_once __DIR__ . '/FileConfig.php';
use UIURP\Model\FileUploadHandler;
use UIURP\Model\FileConfig;

// Replace manual upload logic with:
$uploadHandler = new FileUploadHandler();
$result = $uploadHandler->handleUpload(
    $_FILES['file'], 
    FileConfig::DIR_PROJECT_FILES,  // or appropriate directory
    ['prefix' => 'file']
);

if ($result['success']) {
    $fileData = $result['fileData'];
    // Use $fileData['path'], $fileData['size'], etc.
}
```

### Step 4: Test Uploads

Test each upload endpoint:

```bash
# Project file upload
curl -X POST http://your-domain/src/model/upload_file_improved.php \
  -F "projectId=..." \
  -F "files=@test.pdf" \
  -H "Cookie: PHPSESSID=..."

# Chat file upload
curl -X POST http://your-domain/src/model/upload_chat_file.php \
  -F "projectId=..." \
  -F "file=@test.pdf" \
  -H "Cookie: PHPSESSID=..."
```

### Step 5: Test Downloads

Test the download proxy:

```bash
# Test authenticated download
curl -v "http://your-domain/download.php?file=storage/files/test.pdf" \
  -H "Cookie: PHPSESSID=..." \
  -o downloaded.pdf

# Test unauthenticated (should fail)
curl -v "http://your-domain/download.php?file=storage/files/test.pdf"

# Test unauthorized access (should fail)
curl -v "http://your-domain/download.php?file=storage/files/project-x-file.pdf" \
  -H "Cookie: PHPSESSID=different-user"
```

### Step 6: Test Direct Access Protection

```bash
# These should return 403 Forbidden
curl -v "http://your-domain/storage/files/test.pdf"
curl -v "http://your-domain/uploads/chat_files/123/file.pdf"
```

If they return the file instead of 403, check:
1. `.htaccess` files are in place
2. Apache `mod_authz_core` module is enabled
3. `.htaccess` is allowed (`AllowOverride All` in Apache config)

### Step 7: Verify Access Control

Test different access scenarios:

1. **Project Member** - Should access project files ✓
2. **Non-Member** - Should NOT access project files ✗
3. **Supervisor** - Should access project files ✓
4. **Guest/Logged Out** - Should NOT access any files ✗

### Step 8: Check Audit Logs

```javascript
// Connect to MongoDB and verify logging
use uiurp;
db.file_access_log.find().sort({ timestamp: -1 }).limit(10);

// Should see entries like:
// {
//     userId: ObjectId("..."),
//     filePath: "storage/files/...",
//     action: "download",
//     success: true,
//     timestamp: ISODate("..."),
//     ipAddress: "...",
//     userAgent: "..."
// }
```

### Step 9: Load Testing (Optional)

If you have high traffic, test concurrent downloads:

```bash
# Using Apache Bench
ab -n 100 -c 10 -C "PHPSESSID=..." \
  "http://your-domain/download.php?file=storage/files/test.pdf"
```

Monitor:
- Response times
- Memory usage
- CPU usage
- MongoDB connections

### Step 10: Update Frontend Links (if needed)

If you haven't updated all frontend files yet:

```bash
# Run migration helper
php migration_helper.php

# Update any files it identifies
# Example update:
# OLD: <a href="<?= $file['path'] ?>">Download</a>
# NEW: <a href="/download.php?file=<?= urlencode(ltrim($file['path'], '/')) ?>">Download</a>
```

## Post-Deployment Verification

### Functional Tests

- [ ] Upload new file (various types)
- [ ] Download existing file
- [ ] View file inline (PDF, image)
- [ ] Stream video file
- [ ] Delete file (if applicable)
- [ ] Upload oversized file (should reject)
- [ ] Upload invalid file type (should reject)

### Security Tests

- [ ] Access file as authorized user (should work)
- [ ] Access file as unauthorized user (should fail)
- [ ] Direct URL access (should fail)
- [ ] Download without authentication (should fail)
- [ ] Directory traversal attempt (`../../../etc/passwd`)

### Performance Tests

- [ ] Download small file (< 1MB)
- [ ] Download large file (> 50MB)
- [ ] Concurrent downloads (10+ users)
- [ ] Video streaming with seeking
- [ ] Upload multiple files

### Logging Tests

- [ ] Check MongoDB for access logs
- [ ] Verify failed attempts are logged
- [ ] Verify successful downloads are logged
- [ ] Check IP and user agent capture

## Rollback Plan

If something goes wrong:

### Emergency Rollback

```bash
# Stop web server
sudo systemctl stop apache2  # or nginx

# Restore files from backup
rm -rf storage/ uploads/
cp -r backups/pre-file-system-YYYYMMDD/storage/ ./
cp -r backups/pre-file-system-YYYYMMDD/uploads/ ./

# Remove .htaccess files (restore direct access)
rm storage/.htaccess
rm uploads/.htaccess

# Restore old upload handlers if backed up
# ...

# Restart web server
sudo systemctl start apache2
```

### Partial Rollback

If only specific features are problematic:

1. **Keep security layer but allow direct access temporarily:**
   ```bash
   # Rename .htaccess to disable
   mv storage/.htaccess storage/.htaccess.disabled
   mv uploads/.htaccess uploads/.htaccess.disabled
   ```

2. **Revert specific upload handlers:**
   ```bash
   # Restore from backup
   cp backups/pre-file-system-YYYYMMDD/src/model/upload_chat_file.php src/model/
   ```

## Monitoring

### Daily Checks

```bash
# Check error logs
tail -f /var/log/apache2/error.log | grep -i download

# Check disk usage
df -h | grep -E 'storage|uploads'

# Check access log size
db.file_access_log.count()
```

### Weekly Review

```javascript
// Top downloaded files
db.file_access_log.aggregate([
    { $match: { success: true, action: "download" } },
    { $group: { _id: "$filePath", count: { $sum: 1 } } },
    { $sort: { count: -1 } },
    { $limit: 10 }
]);

// Failed access attempts
db.file_access_log.aggregate([
    { $match: { success: false } },
    { $group: { _id: "$userId", count: { $sum: 1 } } },
    { $sort: { count: -1 } }
]);

// Storage usage by project
// (Implement custom query based on your structure)
```

## Troubleshooting

### Problem: "File not found" errors

**Solution:**
1. Check file path in database matches actual file location
2. Verify file permissions (should be 644)
3. Check MongoDB connection
4. Review error logs

### Problem: "Permission denied" errors

**Solution:**
1. Verify user is logged in (`$_SESSION['user_id']`)
2. Check user is project member/supervisor/creator
3. Review `file_access_log` for details
4. Check FileAccessControl logic

### Problem: ".htaccess not working"

**Solution:**
1. Verify Apache `mod_authz_core` is enabled:
   ```bash
   apache2ctl -M | grep authz
   ```
2. Check Apache config allows `.htaccess`:
   ```apache
   <Directory /path/to/uiurp>
       AllowOverride All
   </Directory>
   ```
3. Restart Apache:
   ```bash
   sudo systemctl restart apache2
   ```

### Problem: "Upload size limit exceeded"

**Solution:**
1. Check PHP limits:
   ```bash
   php -i | grep -E 'upload_max_filesize|post_max_size'
   ```
2. Update `php.ini` if needed
3. Restart PHP-FPM or Apache
4. Check web server limits (nginx `client_max_body_size`)

### Problem: "Slow downloads"

**Solution:**
1. Check range request support (for large files)
2. Verify chunk size in `download.php` (currently 8KB)
3. Monitor PHP memory usage
4. Consider CDN for frequently accessed files

## Production Optimization

### PHP Configuration

```ini
; php.ini optimizations
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=10000
opcache.validate_timestamps=0  ; In production

; Session handling
session.save_handler=redis  ; Or memcached
session.save_path="tcp://127.0.0.1:6379"
```

### Apache Configuration

```apache
# Enable compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css
</IfModule>

# Cache static resources
<FilesMatch "\.(jpg|jpeg|png|gif|pdf)$">
    Header set Cache-Control "max-age=3600, public"
</FilesMatch>
```

### MongoDB Indexing

```javascript
// Add indexes for better query performance
db.file_access_log.createIndex({ userId: 1, timestamp: -1 });
db.file_access_log.createIndex({ filePath: 1 });
db.file_access_log.createIndex({ timestamp: -1 });
db.projectsV2.createIndex({ "files.path": 1 });
db.projectsV2.createIndex({ "media.url": 1 });
```

## Support

- **Documentation**: `FILE_MANAGEMENT_README.md`
- **API Reference**: `IMPLEMENTATION_SUMMARY.md`
- **This Guide**: `DEPLOYMENT_GUIDE.md`

## Maintenance Schedule

- **Daily**: Monitor error logs and disk usage
- **Weekly**: Review access logs and failed attempts
- **Monthly**: Review file sizes and clean up if needed
- **Quarterly**: Security audit and performance review

---

**Deployed By**: ________________  
**Deployment Date**: ________________  
**Status**: [ ] Pre-deployment [ ] In Progress [ ] Complete [ ] Rolled Back  
**Notes**: 

_____________________________________________
_____________________________________________
_____________________________________________
