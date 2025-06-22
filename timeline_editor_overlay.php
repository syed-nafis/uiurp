<?php
// Timeline Editor Overlay for Project Details
// This file provides an overlay for editing project timeline items
// It's designed to be included in Project_details.php

// Prevent direct access
if (!defined('INCLUDED_IN_PROJECT_DETAILS')) {
    header("Location: index.php");
    exit();
}
?>

<!-- Timeline Editor Modal -->
<div class="modal fade" id="timelineEditorModal" tabindex="-1" aria-labelledby="timelineEditorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timelineEditorModalLabel">
                    <i class="bi bi-calendar-event me-2"></i>Project Timeline
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">Add key milestones and events to track your project's progress.</p>
                
                <div id="timelineContainer">
                    <!-- Timeline items will be added here -->
                </div>
                
                <button type="button" class="btn btn-outline-primary mt-3" id="addTimelineItem">
                    <i class="bi bi-plus-circle me-2"></i>Add Timeline Item
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveAllTimelineChanges">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Timeline Item Edit Modal -->
<div class="modal fade" id="timelineEditModal" tabindex="-1" aria-labelledby="timelineEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timelineEditModalLabel">
                    <i class="bi bi-calendar-event"></i> Edit Timeline Item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="timelineEditForm">
                    <!-- Basic Information -->
                    <div class="section-header">
                        <h6><i class="bi bi-info-circle"></i> Basic Information</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-2">
                                <label for="timelineTitle" class="form-label">
                                    <i class="bi bi-type"></i>Title *
                                </label>
                                <input type="text" class="form-control" id="timelineTitle" 
                                       placeholder="Enter milestone title..." required>
                                <div class="invalid-feedback">Title required</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="timelineDate" class="form-label">
                                    <i class="bi bi-calendar3"></i>Date *
                                </label>
                                <input type="date" class="form-control" id="timelineDate" required>
                                <div class="invalid-feedback">Date required</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="timelineDescription" class="form-label">
                            <i class="bi bi-text-paragraph"></i>Description
                        </label>
                        <textarea class="form-control" id="timelineDescription" rows="2" 
                                  placeholder="Describe what needs to be accomplished..."></textarea>
                    </div>

                    <!-- Status -->
                    <div class="section-header">
                        <h6><i class="bi bi-flag"></i> Status</h6>
                    </div>
                    <div class="mb-2">
                        <label for="timelineStatus" class="form-label">
                            <i class="bi bi-speedometer2"></i>Current Status
                        </label>
                        <select class="form-select" id="timelineStatus">
                            <option value="Planned">📋 Planned</option>
                            <option value="In Progress">⚡ In Progress</option>
                            <option value="Completed">✅ Completed</option>
                            <option value="Delayed">⚠️ Delayed</option>
                        </select>
                    </div>

                    <!-- Assignment -->
                    <div class="section-header">
                        <h6><i class="bi bi-people"></i> Assignment</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="timelineAssignedBy" class="form-label">
                                    <i class="bi bi-person-plus"></i>Assigned By
                                </label>
                                <select class="form-select" id="timelineAssignedBy">
                                    <option value="">Select member</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="timelineAssignedTo" class="form-label">
                                    <i class="bi bi-person-check"></i>Assigned To
                                </label>
                                <select class="form-select" id="timelineAssignedTo" multiple size="3">
                                    <option value="">Select members</option>
                                </select>
                                <div class="form-text">
                                    <i class="bi bi-info-circle"></i> Hold Ctrl/Cmd to select multiple
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary" id="saveTimelineChanges">
                    <i class="bi bi-check"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Global variables for timeline editing
window.timelineItems = [];
let currentProjectId = null;
let currentEditingIndex = -1;

// Get data when the timeline editor modal is shown
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the timeline editor when the modal is shown
    const timelineEditorModal = document.getElementById('timelineEditorModal');
    if (timelineEditorModal) {
        timelineEditorModal.addEventListener('show.bs.modal', function (event) {
            // Get the project ID from the button that triggered the modal
            const button = event.relatedTarget;
            currentProjectId = button.getAttribute('data-project-id');
            
            // Load the project timeline data
            loadProjectTimeline(currentProjectId);
        });
    }
    
    // Add event listeners for timeline operations
    document.getElementById('addTimelineItem').addEventListener('click', function() {
        addTimelineItem();
    });
    
    document.getElementById('saveTimelineChanges').addEventListener('click', function() {
        saveTimelineItem();
    });
    
    document.getElementById('saveAllTimelineChanges').addEventListener('click', function() {
        saveAllTimelineChanges();
    });
});

