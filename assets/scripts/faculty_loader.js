// facultyLoader.js

// Global faculty data storage
window.facultyData = null;

document.addEventListener('DOMContentLoaded', function () {
    fetch('src/model/load_faculty.php')
        .then(response => response.json())
        .then(data => {
            // Store faculty data globally for other pages to use
            window.facultyData = data;

            const facultyList = document.getElementById('facultyList');
            if (!facultyList) return; // Make sure the element exists on this page
            
            if (data.length === 0) {
                facultyList.innerHTML = '<p class="text-center">No faculty members found.</p>';
                return;
            }

            data.forEach(faculty => {
                const profileImage = faculty.profile_image ? faculty.profile_image : 'assets/resources/imgPlaceholder.png';

                const facultyCard = `
                    <div class="col-md-4 d-flex">
                        <div class="faculty-card">
                            <img src="${profileImage}" alt="${faculty.name}" class="faculty-img">
                            <div class="faculty-info">
                                <h4>${faculty.name}</h4>
                                <p>${faculty.bio}</p>
                                <a href="Faculty_Profile.php?id=${faculty._id}" class="learn-more">LEARN MORE</a>
                            </div>
                        </div>
                    </div>
                `;
                facultyList.insertAdjacentHTML('beforeend', facultyCard);
            });
        })
        .catch(error => {
            const facultyList = document.getElementById('facultyList');
            if (facultyList) {
                facultyList.innerHTML = `<p class="text-danger">Failed to load faculty data.</p>`;
            }
            console.error('Error loading faculty data:', error);
        });
});
