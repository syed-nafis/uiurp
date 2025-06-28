/**
 * User Preference Tracking System
 * Tracks user interactions and sends them to the backend for personalization
 */

class PreferenceTracker {
    constructor() {
        this.endpoint = 'src/model/user_preferences.php';
        this.sessionData = {
            startTime: Date.now(),
            pageViews: [],
            interactions: []
        };
        this.debounceTimeout = null;
        this.batchQueue = [];
        this.batchSize = 5;
        this.batchTimeout = 5000; // Send batch every 5 seconds
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.trackPageView();
        this.startBatchProcessor();
        
        // Track page unload
        window.addEventListener('beforeunload', () => {
            this.flushBatch();
        });
    }
    
    setupEventListeners() {
        // Track clicks on cards and links
        document.addEventListener('click', (e) => {
            this.handleClick(e);
        });
        
        // Track form submissions (searches)
        document.addEventListener('submit', (e) => {
            this.handleFormSubmit(e);
        });
        
        // Track time spent on page
        this.startTimeTracking();
        
        // Track scroll behavior
        this.setupScrollTracking();
    }
    
    handleClick(event) {
        const target = event.target.closest('a, .card, .clickable');
        if (!target) return;
        
        let itemType = null;
        let itemId = null;
        let metadata = {};
        
        // First check data attributes (more reliable)
        itemType = target.getAttribute('data-item-type');
        itemId = target.getAttribute('data-item-id');
        
        // Fallback to URL parsing if data attributes not available
        if (!itemType && target.href) {
            const url = new URL(target.href);
            const pathname = url.pathname;
            const params = new URLSearchParams(url.search);
            
            if (pathname.includes('Project_details.php')) {
                itemType = 'project';
                itemId = params.get('id');
            } else if (pathname.includes('Faculty_Profile.php')) {
                itemType = 'faculty';
                itemId = params.get('id');
            } else if (pathname.includes('post_details.php')) {
                itemType = 'forum_post';
                itemId = params.get('id');
            } else if (pathname.includes('events.php')) {
                itemType = 'event';
                // Extract event ID from hash if present
                if (url.hash) {
                    itemId = url.hash.replace('#event-', '');
                }
            }
        }
        
        // Enhanced metadata extraction
        if (target.classList.contains('card')) {
            metadata = this.extractMetadata(target);
        }
        
        if (itemType && itemId) {
            this.trackInteraction('click', itemId, itemType, metadata);
        }
    }
    
    // Enhanced metadata extraction
    extractMetadata(element) {
        const metadata = {};
        
        // Extract title/name for keyword analysis
        const title = element.querySelector('.card-title, .faculty-name, h1, h2, h3');
        if (title) {
            metadata.title = title.textContent.trim();
            metadata.keywords = this.extractKeywords(metadata.title);
        }
        
        // Extract content for keyword analysis
        const content = element.querySelector('.card-content, .faculty-bio, p');
        if (content) {
            metadata.content_preview = content.textContent.trim().substring(0, 100);
            // Add content keywords if no title keywords exist
            if (!metadata.keywords || metadata.keywords.length === 0) {
                metadata.keywords = this.extractKeywords(metadata.content_preview);
            }
        }
        
        // Extract tags (including specialty and research interests)
        const tags = element.querySelectorAll('.tag');
        if (tags.length > 0) {
            metadata.tags = Array.from(tags).map(tag => tag.textContent.trim());
        }
        
        // For faculty, extract specialty and research interests separately
        const specialty = element.querySelector('.tag.specialty');
        if (specialty) {
            metadata.specialty = specialty.textContent.trim();
        }
        
        const researchInterests = element.querySelectorAll('.tag.research-interest');
        if (researchInterests.length > 0) {
            metadata.researchInterests = Array.from(researchInterests).map(tag => tag.textContent.trim());
        }
        
        // For events, extract event type
        const eventType = element.querySelector('.tag.event-type');
        if (eventType) {
            metadata.eventType = eventType.textContent.trim();
        }
        
        return metadata;
    }
    
    // Extract keywords from text
    extractKeywords(text) {
        if (!text) return [];
        
        // Common stop words to filter out
        const stopWords = ['the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'by', 'is', 'are', 'was', 'were', 'be', 'been', 'being', 'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'could', 'should', 'may', 'might', 'must', 'can', 'shall', 'this', 'that', 'these', 'those', 'i', 'you', 'he', 'she', 'it', 'we', 'they', 'them', 'their', 'there', 'where', 'when', 'what', 'how', 'why', 'who', 'which'];
        
        // Extract words, filter stop words, and get meaningful terms
        const words = text.toLowerCase()
            .replace(/[^\w\s]/g, ' ')
            .split(/\s+/)
            .filter(word => word.length > 2 && !stopWords.includes(word))
            .slice(0, 5); // Limit to top 5 keywords
            
        return words;
    }
    
    handleFormSubmit(event) {
        const form = event.target;
        const searchInput = form.querySelector('input[type="search"], input[name="search"], input[name="query"]');
        
        if (searchInput && searchInput.value.trim()) {
            const query = searchInput.value.trim();
            const category = form.dataset.category || this.getCurrentPageCategory();
            
            this.trackSearch(query, category);
        }
    }
    
    trackPageView() {
        const pageData = {
            url: window.location.href,
            title: document.title,
            referrer: document.referrer,
            timestamp: Date.now()
        };
        
        this.sessionData.pageViews.push(pageData);
        
        // Track page view as interaction
        const pageType = this.getCurrentPageCategory();
        this.trackInteraction('view', window.location.pathname, 'page', {
            title: document.title,
            category: pageType
        });
    }
    