// Function to load project timeline data
function loadProjectTimeline(projectId) {
    // Show loading state
    const timelineContainer = document.getElementById('timelineContainer');
    timelineContainer.innerHTML = `
        <div class="text-center p-3">
            <div class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading timeline items...</p>
        </div>
    `;
    
    // Fetch project data
    fetch(`src/model/get_project.php?id=${projectId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.project) {
                const project = data.project;
                
                // Process timeline items
                if (project.timeline && project.timeline.length > 0) {
                    window.timelineItems = project.timeline.map(item => {
                        // Handle MongoDB date format
                        let date = item.date;
                        if (item.date && item.date.$date) {
                            date = new Date(item.date.$date).toISOString().split('T')[0];
                        } else if (typeof item.date === 'string' && item.date.includes('T')) {
                            date = new Date(item.date).toISOString().split('T')[0];
                        } else if (item.date) {
                            date = item.date;
                        } else {
                            date = new Date().toISOString().split('T')[0];
                        }
                        
                        return {
                            title: item.title || '',
                            description: item.description || '',
                            date: date,
                            status: item.status || 'Planned',
                            assignedBy: item.assignedBy || null,
                            assignedTo: Array.isArray(item.assignedTo) ? item.assignedTo : (item.assignedTo ? [item.assignedTo] : [])
                        };
                    });
                } else {
                    window.timelineItems = [];
                }
                
                // Update the UI
                updateTimelineDisplay();
            } else {
                timelineContainer.innerHTML = `<div class="alert alert-danger">Failed to load project data</div>`;
            }
        })
        .catch(error => {
            console.error('Error loading project data:', error);
            timelineContainer.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
        });
}

// Function to update the timeline display
function updateTimelineDisplay() {
    const timelineContainer = document.getElementById('timelineContainer');
    timelineContainer.innerHTML = '';
    
    if (window.timelineItems.length === 0) {
        timelineContainer.innerHTML = '<p class="text-muted text-center py-3">No timeline items added yet.</p>';
        return;
    }
    
    // Sort timeline items by date
    window.timelineItems.sort((a, b) => {
        const dateA = a.date || '';
        const dateB = b.date || '';
        return new Date(dateA) - new Date(dateB);
    });
    
    window.timelineItems.forEach((item, index) => {
        const statusClasses = {
            'Completed': 'completed status-completed',
            'In Progress': 'in-progress status-in-progress',
            'Planned': 'planned status-planned',
            'Delayed': 'delayed status-delayed'
        };
        
        const statusClass = statusClasses[item.status] || 'planned status-planned';
        
        const timelineItem = document.createElement('div');
        timelineItem.className = `timeline-item ${item.status ? item.status.toLowerCase().replace(' ', '-') : 'planned'}`;
        timelineItem.dataset.index = index;
        
        // Format date for display
        const displayDate = new Date(item.date);
        const formattedDisplayDate = displayDate.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        // Generate assignment display text
        let assignmentInfo = '';
        
        // Process assignedBy info
        let assignedByName = '';
        if (item.assignedBy) {
            if (typeof item.assignedBy === 'object' && item.assignedBy.name) {
                assignedByName = item.assignedBy.name;
            } else {
                assignedByName = item.assignedBy;
            }
        }
        
        // Process assignedTo info
        let assignedToNames = [];
        if (item.assignedTo && item.assignedTo.length > 0) {
            assignedToNames = item.assignedTo.map(assignee => {
                if (typeof assignee === 'object' && assignee.name) {
                    return assignee.name;
                }
                return assignee;
            });
        }
        
        if (assignedByName || assignedToNames.length > 0) {
            assignmentInfo = '<div class="assignment-info mt-2">';
            
            if (assignedByName) {
                assignmentInfo += `<span class="text-muted small me-3"><i class="bi bi-person-plus"></i> Assigned by: <strong>${assignedByName}</strong></span>`;
            }
            
            if (assignedToNames.length > 0) {
                assignmentInfo += `<span class="text-muted small"><i class="bi bi-person-check"></i> Assigned to: <strong>${assignedToNames.join(', ')}</strong></span>`;
            }
            
            assignmentInfo += '</div>';
        }

        timelineItem.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="timeline-date">
                    <i class="bi bi-calendar3"></i>
                    ${formattedDisplayDate}
                    <span class="status-badge ${statusClass}">${item.status || 'Planned'}</span>
                </div>
                <div class="timeline-controls">
                    <button type="button" class="btn btn-sm btn-outline-primary edit-timeline" data-index="${index}">
                        <i class="bi bi-pencil-fill"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger delete-timeline" data-index="${index}">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </div>
            </div>
            <h6 class="mb-2">${item.title || ''}</h6>
            <p class="mb-2 small text-muted">${item.description || ''}</p>
            ${assignmentInfo}
        `;
        
        timelineContainer.appendChild(timelineItem);
        
        // Add event listeners
        const editBtn = timelineItem.querySelector('.edit-timeline');
        const deleteBtn = timelineItem.querySelector('.delete-timeline');
        
        editBtn.addEventListener('click', function() {
            const index = parseInt(this.dataset.index);
            editTimelineItem(index);
        });
        
        deleteBtn.addEventListener('click', function() {
            const index = parseInt(this.dataset.index);
            deleteTimelineItem(index);
        });
    });
}

