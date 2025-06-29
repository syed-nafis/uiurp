# Preference Tracking System - Fix Summary

## 🐛 Issues Fixed

### 1. **Faculty Recommendation Algorithm Issues**
**Problem**: Faculty matching was not working properly due to complex data structure handling for `interested_fields_of_research`.

**Fix**: 
- Enhanced faculty recommendation logic in `src/model/recommendation_engine.php`
- Added support for multiple data structure formats (arrays, BSON documents, etc.)
- Implemented exact and partial matching with proper scoring weights
- Added word boundary matching for bio content
- Improved debug logging

### 2. **Enhanced Matching Algorithms**
**Problem**: Basic tag and keyword matching wasn't sophisticated enough.

**Fix**:
- Enhanced `buildTagScoring()` method with exact and partial matching
- Improved `buildKeywordScoring()` with word boundary and substring matching
- Added new `buildEventTypeScoring()` method for event-specific matching
- Updated scoring weights for better relevance

### 3. **User Preferences Processing Issues**
**Problem**: Some metadata fields weren't being processed correctly, causing interests to not update.

**Fix**:
- Enhanced `updateUserProfile()` method in `src/model/user_preferences.php`
- Added comprehensive debug logging to track each step
- Improved title-based keyword extraction
- Fixed metadata processing for all content types
- Added better error handling and logging

### 4. **JavaScript Tracking Enhancement**
**Problem**: Click tracking wasn't capturing all interactions properly.

**Fix**:
- Enhanced `assets/js/preference_tracker.js` with improved click tracking
- Added automatic element traversal to find tracking attributes
- Improved JSON parsing with error handling
- Added capture phase event handling

### 5. **Faculty Loader JSON Escaping**
**Problem**: JSON metadata in faculty cards could cause parsing errors.

**Fix**:
- Enhanced `assets/scripts/faculty_loader.js` with proper JSON escaping
- Added delay for preference tracking before navigation
- Improved error handling

## 🎯 Content Type Matching Details

### **Projects** ✅
- **Fields Used**: `keywords`, `tags`, `title`, `category`, `field`
- **Matching Logic**: Keywords field + tag-based scoring + title analysis
- **Debug**: Logs keyword extraction and tag processing

### **Events** ✅  
- **Fields Used**: `tags`, `eventType`, `title`, `description`, `organizer`
- **Matching Logic**: Tags field + event type scoring + keyword analysis
- **Debug**: Logs tag processing and event type matching

### **Forum Posts** ✅
- **Fields Used**: `tags`, `title`, `content`, `author`, `upvotes`
- **Matching Logic**: Tags field + content analysis + engagement boost
- **Debug**: Logs tag processing and content analysis

### **Faculties** ✅
- **Fields Used**: `interested_fields_of_research`, `bio`, `specialty`, `name`
- **Matching Logic**: Research interests + specialty + bio analysis with multiple data structure support
- **Debug**: Logs field extraction and scoring details

## 🧪 Testing Instructions

### **1. Use the Enhanced Test Page**
```bash
# Visit the test page
http://your-domain/test_preference_tracking.php
```

This will:
- Test all 4 content types with proper metadata
- Show detailed interest analysis with scores
- Display category preferences
- Show recent interactions with full metadata
- Test recommendation engine with scoring

### **2. Check Debug Logs**
```bash
# Check server error logs for detailed tracking information
tail -f /path/to/error.log | grep "DEBUG:"
```

Look for log entries like:
- `DEBUG: Tracking interaction`
- `DEBUG: Processing tags`
- `DEBUG: Added/updated interest`
- `DEBUG: Final interests count`

### **3. Manual Testing Steps**

1. **Login** to the system as any user
2. **Click on different content types**:
   - Visit `events.php` and click on event cards
   - Visit `Faculty_Page.php` and click on faculty cards  
   - Visit `view_posts.php` and click on forum posts
   - Visit `Research_page.php` and click on project cards

3. **Check the dashboard debug overlay** (if available) or visit `test_preference_tracking.php`

4. **Verify interests are updating**:
   - Each click should add/update interests based on content metadata
   - Activity score should increase with each interaction
   - Category preferences should update

### **4. Browser Console Verification**
```javascript
// Open browser console and look for:
// "Preference Tracker: Tracking [type] click:"
// "Preference Tracker: Parsed metadata:"
```

## 📊 Expected Results

After clicking on content, you should see:

### **Interests Updated**:
- **Projects**: AI, Machine Learning, Research, Computer Science
- **Events**: Conference, Workshop, Seminar, Technology  
- **Forum Posts**: Discussion, Deep Learning, Neural Networks
- **Faculties**: Computer Science, Faculty, Research fields

### **Categories Updated**:
- `project: [score]`
- `event: [score]`  
- `forum_post: [score]`
- `faculty: [score]`

### **Activity Score**: Should increase with each interaction

## 🔧 Scoring System

### **Interaction Weights**:
- `view`: 1 point
- `click`: 2 points  
- `search`: 3 points
- `like`: 4 points
- `comment`: 5 points

### **Interest Scoring**:
- **Exact tag match**: Full weight (2.0x for clicks)
- **Partial tag match**: Half weight (1.0x for clicks)
- **Keyword extraction**: 0.3x weight
- **Research interests**: Full weight
- **Specialty match**: Full weight
- **Event type match**: 0.3x weight

## 🚨 Troubleshooting

### **If interests still not updating**:

1. **Check if user is logged in**: Only logged-in users have tracking
2. **Verify tracking attributes**: Elements should have `data-item-type`, `data-item-id`, and `data-tracking-metadata`
3. **Check browser console** for JavaScript errors
4. **Check server logs** for PHP errors or debug messages
5. **Run test page** to verify core functionality

### **If recommendations not working**:

1. **Build up profile first**: Need at least 2 interests or 5 activity points
2. **Check data exists**: Ensure content exists in MongoDB collections
3. **Verify collection names**: `projects`, `projectsV2`, `events`, `forum_posts`, `faculties`
4. **Check debug logs** for recommendation scoring details

## ✅ Success Indicators

The system is working correctly when you see:

1. **Activity score increasing** with each click
2. **New interests appearing** based on clicked content
3. **Category preferences updating** for each content type
4. **Debug logs showing** metadata processing
5. **Recommendations becoming personalized** after sufficient interactions

The preference tracking system should now work comprehensively across all content types with proper interest updating and personalized recommendations! 