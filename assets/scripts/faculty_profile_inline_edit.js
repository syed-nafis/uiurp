// faculty_profile_inline_edit.js - Inline editing for faculty profile page

document.addEventListener('DOMContentLoaded', function () {
    // Only run if we're on a faculty profile page
    const facultyId = new URLSearchParams(window.location.search).get('id');
    if (!facultyId) return;

    // Inline editing functionality
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

    // Add event listeners to edit buttons
    document.querySelectorAll('.inline-edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const section = btn.getAttribute('data-section');
            const {view, edit, getData} = sectionMap[section];
            
            if (!view || !edit) {
                console.error('View or edit container not found for section:', section);
                return;
            }
            
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
                        alert('Update failed: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Update error:', error);
                    alert('Update failed! Please try again.');
                });
            };
        });
    });
}); 