// Function to add a new timeline item
function addTimelineItem(item = null) {
    const now = new Date();
    const formattedDate = now.toISOString().split('T')[0]; // YYYY-MM-DD format
    
    const newItem = item || {
        title: '',
        description: '',
        date: formattedDate,
        status: 'Planned',
        assignedBy: null,
        assignedTo: []
    };
    
    // Add to the array
    if (!item) {
        window.timelineItems.push(newItem);
    }
    
    // Update the display
    updateTimelineDisplay();
    
    // If it's a new item, open the edit dialog
    if (!item) {
        editTimelineItem(window.timelineItems.length - 1);
    }
}

// Function to edit a timeline item
function editTimelineItem(index) {
    currentEditingIndex = index;
    const item = window.timelineItems[index];
    
    // Set form values
    document.getElementById('timelineTitle').value = item.title || '';
    document.getElementById('timelineDescription').value = item.description || '';
    document.getElementById('timelineDate').value = item.date || new Date().toISOString().split('T')[0];
    document.getElementById('timelineStatus').value = item.status || 'Planned';
    
    // Populate assignment dropdowns with project members
    populateAssignmentDropdowns();
    
    // Set assignment values
    let assignedByValue = '';
    if (item.assignedBy) {
        if (typeof item.assignedBy === 'object' && item.assignedBy.id) {
            assignedByValue = item.assignedBy.id;
        } else {
            assignedByValue = item.assignedBy;
        }
    }
    document.getElementById('timelineAssignedBy').value = assignedByValue;
    
    // Set assignedTo values
    const assignedToSelect = document.getElementById('timelineAssignedTo');
    const assignedTo = Array.isArray(item.assignedTo) ? item.assignedTo : [];
    
    Array.from(assignedToSelect.options).forEach(option => {
        option.selected = assignedTo.some(assignee => {
            if (typeof assignee === 'object' && assignee.id) {
                return assignee.id === option.value;
            }
            return assignee === option.value;
        });
    });
    
    // Show the modal
    const timelineEditModal = new bootstrap.Modal(document.getElementById('timelineEditModal'));
    timelineEditModal.show();
}

