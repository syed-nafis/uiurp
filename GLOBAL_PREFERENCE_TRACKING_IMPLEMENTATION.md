# Global Preference Tracking & Personalized Recommendations Implementation

## 🎯 **Overview**
This implementation adds comprehensive preference tracking and personalized recommendations across all pages of the UIURP system. The system tracks user interactions, builds user preference profiles, and provides personalized content recommendations.

## 📋 **Implementation Summary**

### **Phase 1: Global Infrastructure ✅**
1. **Created Global Preference Tracking Initializer** (`src/includes/global-preference-tracker.php`)
   - Automatically tracks page views for all logged-in users
   - Initializes recommendation engine globally
   - Provides helper functions for personalized recommendations
   - Outputs JavaScript tracker on all pages

2. **Modified Global Includes**
   - **Updated `src/includes/navbar.php`**: Includes global preference tracker
   - **Updated `src/includes/footer.php`**: Outputs preference tracking scripts

### **Phase 2: Added Tracking to Main Pages ✅**

#### **Research/Projects Tracking**
- **File**: `Research_page.php`
- **Added**: `data-item-type="project"`, `data-item-id`, `data-tracking-metadata`
- **Tracks**: Project titles, categories, fields, keywords, tags

#### **Faculty Tracking**  
- **File**: `assets/scripts/faculty_loader.js`
- **Added**: `data-item-type="faculty"`, `data-item-id`, `data-tracking-metadata`
- **Tracks**: Faculty names, specialties, research interests, bio content

#### **Events Tracking**
- **File**: `events.php`
- **Added**: `data-item-type="event"`, `data-item-id`, `data-tracking-metadata`
- **Tracks**: Event titles, types, organizers, status, speakers

#### **Forum Posts Tracking**
- **File**: `view_posts.php`
- **Added**: `data-item-type="forum_post"`, `data-item-id`, `data-tracking-metadata`
- **Tracks**: Post titles, content previews, tags, authors, engagement metrics

### **Phase 3: Enhanced Metadata Extraction ✅**
- **Keywords extraction** from titles and content
- **Tags tracking** for content categorization
- **Engagement metrics** (upvotes, comments, shares)
- **Content relationships** (authors, specialties, research interests)

## 🔧 **How It Works**

### **1. Automatic Page View Tracking**
```php
// Automatically tracked when any page loads
$userPreferences->trackInteraction(
    $_SESSION['user_id'],
    'view',
    $current_page,
    'page',
    $pageMetadata
);
```

### **2. Click/Interaction Tracking**
```html
<!-- Example: Project card with tracking -->
<a href="Project_details.php?id=123" 
   data-item-type="project" 
   data-item-id="123"
   data-tracking-metadata='{"title":"AI Research","tags":["AI","Research"]}'>
   Project Title
</a>
```

### **3. Preference Profile Building**
- **Interests**: Extracted from clicked content tags and keywords
- **Categories**: Tracks preferred content types (projects, events, faculty, forum)
- **Activity Score**: Weighted based on interaction types
- **Keywords**: Analyzed from content titles and descriptions

### **4. Personalized Recommendations**
```php
// Get personalized recommendations anywhere in the system
$recommendations = getPersonalizedRecommendations('projects', 6);
$events = getPersonalizedRecommendations('events', 4);
$mixed = getPersonalizedRecommendations('mixed', 10);
```

## 🌐 **Global Integration**

### **All Pages Now Include:**
1. **Automatic preference tracking** via navbar inclusion
2. **JavaScript tracker initialization** via footer inclusion  
3. **Page view tracking** for logged-in users
4. **Personalized content suggestions** (where applicable)

### **Tracked Content Types:**
- ✅ **Projects** - Research projects and their metadata
- ✅ **Faculty** - Faculty profiles, specialties, research interests
- ✅ **Events** - University events, types, organizers
- ✅ **Forum Posts** - Discussion posts, topics, engagement
- ✅ **Page Views** - General browsing behavior

## 📊 **Data Collection & Privacy**

### **What's Tracked:**
- **Interaction Type**: view, click, search, like, comment, share
- **Content Metadata**: titles, tags, categories, keywords
- **Engagement**: time spent, scroll behavior, interactions
- **Context**: referrer, page, timestamp, session

### **Privacy Considerations:**
- **Logged-in users only** - No tracking for anonymous users
- **Metadata focused** - Content preferences, not personal data
- **User control** - Users can reset their profiles
- **Transparent** - Debug overlay shows user profile data

## 🧪 **Testing Instructions**

### **1. Test User Interaction Tracking**
1. **Login** to the system as any user
2. **Browse different pages**:
   - Visit Research_page.php - click on project cards
   - Visit Faculty_Page.php - click on faculty profiles  
   - Visit events.php - interact with event cards
   - Visit view_posts.php - engage with forum posts

3. **Check tracking data**:
   - Visit `dashboard.php` to see debug overlay
   - Check user preferences and interactions
   - Verify interest scores are updating

### **2. Test Personalized Recommendations**
1. **Interact with specific content types** (e.g., click multiple AI/Technology projects)
2. **Wait 5-10 interactions** for profile to build
3. **Visit dashboard.php** to see personalized recommendations
4. **Verify recommendations match** your interaction patterns

### **3. Test Global Functionality**
1. **Check browser console** for "Global Preference Tracker initialized" message
2. **Verify tracking on all pages** by looking for data attributes on clickable elements
3. **Test recommendation helper functions** on any page by calling:
   ```javascript
   // In browser console
   window.preferenceTracker.getUserProfile();
   ```

### **4. Debug & Monitor**
1. **Debug Overlay**: Available on dashboard.php shows real-time user profile
2. **Browser Console**: Shows tracking events and errors
3. **Server Logs**: Check logs for interaction tracking (error_log)
4. **Database**: Check `user_preference_profiles` and `user_interactions` collections

## 🚀 **Next Steps & Enhancements**

### **Immediate Improvements:**
1. **Add search query tracking** - Track what users search for
2. **Enhance content recommendations** - Add collaborative filtering
3. **Mobile optimization** - Ensure tracking works on mobile devices
4. **Performance monitoring** - Track system performance impact

### **Advanced Features:**
1. **A/B Testing** - Test different recommendation algorithms
2. **Real-time recommendations** - Live content suggestions
3. **Cross-page recommendations** - Suggest content across different sections
4. **Analytics dashboard** - Admin view of user behavior patterns

## 📈 **Expected Benefits**

### **For Users:**
- **Personalized content discovery**
- **Relevant recommendations**
- **Improved user experience**
- **Time-saving content finding**

### **For Administrators:**
- **User behavior insights**
- **Content performance analytics**
- **Engagement metrics**
- **Data-driven improvements**

## ⚠️ **Important Notes**

1. **MongoDB Required**: System uses MongoDB for preference storage
2. **Session Dependency**: Tracking only works for logged-in users
3. **JavaScript Required**: Client-side tracking requires JavaScript enabled
4. **Privacy Compliance**: Ensure compliance with data protection regulations

## 🔍 **Troubleshooting**

### **Common Issues:**
1. **Tracking not working**: Check browser console for JavaScript errors
2. **No recommendations**: Verify user has enough interactions (5+ recommended)
3. **Script path errors**: Ensure asset paths are correct for subdirectories
4. **MongoDB connection**: Verify database connectivity and credentials

The global preference tracking system is now **fully implemented** and **ready for testing**! 🎉 