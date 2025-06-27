// facultyLoader.js

document.addEventListener('DOMContentLoaded', function () {
    const facultyList = document.getElementById('facultyList');
    const facultySearch = document.getElementById('facultySearch');
    let allFaculty = [];

    function renderFaculty(facultyData) {
        facultyList.innerHTML = '';
        if (facultyData.length === 0) {
            facultyList.innerHTML = '<p class="text-center">No faculty members found.</p>';
            return;
        }
        
        // Create a row container
        const rowDiv = document.createElement('div');
        rowDiv.className = 'row g-4';
        facultyList.appendChild(rowDiv);
        
        facultyData.forEach((faculty, index) => {
            const profileImage = faculty.profile_image ? faculty.profile_image : 'assets/resources/user_avater.png';
            const shortBio = faculty.bio ? (faculty.bio.length > 100 ? faculty.bio.substring(0, 100) + '...' : faculty.bio) : 'No biography available.';
            
            // Create specialty display (use first field of research if available)
            let specialty = '';
            if (faculty.interested_fields_of_research && faculty.interested_fields_of_research.length > 0) {
                specialty = faculty.interested_fields_of_research[0];
            } else {
                specialty = 'Research Faculty';
            }
            
            const facultyCard = `
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="neo-faculty-card" data-faculty-id="${faculty._id}" style="cursor: pointer;">
                        <div class="card-border"></div>
                        <div class="faculty-img-wrapper">
                            <div class="faculty-img-container" id="img-container-${index}">
                                <img src="${profileImage}" alt="${faculty.name}" class="img-fluid" 
                                     onload="handleImageLoad(${index})" onerror="handleImageError(${index})">
                                <div class="img-overlay"></div>
                            </div>
                            <div class="faculty-specialty-badge">
                                <span>${specialty}</span>
                            </div>
                        </div>
                        <div class="faculty-info">
                            <h4 class="faculty-name">${faculty.name}</h4>
                            <p class="faculty-position">Faculty Member</p>
                            <div class="faculty-quote">
                                <q>${shortBio}</q>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            rowDiv.insertAdjacentHTML('beforeend', facultyCard);
        });
        
        // Add event listeners to faculty cards
        setTimeout(() => {
            const facultyCards = document.querySelectorAll('.neo-faculty-card');
            facultyCards.forEach(card => {
                card.addEventListener('click', function() {
                    const facultyId = this.getAttribute('data-faculty-id');
                    if (facultyId) {
                        window.location.href = `Faculty_Profile.php?id=${facultyId}`;
                    }
                });
            });
        }, 500);
    }
    
    // Image loading handlers
    window.handleImageLoad = function(index) {
        const container = document.getElementById(`img-container-${index}`);
        if (container) {
            container.classList.add('loaded');
        }
    };
    
    window.handleImageError = function(index) {
        const container = document.getElementById(`img-container-${index}`);
        if (container) {
            const img = container.querySelector('img');
            if (img) {
                img.src = 'assets/resources/user_avater.png';
                img.onload = () => container.classList.add('loaded');
            }
        }
    };

    fetch('src/model/load_faculty.php')
        .then(response => response.json())
        .then(data => {
            allFaculty = data;
            renderFaculty(allFaculty);
        })
        .catch(error => {
            if (facultyList) {
                facultyList.innerHTML = `<p class="text-danger">Failed to load faculty data.</p>`;
            }
            console.error('Error loading faculty data:', error);
        });

    if (facultySearch) {
        facultySearch.addEventListener('input', function () {
            const query = this.value.toLowerCase();
            const filteredFaculty = allFaculty.filter(faculty => {
                return faculty.name.toLowerCase().includes(query);
            });
            renderFaculty(filteredFaculty);
        });
    }
});