    getCurrentPageCategory() {
        const pathname = window.location.pathname;
        
        if (pathname.includes('Project_details') || pathname.includes('Research_page')) {
            return 'project';
        } else if (pathname.includes('Faculty')) {
            return 'faculty';
        } else if (pathname.includes('events')) {
            return 'event';
        } else if (pathname.includes('forum') || pathname.includes('post')) {
            return 'forum';
        } else if (pathname.includes('dashboard')) {
            return 'dashboard';
        }
        
        return 'general';
    }
    
    trackInteraction(type, itemId, itemType, metadata = {}) {
        const interaction = {
            action: 'track',
            interaction_type: type,
            item_id: itemId,
            item_type: itemType,
            metadata: JSON.stringify(metadata),
            timestamp: Date.now()
        };
        
        this.addToBatch(interaction);
    }
    
    trackSearch(query, category = null) {
        const searchData = {
            action: 'track_search',
            query: query,
            category: category,
            timestamp: Date.now()
        };
        
        this.addToBatch(searchData);
    }
    
    addToBatch(data) {
        this.batchQueue.push(data);
        
        if (this.batchQueue.length >= this.batchSize) {
            this.flushBatch();
        }
    }
    
    flushBatch() {
        if (this.batchQueue.length === 0) return;
        
        const batch = [...this.batchQueue];
        this.batchQueue = [];
        
        // Send each interaction individually (could be optimized to send as batch)
        batch.forEach(data => {
            this.sendToServer(data);
        });
    }
    
    startBatchProcessor() {
        setInterval(() => {
            this.flushBatch();
        }, this.batchTimeout);
    }
    
    sendToServer(data) {
        const formData = new FormData();
        
        Object.keys(data).forEach(key => {
            formData.append(key, data[key]);
        });
        
        // Use sendBeacon for reliability, fall back to fetch
        if (navigator.sendBeacon) {
            navigator.sendBeacon(this.endpoint, formData);
        } else {
            fetch(this.endpoint, {
                method: 'POST',
                body: formData,
                keepalive: true
            }).catch(error => {
                console.warn('Failed to send tracking data:', error);
            });
        }
    }
    
    startTimeTracking() {
        let startTime = Date.now();
        let isActive = true;
        
        // Track when user becomes inactive
        const trackInactivity = () => {
            isActive = false;
        };
        
        const trackActivity = () => {
            if (!isActive) {
                startTime = Date.now();
                isActive = true;
            }
        };
        
        // Events that indicate user activity
        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'].forEach(event => {
            document.addEventListener(event, trackActivity, { passive: true });
        });
        
        // Events that indicate user inactivity
        ['blur'].forEach(event => {
            window.addEventListener(event, trackInactivity);
        });
        
        // Track time spent on page
        window.addEventListener('beforeunload', () => {
            if (isActive) {
                const timeSpent = Date.now() - startTime;
                this.trackInteraction('time_spent', window.location.pathname, 'page', {
                    duration: timeSpent,
                    category: this.getCurrentPageCategory()
                });
            }
        });
    }
    
    setupScrollTracking() {
        let maxScroll = 0;
        let scrollTimer = null;
        
        window.addEventListener('scroll', () => {
            const scrollPercent = Math.round(
                (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100
            );
            
            maxScroll = Math.max(maxScroll, scrollPercent);
            
            // Debounce scroll tracking
            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(() => {
                this.trackInteraction('scroll', window.location.pathname, 'page', {
                    max_scroll_percent: maxScroll,
                    category: this.getCurrentPageCategory()
                });
            }, 1000);
        }, { passive: true });
    }
    
    // Public methods for manual tracking
    trackLike(itemId, itemType) {
        this.trackInteraction('like', itemId, itemType);
    }
    
    trackComment(itemId, itemType) {
        this.trackInteraction('comment', itemId, itemType);
    }
    
    trackShare(itemId, itemType) {
        this.trackInteraction('share', itemId, itemType);
    }
    
    trackBookmark(itemId, itemType) {
        this.trackInteraction('bookmark', itemId, itemType);
    }
    
    trackDownload(itemId, itemType, filename = null) {
        this.trackInteraction('download', itemId, itemType, {
            filename: filename
        });
    }
    
    // Get user profile (for debugging or dashboard display)
    async getUserProfile() {
        try {
            const formData = new FormData();
            formData.append('action', 'get_profile');
            
            const response = await fetch(this.endpoint, {
                method: 'POST',
                body: formData
            });
            
            return await response.json();
        } catch (error) {
            console.error('Failed to get user profile:', error);
            return null;
        }
    }
}

// Initialize tracking when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Only initialize if user is logged in (check for session indicators)
    if (document.querySelector('.user-profile') || document.querySelector('[data-user-logged-in]')) {
        window.preferenceTracker = new PreferenceTracker();
        
        // Make tracker available globally for manual tracking
        window.trackUserAction = {
            like: (id, type) => window.preferenceTracker.trackLike(id, type),
            comment: (id, type) => window.preferenceTracker.trackComment(id, type),
            share: (id, type) => window.preferenceTracker.trackShare(id, type),
            bookmark: (id, type) => window.preferenceTracker.trackBookmark(id, type),
            download: (id, type, filename) => window.preferenceTracker.trackDownload(id, type, filename),
            search: (query, category) => window.preferenceTracker.trackSearch(query, category)
        };
    }
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = PreferenceTracker;
} 