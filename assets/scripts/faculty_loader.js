// facultyLoader.js

// Global faculty data storage
window.facultyData = null;

document.addEventListener('DOMContentLoaded', function () {
    // Show loading skeleton while fetching data
    const facultyList = document.getElementById('facultyList');
    if (facultyList) {
        facultyList.innerHTML = generateSkeletonLoader(3); // Show fewer skeleton items
    }

    fetch('src/model/load_faculty.php')
        .then(response => response.json())
        .then(data => {
            // Store faculty data globally for other pages to use
            window.facultyData = data;

            if (!facultyList) return; // Make sure the element exists on this page
            
            // Clear any skeleton loaders
            facultyList.innerHTML = '';
            
            if (data.length === 0) {
                facultyList.innerHTML = '<div class="col-12"><p class="text-center py-5">No faculty members found.</p></div>';
                return;
            }

            // Create a row element to wrap faculty cards
            const row = document.createElement('div');
            row.className = 'row g-4'; // g-4 adds consistent gutters
            facultyList.appendChild(row);

            data.forEach((faculty, index) => {
                const profileImage = faculty.profile_image ? faculty.profile_image : 'assets/resources/imgPlaceholder.png';
                
                // Get up to 3 fields for specialty tags
                const specialtyTags = faculty.interested_fields_of_research 
                    ? faculty.interested_fields_of_research.slice(0, 3).map(field => 
                        `<span class="specialty-tag">${field}</span>`).join('')
                    : '';

                // Create a shorter bio for display
                const shortBio = faculty.bio ? 
                    (faculty.bio.length > 120 ? faculty.bio.substring(0, 120) + '...' : faculty.bio) 
                    : 'Faculty member at UIU';

                const facultyCol = document.createElement('div');
                facultyCol.className = 'col-lg-4 col-md-6 d-flex';
                facultyCol.style.setProperty('--card-index', index);
                
                facultyCol.innerHTML = `
                    <div class="faculty-card" style="animation-delay: ${index * 0.1}s;">
                        <div class="faculty-img-wrapper">
                            <div class="faculty-img-container" id="faculty-img-${index}">
                                <img 
                                    src="${profileImage}" 
                                    alt="${faculty.name}" 
                                    class="faculty-img" 
                                    onload="handleImageLoad('faculty-img-${index}')" 
                                    onerror="handleImageError('faculty-img-${index}')"
                                >
                            </div>
                        </div>
                        <div class="faculty-info">
                            <h4>${faculty.name}</h4>
                            <p>${shortBio}</p>
                            <div class="faculty-specialties">
                                ${specialtyTags}
                            </div>
                            <a href="Faculty_Profile.php?id=${faculty._id}" class="learn-more">
                                Explore Profile <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                `;
                
                row.appendChild(facultyCol);
            });
        })
        .catch(error => {
            if (facultyList) {
                facultyList.innerHTML = `<div class="col-12"><p class="text-danger text-center py-5">Failed to load faculty data.</p></div>`;
            }
            console.error('Error loading faculty data:', error);
        });
});

// Handle image loading
function handleImageLoad(containerId) {
    const container = document.getElementById(containerId);
    if (container) {
        // Add loaded class to show the image
        container.classList.add('loaded');
        
        // Get the image and adjust the parent container height if needed
        const img = container.querySelector('img');
        if (img && img.naturalHeight > 0) {
            // Ensure image maintains aspect ratio and fits within container
            const wrapper = container.closest('.faculty-img-wrapper');
            if (wrapper) {
                // If image is very tall, cap its height
                if (img.naturalHeight > 320) {
                    img.style.maxHeight = '320px';
                }
            }
        }
    }
}

// Handle image loading errors
function handleImageError(containerId) {
    const container = document.getElementById(containerId);
    if (container) {
        const img = container.querySelector('img');
        if (img) {
            img.src = 'assets/resources/imgPlaceholder.png';
            img.style.height = '280px';
            setTimeout(() => {
                container.classList.add('loaded');
            }, 100);
        }
    }
}

// Function to generate skeleton loaders while content is loading
function generateSkeletonLoader(count) {
    let skeletons = '<div class="row g-4">';
    for (let i = 0; i < count; i++) {
        skeletons += `
            <div class="col-lg-4 col-md-6 d-flex">
                <div class="faculty-card" style="opacity: 1; transform: none;">
                    <div class="faculty-img-wrapper">
                        <div class="loading-skeleton" style="height: 100%;"></div>
                    </div>
                    <div class="faculty-info pt-4 px-3 pb-3">
                        <div class="loading-skeleton" style="height: 28px; width: 60%; margin-bottom: 15px;"></div>
                        <div class="loading-skeleton" style="height: 14px; margin-bottom: 8px; width: 100%;"></div>
                        <div class="loading-skeleton" style="height: 14px; margin-bottom: 8px; width: 95%;"></div>
                        <div class="loading-skeleton" style="height: 14px; width: 80%; margin-bottom: 15px;"></div>
                        <div style="display: flex; gap: 8px; margin-bottom: 15px;">
                            <div class="loading-skeleton" style="height: 24px; width: 80px; border-radius: 50px;"></div>
                            <div class="loading-skeleton" style="height: 24px; width: 60px; border-radius: 50px;"></div>
                        </div>
                        <div class="loading-skeleton" style="height: 30px; width: 140px; margin-top: auto;"></div>
                    </div>
                </div>
            </div>
        `;
    }
    skeletons += '</div>';
    return skeletons;
}

// Initialize scroll animation for elements
function initScrollAnimation() {
    // This is now handled via CSS animations
}
