# University Events Page

## Overview
A modern, responsive events page that displays university events in an attractive card-based layout. This page is accessible from the Research Events section on the main index page.

## Features

### 🎨 Modern Design
- **Dark theme** with glassmorphism effects
- **Gradient backgrounds** and smooth animations
- **Responsive card layout** that adapts to different screen sizes
- **Futuristic UI elements** with hover effects and transitions

### 🔍 Search & Filter Functionality
- **Real-time search** - Search events by title or description
- **Category filtering** - Filter by Conference, Workshop, Seminar, Networking, Competition
- **Time-based filtering** - View upcoming events, events this week/month, or past events
- **Combined filtering** - Use multiple filters simultaneously

### 📱 Responsive Design
- **Mobile-first approach** with adaptive layouts
- **Touch-friendly interfaces** for mobile devices
- **Flexible grid system** that works on all screen sizes

### ⚡ Interactive Features
- **Event registration** buttons (placeholder functionality)
- **Social sharing** with native Web Share API support
- **Pagination** for large event lists
- **Loading states** and smooth transitions
- **AOS animations** for enhanced user experience

### 🏗️ Technical Features
- **Client-side filtering** for instant results
- **Modular JavaScript** with clean separation of concerns
- **CSS custom properties** for easy theming
- **Cross-browser compatibility**
- **Performance optimized** with efficient DOM manipulation

## File Structure

```
events.php                 # Main events page
index.php                 # Updated to link to events page (line 6211)
src/includes/navbar.php   # Shared navigation component
src/includes/footer.php   # Shared footer component
```

## Event Data Structure

Each event contains the following properties:
```javascript
{
    id: 1,
    title: "Event Title",
    description: "Event description...",
    date: "2024-12-15",
    time: "10:00 AM - 4:00 PM",
    location: "Event Location",
    category: "conference", // conference, workshop, seminar, networking, competition
    type: "Conference",
    icon: "bi-megaphone", // Bootstrap icon class
    isUpcoming: true
}
```

## Usage

### Accessing the Events Page
1. Navigate to the main page (`index.php`)
2. Scroll to the "Research Events" section
3. Click the "View Full Calendar" button
4. This will redirect to `events.php`

### Using Filters
- **Search**: Type in the search box to filter events by title or description
- **Category**: Select a category from the dropdown
- **Time**: Choose a time filter (Upcoming, This Week, This Month, Past Events)
- **Apply**: Click the Filter button or filters apply automatically

### Navigation
- Use pagination at the bottom to navigate through multiple pages of events
- Click on event cards to view more details (future enhancement)
- Use Register and Share buttons for event interactions

## Customization

### Adding New Events
1. Edit the `eventsData` array in `events.php`
2. Add new event objects following the data structure above
3. Events will automatically appear with filtering and pagination

### Styling Modifications
- Modify CSS custom properties in the `:root` selector to change colors
- Update grid layout by modifying `.events-grid` class
- Customize card appearance in `.event-card` class

### Extending Functionality
- Add database integration to replace static `eventsData` array
- Implement actual registration system
- Add event detail pages
- Integrate with calendar APIs
- Add admin panel for event management

## Browser Support
- Modern browsers (Chrome, Firefox, Safari, Edge)
- IE 11+ with partial support
- Mobile browsers (iOS Safari, Chrome Mobile)

## Future Enhancements
- [ ] Database integration with MongoDB/MySQL
- [ ] Event registration system
- [ ] Calendar integration (Google Calendar, Outlook)
- [ ] Event reminder notifications
- [ ] Admin panel for event management
- [ ] Advanced filtering options (by department, difficulty level)
- [ ] Event favorites/bookmarking
- [ ] Social media integration
- [ ] Event analytics and attendance tracking

## Technical Dependencies
- **Bootstrap 5.3.0** - UI framework
- **Bootstrap Icons** - Icon library
- **AOS (Animate On Scroll)** - Animation library
- **Google Fonts (Inter)** - Typography
- **PHP** - Server-side processing (for includes)

## Performance Considerations
- Events are loaded client-side for instant filtering
- Images are optimized and lazy-loaded where applicable
- CSS animations use hardware acceleration
- Pagination limits DOM elements for better performance
- Efficient event filtering algorithms

## Accessibility Features
- Semantic HTML structure
- ARIA labels where appropriate
- Keyboard navigation support
- High contrast ratios
- Screen reader friendly content

---

**Created**: December 2024  
**Last Updated**: December 2024  
**Author**: AI Assistant  
**License**: Part of UIU Research Portal Project 