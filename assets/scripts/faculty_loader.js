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
        facultyData.forEach(faculty => {
            const profileImage = faculty.profile_image ? faculty.profile_image : 'assets/resources/user_avater.png';
            const shortBio = faculty.bio ? (faculty.bio.length > 100 ? faculty.bio.substring(0, 100) + '...' : faculty.bio) : 'No biography available.';

            const facultyCard = `
                <div class="col-md-4 d-flex">
                    <div class="faculty-card">
                        <img src="${profileImage}" alt="${faculty.name}" class="faculty-img">
                        <div class="faculty-info">
                            <h4>${faculty.name}</h4>
                            <p>${shortBio}</p>
                            <a href="Faculty_Profile.php?id=${faculty._id}" class="learn-more">LEARN MORE</a>
                        </div>
                    </div>
                </div>
            `;
            facultyList.insertAdjacentHTML('beforeend', facultyCard);
        });
    }

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
