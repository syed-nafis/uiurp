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

    const facultyId = new URLSearchParams(window.location.search).get('id');
    const sectionMap = {
        'research-fields': {
            view: document.getElementById('research-fields-view'),
            edit: document.getElementById('research-fields-edit'),
            getData: () => Array.from(document.querySelectorAll('#research-fields-view h5')).map(e => e.textContent)
        },
        'prerequisites': {
            view: document.getElementById('prerequisites-view'),
            edit: document.getElementById('prerequisites-edit'),
            getData: () => Array.from(document.querySelectorAll('#prerequisites-view h5')).map(e => e.textContent)
        },
        'resources': {
            view: document.getElementById('resources-view'),
            edit: document.getElementById('resources-edit'),
            getData: () => Array.from(document.querySelectorAll('#resources-view .resource-card')).map(card => {
                const topic = card.querySelector('h5').textContent.replace(/^[^a-zA-Z0-9]*/, '').trim();
                const link = card.getAttribute('href');
                return {topic, link};
            })
        },
        'publications': {
            view: document.getElementById('publications-view'),
            edit: document.getElementById('publications-edit'),
            getData: () => Array.from(document.querySelectorAll('#publications-view .card')).map(card => {
                return {
                    title: card.querySelector('.card-title').textContent,
                    description: card.querySelector('.card-text').textContent,
                    link: card.parentElement.getAttribute('href')
                };
            })
        }
    };

    document.querySelectorAll('.inline-edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const section = btn.getAttribute('data-section');
            const {view, edit, getData} = sectionMap[section];
            view.style.display = 'none';
            edit.innerHTML = createEditForm(section, getData());
            edit.style.display = '';

            edit.querySelector('.cancel-edit').onclick = function() {
                edit.style.display = 'none';
                view.style.display = '';
            };

            edit.querySelector('form').onsubmit = function(e) {
                e.preventDefault();
                let formData = new FormData();
                formData.append('id', facultyId);
                switch(section) {
                    case 'research-fields':
                        formData.append('interested_fields', edit.querySelector('[name="interested_fields"]').value);
                        break;
                    case 'prerequisites':
                        formData.append('prerequisites', edit.querySelector('[name="prerequisites"]').value);
                        break;
                    case 'resources':
                        // Parse textarea into array of objects
                        const resources = edit.querySelector('[name="resources"]').value.split('\n').map(line => {
                            const [topic, link] = line.split('|');
                            return {topic: topic?.trim() || '', link: link?.trim() || ''};
                        });
                        formData.append('resources', JSON.stringify(resources));
                        break;
                    case 'publications':
                        // Parse textarea into array of objects
                        const projects = edit.querySelector('[name="projects"]').value.split('\n').map(line => {
                            const [title, description, link] = line.split('|');
                            return {title: title?.trim() || '', description: description?.trim() || '', link: link?.trim() || ''};
                        });
                        formData.append('projects', JSON.stringify(projects));
                        break;
                }
                fetch('update_faculty.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        location.reload();
                    } else {
                        alert('Update failed!');
                    }
                })
                .catch(() => alert('Update failed!'));
            };
        });
    });
});

// Inline editing for faculty profile fields
function createEditForm(section, currentData) {
    let html = '';
    switch(section) {
        case 'research-fields':
            html = `<form id="edit-research-fields-form">
                <label>Research Fields (comma separated):</label>
                <input type="text" class="form-control mb-2" name="interested_fields" value="${currentData.join(', ')}" required>
                <button type="submit" class="btn btn-success btn-sm">Save</button>
                <button type="button" class="btn btn-secondary btn-sm cancel-edit">Cancel</button>
            </form>`;
            break;
        case 'prerequisites':
            html = `<form id="edit-prerequisites-form">
                <label>Prerequisites (comma separated):</label>
                <input type="text" class="form-control mb-2" name="prerequisites" value="${currentData.join(', ')}" required>
                <button type="submit" class="btn btn-success btn-sm">Save</button>
                <button type="button" class="btn btn-secondary btn-sm cancel-edit">Cancel</button>
            </form>`;
            break;
        case 'resources':
            html = `<form id="edit-resources-form">
                <label>Learning Resources (format: topic|link, one per line):</label>
                <textarea class="form-control mb-2" name="resources" rows="5" required>${currentData.map(r => `${r.topic}|${r.link}`).join('\n')}</textarea>
                <button type="submit" class="btn btn-success btn-sm">Save</button>
                <button type="button" class="btn btn-secondary btn-sm cancel-edit">Cancel</button>
            </form>`;
            break;
        case 'publications':
            html = `<form id="edit-publications-form">
                <label>Publications (format: title|description|link, one per line):</label>
                <textarea class="form-control mb-2" name="projects" rows="5" required>${currentData.map(p => `${p.title}|${p.description}|${p.link}`).join('\n')}</textarea>
                <button type="submit" class="btn btn-success btn-sm">Save</button>
                <button type="button" class="btn btn-secondary btn-sm cancel-edit">Cancel</button>
            </form>`;
            break;
    }
    return html;
}