// Function to save changes to a timeline item
function saveTimelineItem() {
    // Get form values
    const title = document.getElementById('timelineTitle').value.trim();
    const description = document.getElementById('timelineDescription').value.trim();
    const date = document.getElementById('timelineDate').value;
    const status = document.getElementById('timelineStatus').value;
    
    // Validate required fields
    if (!title || !date) {
        if (!title) document.getElementById('timelineTitle').classList.add('is-invalid');
        if (!date) document.getElementById('timelineDate').classList.add('is-invalid');
        return;
    }
    
    // Get assignedBy information
    const assignedBySelect = document.getElementById('timelineAssignedBy');
    let assignedBy = null;
    
    if (assignedBySelect.value) {
        const selectedOption = assignedBySelect.options[assignedBySelect.selectedIndex];
        assignedBy = {
            id: assignedBySelect.value,
            name: selectedOption.text.replace(/ \(.*\)$/, '') // Remove role from text
        };
    }
    
    // Get assignedTo information
    const assignedToSelect = document.getElementById('timelineAssignedTo');
    const assignedTo = Array.from(assignedToSelect.selectedOptions)
        .filter(option => option.value)
        .map(option => ({
            id: option.value,
            name: option.text.replace(/ \(.*\)$/, '') // Remove role from text
        }));
    
    // Update the timeline item
    window.timelineItems[currentEditingIndex] = {
        title,
        description,
        date,
        status,
        assignedBy,
        assignedTo
    };
    
    // Update the UI
    updateTimelineDisplay();
    
    // Close the modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('timelineEditModal'));
    modal.hide();
}

// Function to delete a timeline item
function deleteTimelineItem(index) {
    if (confirm('Are you sure you want to delete this timeline item?')) {
        window.timelineItems.splice(index, 1);
        updateTimelineDisplay();
    }
}

// Function to populate assignment dropdowns
function populateAssignmentDropdowns() {
    // This is a simplified version since we don't have direct access to members data
    // We'll fetch the project data to get members
    
    if (!currentProjectId) return;
    
    const assignedBySelect = document.getElementById('timelineAssignedBy');
    const assignedToSelect = document.getElementById('timelineAssignedTo');
    
    // Clear existing options
    assignedBySelect.innerHTML = '<option value="">Select member (optional)</option>';
    assignedToSelect.innerHTML = '';
    
    // Fetch project data to get members
    fetch(`src/model/get_project.php?id=${currentProjectId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.project) {
                const project = data.project;
                
                // Add project members
                if (project.members && project.members.length > 0) {
                    project.members.forEach(member => {
                        if (member.name) {
                            const memberId = member.userId && member.userId.$oid ? member.userId.$oid : member.name;
                            const memberText = `${member.name}${member.role ? ' (' + member.role + ')' : ''}`;
                            
                            // Add to assignedBy dropdown
                            const assignedByOption = new Option(memberText, memberId);
                            assignedBySelect.add(assignedByOption);
                            
                            // Add to assignedTo dropdown if not supervisor/faculty
                            const isStudent = !member.role || 
                                           !member.role.toLowerCase().includes('supervisor') && 
                                           !member.role.toLowerCase().includes('faculty');
                            
                            if (isStudent) {
                                const assignedToOption = new Option(memberText, memberId);
                                assignedToSelect.add(assignedToOption);
                            }
                        }
                    });
                }
                
                // Add supervisor to assignedBy dropdown
                if (project.supervisor) {
                    const supervisorName = project.supervisor.name || 'Supervisor';
                    const supervisorId = project.supervisor.userId && project.supervisor.userId.$oid ? 
                        project.supervisor.userId.$oid : supervisorName;
                    
                    const supervisorOption = new Option(`${supervisorName} (Supervisor)`, supervisorId);
                    assignedBySelect.add(supervisorOption);
                }
            }
        })
        .catch(error => {
            console.error('Error loading project members:', error);
        });
}

// Function to save all timeline changes
function saveAllTimelineChanges() {
    if (!currentProjectId) {
        alert('Project ID not found');
        return;
    }
    
    // Show loading state
    const saveBtn = document.getElementById('saveAllTimelineChanges');
    const originalText = saveBtn.innerHTML;
    saveBtn.disabled = true;
    saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
    
    // Prepare data for submission
    const data = {
        project_id: currentProjectId,
        timeline: window.timelineItems
    };
    
    // Send AJAX request
    fetch('src/model/update_timeline.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('Timeline updated successfully');
            
            // Close the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('timelineEditorModal'));
            modal.hide();
            
            // Refresh the timeline display on the main page
            if (typeof refreshProjectTimeline === 'function') {
                refreshProjectTimeline();
            }
        } else {
            alert('Error: ' + (result.message || 'Failed to update timeline'));
        }
        
        // Restore button state
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalText;
    })
    .catch(error => {
        console.error('Error saving timeline:', error);
        alert('Error: ' + error.message);
        
        // Restore button state
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalText;
    });
}
</script> 