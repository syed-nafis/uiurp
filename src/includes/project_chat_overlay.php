<!-- Project Chat Overlay -->
<div id="projectChatOverlay" class="project-chat-overlay">
    <!-- Chat Header with Close Button -->
    <div class="chat-header">
        <div class="chat-title">Project Chat</div>
        <div class="chat-controls">
            <button id="minimizeLeftPanel" class="panel-control" title="Toggle groups">
                <i class="bi bi-layout-sidebar"></i>
            </button>
            <button id="minimizeRightPanel" class="panel-control" title="Toggle members">
                <i class="bi bi-people"></i>
            </button>
            <button id="closeChat" class="close-chat">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>
    
    <!-- Chat Container with 3 sections -->
    <div class="chat-container">
        <!-- Left Panel - Chat Groups -->
        <div id="chatGroupsPanel" class="chat-groups-panel">
            <div class="panel-header">
                <h3>Projects</h3>
                <div class="panel-controls">
                    <button id="collapseProjects" class="panel-collapse-btn" title="Toggle projects panel">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <div class="loading-spinner chat-spinner" id="chatGroupsLoading">
                        <div class="spinner-border text-primary spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="groups-list" id="projectChatGroups">
                <!-- Project chat groups will be loaded here -->
            </div>
        </div>
        
        <!-- Center Panel - Chat Messages -->
        <div class="chat-messages-panel">
            <div class="messages-container">
                <!-- Messages will be loaded dynamically -->
                <div id="noMessagesPlaceholder" class="empty-messages-placeholder">
                    <i class="bi bi-chat-square-text"></i>
                    <p>No messages yet. Be the first to send a message!</p>
                </div>
            </div>
            
            <!-- Message Input Area -->
            <div class="message-input-area">
                <div class="input-container">
                    <label for="chatFileInput" class="attachment-btn" title="Attach file">
                        <i class="bi bi-paperclip"></i>
                        <input type="file" id="chatFileInput" style="display: none;">
                    </label>
                    <input type="text" placeholder="Type a message..." class="message-input" id="chatMessageInput">
                    <button class="emoji-btn" disabled title="Emojis coming soon">
                        <i class="bi bi-emoji-smile"></i>
                    </button>
                    <button class="send-btn" id="sendMessageBtn">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
                <div id="sendingIndicator" class="sending-indicator">
                    <span>Sending...</span>
                    <div class="spinner-border text-primary spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <!-- File Preview Container -->
                <div id="filePreviewContainer" class="file-preview-container">
                    <div class="file-preview">
                        <div class="file-preview-icon">
                            <i class="bi bi-file-earmark"></i>
                        </div>
                        <div class="file-preview-info">
                            <span class="file-name">filename.ext</span>
                            <span class="file-size">0 KB</span>
                        </div>
                        <button class="remove-file" id="removeFileBtn">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Panel - Group Members -->
        <div id="groupMembersPanel" class="group-members-panel">
            <div class="panel-header">
                <h3>Members</h3>
                <div class="panel-controls">
                    <button id="collapseMembers" class="panel-collapse-btn" title="Toggle members panel">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                    <div class="loading-spinner chat-spinner" id="membersPanelLoading">
                        <div class="spinner-border text-primary spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Supervisors Section -->
            <div class="members-section">
                <div class="section-header">
                    <h4>Supervisor</h4>
                </div>
                <div class="members-list" id="supervisorsList">
                    <!-- Supervisors will be loaded here dynamically -->
                    <div class="empty-members-placeholder">
                        <i class="bi bi-person-badge"></i>
                        <p>No supervisor assigned</p>
                    </div>
                </div>
            </div>
            
            <!-- Team Members Section -->
            <div class="members-section">
                <div class="section-header">
                    <h4>Team Members</h4>
                    <span class="member-count" id="teamMemberCount">0</span>
                </div>
                <div class="members-list" id="teamMembersList">
                    <!-- Team members will be loaded here dynamically -->
                    <div class="empty-members-placeholder">
                        <i class="bi bi-people"></i>
                        <p>No team members</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styling for Project Chat -->
<style>
/* Additional CSS variables needed for chat */
:root {
    --primary-rgb: 67, 97, 238;  /* RGB values for --neo-primary #4361ee */
}

/* Chat Overlay Styling */
.project-chat-overlay {
    position: fixed;
    top: 50%;
    left: 50%;
    width: 1200px;
    height: 800px;
    transform: translate(-50%, -50%);
    background-color: var(--bg-primary);
    z-index: 99999;
    display: flex;
    flex-direction: column;
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    border-radius: 16px;
    box-shadow: 0 20px 80px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.1);
    overflow: hidden;
    max-width: 95vw;
    max-height: 95vh;
    will-change: transform;
    isolation: isolate;
    contain: content;
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
}

.project-chat-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* Chat Header */
.chat-header {
    height: 60px;
    padding: 0 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    background: linear-gradient(to right, var(--bg-secondary), rgba(var(--primary-rgb), 0.05));
    position: relative;
    box-shadow: 0 1px 0 rgba(0, 0, 0, 0.08);
}

.chat-title {
    font-size: 17px;
    font-weight: 600;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    letter-spacing: 0.3px;
    position: relative;
    padding-left: 24px;
}

.chat-title:before {
    content: "";
    position: absolute;
    left: 0;
    width: 12px;
    height: 12px;
    background: var(--neo-primary);
    border-radius: 50%;
    box-shadow: 0 0 10px var(--neo-primary);
    opacity: 0.8;
}

.chat-controls {
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Collapsible panel styles */
.panel-collapse-btn {
    background: none;
    border: none;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--text-secondary);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.panel-collapse-btn:hover {
    background: rgba(var(--primary-rgb), 0.15);
    color: var(--neo-primary);
}

.panel-collapse-btn i {
    font-size: 16px;
    transition: transform 0.3s ease;
}

.chat-groups-panel.collapsed {
    width: 0;
    min-width: 0;
    padding: 0;
    overflow: hidden;
}

.group-members-panel.collapsed {
    width: 0;
    min-width: 0;
    padding: 0;
    overflow: hidden;
}

.chat-groups-panel {
    transition: width 0.3s ease, min-width 0.3s ease, padding 0.3s ease;
}

.group-members-panel {
    transition: width 0.3s ease, min-width 0.3s ease, padding 0.3s ease;
}

.chat-groups-panel.collapsed + .chat-messages-panel {
    border-left: none;
}

.chat-messages-panel + .group-members-panel.collapsed {
    border-right: none;
}

.panel-controls {
    display: flex;
    align-items: center;
    gap: 6px;
}

.panel-control, .close-chat {
    background: none;
    border: none;
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--text-secondary);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    overflow: hidden;
}

.panel-control:hover, .close-chat:hover {
    background: rgba(var(--primary-rgb), 0.15);
    color: var(--neo-primary);
    transform: translateY(-1px);
}

.panel-control:active, .close-chat:active {
    transform: translateY(1px);
}

/* Chat spinner */
.chat-spinner {
    width: 20px;
    height: 20px;
    display: none;
}

.chat-spinner.active {
    display: flex;
}

/* Chat Container */
.chat-container {
    flex: 1;
    display: flex;
    position: relative;
    overflow: hidden;
}

/* Left Panel - Chat Groups */
.chat-groups-panel {
    width: 280px;
    background-color: var(--bg-secondary);
    border-right: 1px solid rgba(255, 255, 255, 0.05);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    position: relative;
    z-index: 2;
    box-shadow: inset -5px 0 20px rgba(0, 0, 0, 0.05);
}

.add-group {
    background: none;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--text-secondary);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.add-group:hover {
    background: rgba(var(--primary-rgb), 0.15);
    color: var(--neo-primary);
    transform: translateY(-1px);
}

.groups-list {
    flex: 1;
    overflow-y: auto;
    padding: 12px;
    scrollbar-width: thin;
    scrollbar-color: rgba(var(--primary-rgb), 0.3) transparent;
}

.groups-list::-webkit-scrollbar {
    width: 4px;
}

.groups-list::-webkit-scrollbar-track {
    background: transparent;
}

.groups-list::-webkit-scrollbar-thumb {
    background-color: rgba(var(--primary-rgb), 0.3);
    border-radius: 10px;
}

.group-item {
    display: flex;
    align-items: center;
    padding: 14px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    margin-bottom: 6px;
    position: relative;
    border: 1px solid transparent;
}

.group-item:hover {
    background-color: rgba(255, 255, 255, 0.03);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    border-color: rgba(255, 255, 255, 0.05);
}

.group-item.active {
    background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.2), rgba(var(--primary-rgb), 0.1));
    border-color: rgba(var(--primary-rgb), 0.3);
    box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.15);
}

.group-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    margin-right: 14px;
    background-color: rgba(var(--primary-rgb), 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.group-avatar::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 50%;
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.1);
    pointer-events: none;
}

.group-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.group-item:hover .group-avatar img {
    transform: scale(1.05);
}

.group-avatar i {
    font-size: 20px;
    color: var(--neo-primary);
    filter: drop-shadow(0 2px 4px rgba(var(--primary-rgb), 0.5));
}

.group-info {
    flex: 1;
    overflow: hidden;
}

.group-name {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    letter-spacing: 0.2px;
}

.group-last-msg {
    font-size: 12px;
    color: var(--text-secondary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    letter-spacing: 0.1px;
    opacity: 0.8;
}

/* Center Panel - Chat Messages */
.chat-messages-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
    background-color: var(--bg-primary);
    position: relative;
    z-index: 1;
    border-left: 1px solid rgba(255, 255, 255, 0.03);
    border-right: 1px solid rgba(255, 255, 255, 0.03);
    background-image: radial-gradient(
        circle at 50% 150%, 
        rgba(var(--primary-rgb), 0.07) 0%, 
        rgba(0, 0, 0, 0) 35%
    );
}

.messages-container {
    flex: 1;
    overflow-y: auto;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    scrollbar-width: thin;
    scrollbar-color: rgba(var(--primary-rgb), 0.3) transparent;
}

.messages-container::-webkit-scrollbar {
    width: 5px;
}

.messages-container::-webkit-scrollbar-track {
    background: transparent;
}

.messages-container::-webkit-scrollbar-thumb {
    background-color: rgba(var(--primary-rgb), 0.3);
    border-radius: 10px;
}

.message-item {
    display: flex;
    max-width: 80%;
    transition: transform 0.2s ease;
}

.message-item:hover {
    transform: translateY(-1px);
}

.message-item.other-message {
    align-self: flex-start;
}

.message-item.my-message {
    align-self: flex-end;
    flex-direction: row-reverse;
}

.message-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    margin-right: 12px;
    flex-shrink: 0;
    position: relative;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.message-item.my-message .message-avatar {
    display: none;
}

.message-avatar::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 50%;
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.1);
    pointer-events: none;
}

.message-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

.message-content {
    background-color: var(--bg-secondary);
    padding: 14px 16px;
    border-radius: 16px;
    position: relative;
    border: 1px solid rgba(255, 255, 255, 0.05);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: box-shadow 0.2s ease;
}

.message-content:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.message-item.other-message .message-content {
    border-top-left-radius: 4px;
}

.message-item.my-message .message-content {
    background: linear-gradient(135deg, var(--neo-primary), rgba(var(--primary-rgb), 0.85));
    color: white;
    border-top-right-radius: 4px;
    box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.2);
    border-color: rgba(255, 255, 255, 0.1);
}

.message-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 6px;
    align-items: center;
}

.message-sender {
    font-weight: 600;
    font-size: 13px;
    letter-spacing: 0.2px;
}

.message-item.my-message .message-sender {
    color: rgba(255, 255, 255, 0.95);
}

.message-time {
    font-size: 11px;
    color: var(--text-muted);
    margin-left: 8px;
    letter-spacing: 0.1px;
}

.message-item.my-message .message-time {
    color: rgba(255, 255, 255, 0.75);
}

.message-text {
    font-size: 14px;
    line-height: 1.5;
    letter-spacing: 0.1px;
}

.system-message {
    align-self: center;
    padding: 8px 16px;
    background-color: rgba(255, 255, 255, 0.03);
    border-radius: 20px;
    margin: 10px 0;
    border: 1px solid rgba(255, 255, 255, 0.05);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    max-width: 80%;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.system-text {
    font-size: 13px;
    color: var(--text-muted);
    letter-spacing: 0.2px;
    font-weight: 500;
    text-align: center;
}

.message-input-area {
    padding: 18px 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.02), rgba(0, 0, 0, 0));
}

.input-container {
    display: flex;
    align-items: center;
    background-color: var(--bg-secondary);
    border-radius: 16px;
    padding: 4px 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.05);
    transition: all 0.3s ease;
}

.input-container:focus-within {
    box-shadow: 0 4px 15px rgba(var(--primary-rgb), 0.15), 0 0 0 1px rgba(var(--primary-rgb), 0.2);
}

.message-input {
    flex: 1;
    background: none;
    border: none;
    padding: 14px;
    color: var(--text-primary);
    outline: none;
    font-size: 15px;
    letter-spacing: 0.1px;
}

.message-input::placeholder {
    color: var(--text-muted);
    opacity: 0.7;
}

.attachment-btn, .emoji-btn, .send-btn {
    background: none;
    border: none;
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--text-secondary);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    overflow: hidden;
}

.attachment-btn::before, .emoji-btn::before, .send-btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(var(--primary-rgb), 0.1);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
    transition: width 0.4s ease, height 0.4s ease, opacity 0.4s ease;
}

.attachment-btn:hover::before, .emoji-btn:hover::before, .send-btn:hover::before {
    width: 120%;
    height: 120%;
    opacity: 1;
}

.attachment-btn i, .emoji-btn i, .send-btn i {
    position: relative;
    z-index: 1;
}

.attachment-btn:hover, .emoji-btn:hover {
    color: var(--neo-primary);
}

.send-btn {
    color: var(--neo-primary);
    margin-left: 4px;
}

.send-btn:hover {
    color: var(--neo-primary);
    transform: translateX(2px);
}

/* Right Panel - Group Members */
.group-members-panel {
    width: 260px;
    background-color: var(--bg-secondary);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    position: relative;
    z-index: 2;
    box-shadow: inset 5px 0 20px rgba(0, 0, 0, 0.05);
    border-left: 1px solid rgba(255, 255, 255, 0.05);
}

/* Original member-count CSS removed as it has been replaced with scoped version */

/* Section headers for supervisors and team members */
.project-chat-overlay .members-section {
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 8px;
    margin-bottom: 8px;
}

.project-chat-overlay .members-section:last-child {
    border-bottom: none;
}

.project-chat-overlay .section-header {
    padding: 8px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.project-chat-overlay .section-header h4 {
    font-size: 14px;
    font-weight: 600;
    margin: 0;
    color: var(--text-secondary);
}

.project-chat-overlay .members-list {
    max-height: 300px;
    overflow-y: auto;
    padding: 0 8px;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
}

.project-chat-overlay .members-list::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
}

.project-chat-overlay .member-item {
    display: flex;
    align-items: center;
    padding: 12px 14px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    margin: 2px 0;
    border: 1px solid transparent;
}

.project-chat-overlay .member-item:hover {
    background-color: rgba(255, 255, 255, 0.03);
    transform: translateX(2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    border-color: rgba(255, 255, 255, 0.05);
}

.project-chat-overlay .member-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    margin-right: 14px;
    position: relative;
    flex-shrink: 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.project-chat-overlay .member-avatar::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 50%;
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.1);
    pointer-events: none;
}

.project-chat-overlay .member-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.project-chat-overlay .member-item:hover .member-avatar img {
    transform: scale(1.05);
}

.project-chat-overlay .status-indicator {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #6c757d;
    position: absolute;
    bottom: 0;
    right: 0;
    border: 2px solid var(--bg-secondary);
    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);
}

.project-chat-overlay .member-item.online .status-indicator {
    background-color: #10b981;
    box-shadow: 0 0 6px rgba(16, 185, 129, 0.6);
}

.project-chat-overlay .member-info {
    flex: 1;
}

.project-chat-overlay .member-name {
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 2px;
}

.project-chat-overlay .member-role {
    font-size: 12px;
    color: var(--text-secondary);
}

/* Empty state for members lists */
.project-chat-overlay .empty-members-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 16px;
    text-align: center;
}

.project-chat-overlay .empty-members-placeholder i {
    font-size: 24px;
    color: var(--text-muted);
    margin-bottom: 8px;
}

.project-chat-overlay .empty-members-placeholder p {
    color: var(--text-muted);
    font-size: 13px;
    margin: 0;
}

/* Responsive styles */
@media (max-width: 1199px) {
    .project-chat-overlay {
        width: 900px;
    }
}

@media (max-width: 991px) {
    .project-chat-overlay {
        width: 95vw;
        height: 95vh;
    }
    
    .chat-groups-panel {
        position: absolute;
        left: 0;
        top: 42px;
        bottom: 0;
        z-index: 10;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .chat-groups-panel.active {
        transform: translateX(0);
    }
    
    .group-members-panel {
        position: absolute;
        right: 0;
        top: 42px;
        bottom: 0;
        z-index: 10;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    }
    
    .group-members-panel.active {
        transform: translateX(0);
    }
    
    .chat-groups-panel.minimized, 
    .group-members-panel.minimized {
        display: none;
    }
}

/* Chat Overlay Backdrop */
.project-chat-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at center, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6));
    z-index: 99990;
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
}

.project-chat-backdrop.active {
    opacity: 1;
    visibility: visible;
}

/* No-scroll helper class */
.no-scroll {
    overflow: hidden !important;
    height: 100% !important;
    width: 100% !important;
    position: fixed !important;
    margin: 0 !important;
    touch-action: none !important;
}

/* Empty state styles */
.empty-chat-groups, .empty-messages-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    text-align: center;
    height: 100%;
}

.empty-chat-groups i, .empty-messages-placeholder i {
    font-size: 36px;
    color: var(--text-muted);
    margin-bottom: 12px;
}

.empty-chat-groups p, .empty-messages-placeholder p {
    color: var(--text-secondary);
    font-size: 14px;
}

/* Sending indicator */
.sending-indicator {
    display: none;
    align-items: center;
    justify-content: center;
    padding: 4px 0;
    color: var(--text-secondary);
    font-size: 12px;
}

.sending-indicator.active {
    display: flex;
}

.sending-indicator span {
    margin-right: 6px;
}

/* File preview styling */
.file-preview-container {
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    padding: 14px;
    display: none;
}

.file-preview-container.active {
    display: block;
    animation: fadeInUp 0.3s ease forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.file-preview {
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.1), rgba(var(--primary-rgb), 0.05));
    border-radius: 12px;
    padding: 12px 16px;
    border: 1px solid rgba(var(--primary-rgb), 0.15);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.file-preview-icon {
    font-size: 24px;
    color: var(--neo-primary);
    margin-right: 12px;
    flex-shrink: 0;
}

.file-preview-icon img {
    width: 36px;
    height: 36px;
    object-fit: cover;
    border-radius: 4px;
}

.file-preview-info {
    flex: 1;
    overflow: hidden;
}

.file-preview-info .file-name {
    display: block;
    font-size: 14px;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 2px;
}

.file-preview-info .file-size {
    display: block;
    font-size: 12px;
    color: var(--text-secondary);
}

.remove-file {
    background: none;
    border: none;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--text-secondary);
    transition: all 0.2s ease;
}

.remove-file:hover {
    background: rgba(255, 255, 255, 0.2);
    color: var(--text-primary);
}

/* Message attachment styling */
.message-attachment {
    margin-top: 10px;
    padding: 12px;
    background-color: rgba(255, 255, 255, 0.03);
    border-radius: 12px;
    display: flex;
    align-items: center;
    border: 1px solid rgba(255, 255, 255, 0.08);
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
}

.message-attachment:hover {
    background-color: rgba(255, 255, 255, 0.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.attachment-icon {
    width: 46px;
    height: 46px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.1), rgba(var(--primary-rgb), 0.2));
    border-radius: 12px;
    margin-right: 14px;
    flex-shrink: 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.attachment-icon::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 10px;
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.1);
    pointer-events: none;
}

.attachment-icon i {
    font-size: 22px;
    color: var(--neo-primary);
    filter: drop-shadow(0 2px 4px rgba(var(--primary-rgb), 0.3));
}

.attachment-preview {
    width: 120px;
    height: 80px;
    border-radius: 8px;
    object-fit: cover;
    margin-right: 12px;
    flex-shrink: 0;
}

.attachment-details {
    flex: 1;
    min-width: 0; /* Ensure text truncation works */
}

.attachment-name {
    font-weight: 500;
    font-size: 14px;
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.attachment-meta {
    display: flex;
    align-items: center;
    font-size: 12px;
    color: var(--text-secondary);
}

.attachment-size {
    margin-right: 12px;
}

.attachment-download {
    color: var(--neo-primary);
    text-decoration: none;
    margin-left: auto;
    flex-shrink: 0;
    padding: 4px 8px;
    background-color: rgba(var(--primary-rgb), 0.1);
    border-radius: 4px;
    font-size: 12px;
}

.attachment-download:hover {
    background-color: rgba(var(--primary-rgb), 0.2);
}

/* Image attachment specific styling */
.image-attachment {
    margin-top: 8px;
}

.image-attachment img {
    max-width: 100%;
    max-height: 300px;
    border-radius: 8px;
    cursor: pointer;
}

/* Separator for messages from different days */
.date-separator {
    display: flex;
    align-items: center;
    margin: 10px 0;
    color: var(--text-muted);
    font-size: 12px;
    width: 100%;
}

.date-separator::before,
.date-separator::after {
    content: "";
    flex-grow: 1;
    height: 1px;
    background-color: var(--border-color);
    margin: 0 10px;
}

/* Resize handle */
.resize-handle {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 15px;
    height: 15px;
    cursor: nwse-resize;
    background: transparent;
}

/* Notification Badge for Nav Item */
.nav-notification-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background: var(--neo-magenta);
    color: white;
    font-size: 9px;
    font-weight: 600;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Active member state */
.project-chat-overlay .member-item.active {
    background-color: rgba(var(--primary-rgb), 0.15);
}

.project-chat-overlay .panel-header {
    height: 54px;
    padding: 0 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    background: linear-gradient(to right, rgba(0, 0, 0, 0.03), transparent);
    position: relative;
}

.project-chat-overlay .panel-header h3 {
    font-size: 16px;
    font-weight: 600;
    margin: 0;
    color: var(--text-primary);
    position: relative;
    padding-left: 18px;
    letter-spacing: 0.3px;
}

.project-chat-overlay .panel-header h3::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 8px;
    height: 8px;
    background-color: var(--neo-primary);
    border-radius: 50%;
    opacity: 0.9;
}

.project-chat-overlay .member-count {
    background-color: rgba(255, 255, 255, 0.1);
    color: var(--text-secondary);
    font-size: 12px;
    padding: 2px 8px;
    border-radius: 12px;
}

/* Add member item styling */
.project-chat-overlay .member-item-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.project-chat-overlay .member-item-link:hover .member-item {
    background-color: rgba(255, 255, 255, 0.05);
    transform: translateX(2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
    border-color: rgba(255, 255, 255, 0.08);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Create backdrop element
    const backdrop = document.createElement('div');
    backdrop.classList.add('project-chat-backdrop');
    document.body.appendChild(backdrop);

    // Ensure the chat overlay exists in the body for better positioning
    const chatOverlay = document.getElementById('projectChatOverlay');
    if (chatOverlay) {
        // Move the chat overlay to be a direct child of the body
        document.body.appendChild(chatOverlay);
        
        // Add isolation class to completely isolate the chat from page events
        chatOverlay.classList.add('event-isolation');
        
        // Set a specific z-index to ensure it's above everything else
        chatOverlay.style.zIndex = '99999';
    }
    
    // Chat-specific variables
    let currentProjectId = null;
    let currentProjectName = null;
    let lastMessageTimestamp = null;
    let pollingInterval = null;
    let isFirstLoad = true;
    
    // Elements (re-query after moving)
    const closeChat = document.getElementById('closeChat');
    const minimizeLeftPanel = document.getElementById('minimizeLeftPanel');
    const minimizeRightPanel = document.getElementById('minimizeRightPanel');
    const leftPanel = document.getElementById('chatGroupsPanel');
    const rightPanel = document.getElementById('groupMembersPanel');
    const messagesContainer = document.querySelector('.messages-container');
    const projectChatGroups = document.getElementById('projectChatGroups');
    const chatGroupsLoading = document.getElementById('chatGroupsLoading');
    
    // Track original scroll position
    let scrollPosition = 0;
    
    // Original window event handlers
    let originalWheel = null;
    let originalScroll = null;
    
    // Function to disable scrolling completely
    function disableScroll() {
        // Store current scroll position
        scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        
        // Add helper class to body and html
        document.body.classList.add('no-scroll');
        document.documentElement.classList.add('no-scroll');
        
        // Set body top position to retain scroll position visually
        document.body.style.top = `-${scrollPosition}px`;
        
        // Disable scroll snapping by setting global flag if it exists
        if (typeof window.allowFreeScroll !== 'undefined') {
            window.allowFreeScroll = true;
        }
        
        // Backup and remove original wheel/scroll handlers
        if (window.onwheel) {
            originalWheel = window.onwheel;
            window.onwheel = null;
        }
        if (window.onscroll) {
            originalScroll = window.onscroll;
            window.onscroll = null;
        }
        
        // Disable any existing scroll event listeners in index.php
        if (typeof window.isScrolling !== 'undefined') {
            window.isScrolling = true; // Prevent scroll handlers from executing
        }

        // Activate backdrop
        backdrop.classList.add('active');
        
        // Add event listeners directly to chat overlay to completely contain its events
        chatOverlay.addEventListener('wheel', stopPropagation, true);
        chatOverlay.addEventListener('scroll', stopPropagation, true);
        chatOverlay.addEventListener('touchmove', stopPropagation, true);
        chatOverlay.addEventListener('mousewheel', stopPropagation, true);
        chatOverlay.addEventListener('DOMMouseScroll', stopPropagation, true);
        
        // Force any document scroll handler to be passive
        window.addEventListener('scroll', preventScroll, { passive: false, capture: true });
    }

    // Function to enable scrolling
    function enableScroll() {
        // Remove helper classes
        document.body.classList.remove('no-scroll');
        document.documentElement.classList.remove('no-scroll');
        
        // Restore scroll position
        document.body.style.top = '';
        window.scrollTo(0, scrollPosition);
        
        // Restore scroll snapping if it was present
        if (typeof window.allowFreeScroll !== 'undefined') {
            window.allowFreeScroll = false;
        }
        
        // Restore original event handlers
        if (originalWheel) {
            window.onwheel = originalWheel;
        }
        if (originalScroll) {
            window.onscroll = originalScroll;
        }
        
        // Reset isScrolling in index.php if it exists
        if (typeof window.isScrolling !== 'undefined') {
            window.isScrolling = false;
        }

        // Hide backdrop
        backdrop.classList.remove('active');
        
        // Remove event listeners from chat overlay
        chatOverlay.removeEventListener('wheel', stopPropagation, true);
        chatOverlay.removeEventListener('scroll', stopPropagation, true);
        chatOverlay.removeEventListener('touchmove', stopPropagation, true);
        chatOverlay.removeEventListener('mousewheel', stopPropagation, true);
        chatOverlay.removeEventListener('DOMMouseScroll', stopPropagation, true);
        
        // Remove document scroll handler
        window.removeEventListener('scroll', preventScroll, { capture: true });
    }
    
    // Function to stop event propagation completely
    function stopPropagation(e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
    }
    
    // Function to prevent scrolling
    function preventScroll(e) {
        if (chatOverlay.classList.contains('active')) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            return false;
        }
    }

    // Capture and cancel wheel events at document level
    document.addEventListener('wheel', function(e) {
        if (chatOverlay.classList.contains('active')) {
            // We need to let events within the overlay work for scrolling chat content
            if (!chatOverlay.contains(e.target)) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            } else {
                // For events inside the overlay, prevent them from bubbling up to document
                // but still allow the default behavior for scrolling within the overlay
                e.stopPropagation();
            }
        }
    }, { passive: false, capture: true });

    // Prevent touch move events
    document.addEventListener('touchmove', function(e) {
        if (chatOverlay.classList.contains('active')) {
            if (!chatOverlay.contains(e.target)) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            } else {
                e.stopPropagation();
            }
        }
    }, { passive: false, capture: true });
    
    // Completely override scroll event
    window.addEventListener('scroll', function(e) {
        if (chatOverlay.classList.contains('active')) {
            // If we're scrolling the window while chat is open, prevent it
            e.preventDefault();
            e.stopPropagation();
            window.scrollTo(0, scrollPosition);
            return false;
        }
    }, { passive: false, capture: true });

    // Prevent keyboard scroll events
    document.addEventListener('keydown', function(e) {
        if (chatOverlay.classList.contains('active')) {
            // Prevent space, page up/down, home, end, up/down arrow keys
            const scrollKeys = [32, 33, 34, 35, 36, 38, 40];
            if (scrollKeys.includes(e.keyCode)) {
                // Allow if focus is in an input element within the chat
                const isInputFocused = chatOverlay.contains(document.activeElement) && 
                    (document.activeElement.tagName === 'INPUT' || 
                     document.activeElement.tagName === 'TEXTAREA');
                
                if (!isInputFocused) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
            }
        }
    }, { passive: false, capture: true });
    
    // Add resize handle
    const resizeHandle = document.createElement('div');
    resizeHandle.className = 'resize-handle';
    chatOverlay.appendChild(resizeHandle);
    
    let isResizing = false;
    let originalWidth, originalHeight, originalX, originalY;
    
    resizeHandle.addEventListener('mousedown', function(e) {
        isResizing = true;
        originalWidth = chatOverlay.offsetWidth;
        originalHeight = chatOverlay.offsetHeight;
        originalX = e.clientX;
        originalY = e.clientY;
        e.preventDefault();
        e.stopPropagation();
    });
    
    document.addEventListener('mousemove', function(e) {
        if (!isResizing) return;
        
        const width = originalWidth + (e.clientX - originalX);
        const height = originalHeight + (e.clientY - originalY);
        
        if (width >= 400) chatOverlay.style.width = width + 'px';
        if (height >= 300) chatOverlay.style.height = height + 'px';
        
        e.preventDefault();
        e.stopPropagation();
    });
    
    document.addEventListener('mouseup', function(e) {
        if (isResizing) {
            isResizing = false;
            e.preventDefault();
            e.stopPropagation();
        }
    });
    
    // Prevent backdrop from closing chat to avoid accidental clicks
    backdrop.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        return false;
    });
    
    // Isolate scroll events in scrollable containers
    const scrollableContainers = [
        messagesContainer, 
        document.querySelector('.groups-list'),
        document.querySelector('.members-list')
    ];
    
    scrollableContainers.forEach(container => {
        if (container) {
            container.addEventListener('wheel', function(e) {
                // Stop event from bubbling up to document
                e.stopPropagation();
            }, true);
            
            container.addEventListener('scroll', function(e) {
                // Stop event from bubbling up to document
                e.stopPropagation();
            }, true);
        }
    });
    
    // Chat button in the navbar
    const chatButton = document.getElementById('navChatButton');
    if (chatButton) {
        chatButton.addEventListener('click', function(e) {
            e.preventDefault();
            chatOverlay.classList.add('active');
            
            // Load chat groups
            loadChatGroups();
            
            // Preload faculty data for better performance
            preloadFacultyData();
            
            // Disable scrolling completely
            disableScroll();
        });
    }
    
    // Close chat overlay
    if (closeChat) {
        closeChat.addEventListener('click', function() {
            chatOverlay.classList.remove('active');
            
            // Re-enable scrolling
            enableScroll();
            
            // Stop polling
            if (pollingInterval) {
                clearInterval(pollingInterval);
                pollingInterval = null;
            }
        });
    }
    
    // Message input handling
    const chatMessageInput = document.getElementById('chatMessageInput');
    const sendMessageBtn = document.getElementById('sendMessageBtn');
    const sendingIndicator = document.getElementById('sendingIndicator');
    const fileInput = document.getElementById('chatFileInput');
    const filePreviewContainer = document.getElementById('filePreviewContainer');
    const filePreviewIcon = document.querySelector('.file-preview-icon');
    const fileName = document.querySelector('.file-preview-info .file-name');
    const fileSize = document.querySelector('.file-preview-info .file-size');
    const removeFileBtn = document.getElementById('removeFileBtn');
    
    // Selected file reference
    let selectedFile = null;
    
    // File input change handler
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            if (this.files && this.files.length > 0) {
                selectedFile = this.files[0];
                
                // Show file preview
                if (filePreviewContainer) {
                    filePreviewContainer.classList.add('active');
                    
                    // Update file info
                    if (fileName) {
                        fileName.textContent = selectedFile.name;
                    }
                    
                    if (fileSize) {
                        // Format file size
                        let formattedSize = '';
                        if (selectedFile.size < 1024) {
                            formattedSize = selectedFile.size + ' B';
                        } else if (selectedFile.size < 1024 * 1024) {
                            formattedSize = Math.round(selectedFile.size / 1024 * 10) / 10 + ' KB';
                        } else {
                            formattedSize = Math.round(selectedFile.size / (1024 * 1024) * 10) / 10 + ' MB';
                        }
                        
                        fileSize.textContent = formattedSize;
                    }
                    
                    // Update icon based on file type
                    if (filePreviewIcon) {
                        let iconClass = 'bi-file-earmark';
                        
                        // Check file type/extension
                        const fileType = selectedFile.type;
                        const fileName = selectedFile.name;
                        const extension = fileName.split('.').pop().toLowerCase();
                        
                        // Document types
                        if (fileType.includes('pdf')) {
                            iconClass = 'bi-file-earmark-pdf';
                        } else if (fileType.includes('word') || ['doc', 'docx'].includes(extension)) {
                            iconClass = 'bi-file-earmark-word';
                        } else if (fileType.includes('sheet') || ['xls', 'xlsx'].includes(extension)) {
                            iconClass = 'bi-file-earmark-excel';
                        } else if (fileType.includes('presentation') || ['ppt', 'pptx'].includes(extension)) {
                            iconClass = 'bi-file-earmark-slides';
                        } else if (fileType.includes('text')) {
                            iconClass = 'bi-file-earmark-text';
                        } else if (fileType.includes('image')) {
                            iconClass = 'bi-image';
                            
                            // For images, show a preview
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                filePreviewIcon.innerHTML = `<img src="${e.target.result}" alt="${selectedFile.name}">`;
                            };
                            reader.readAsDataURL(selectedFile);
                            
                            // Skip setting icon class since we've set HTML content
                            iconClass = null;
                        } else if (fileType.includes('video')) {
                            iconClass = 'bi-film';
                        } else if (fileType.includes('audio')) {
                            iconClass = 'bi-file-earmark-music';
                        } else if (['zip', 'rar', '7z', 'tar', 'gz'].includes(extension)) {
                            iconClass = 'bi-file-earmark-zip';
                        }
                        
                        // Update icon if we haven't replaced the HTML content
                        if (iconClass) {
                            filePreviewIcon.innerHTML = `<i class="${iconClass}"></i>`;
                        }
                    }
                }
            }
        });
    }
    
    // Remove file button click handler
    if (removeFileBtn) {
        removeFileBtn.addEventListener('click', function() {
            // Clear selected file
            selectedFile = null;
            
            // Reset file input
            if (fileInput) {
                fileInput.value = '';
            }
            
            // Hide file preview
            if (filePreviewContainer) {
                filePreviewContainer.classList.remove('active');
            }
            
            // Reset icon
            if (filePreviewIcon) {
                filePreviewIcon.innerHTML = '<i class="bi bi-file-earmark"></i>';
            }
        });
    }
    
    // Send message function
    function sendMessage() {
        if (!currentProjectId) {
            return;
        }
        
        // Check if we have a message or a file
        if (!chatMessageInput.value.trim() && !selectedFile) {
            return;
        }
        
        // Show sending indicator
        sendingIndicator.classList.add('active');
        
        // Get message text
        const messageText = chatMessageInput.value.trim();
        
        // Clear input
        chatMessageInput.value = '';
        
        // Create form data
        const formData = new FormData();
        formData.append('projectId', currentProjectId);
        formData.append('message', messageText);
        
        // Determine endpoint based on whether we have a file
        let endpoint = 'src/model/send_chat_message.php';
        
        // If we have a file, add it and change endpoint
        if (selectedFile) {
            formData.append('file', selectedFile);
            endpoint = 'src/model/upload_chat_file.php';
            
            // Clear selected file
            selectedFile = null;
            
            // Reset file input
            if (fileInput) {
                fileInput.value = '';
            }
            
            // Hide file preview
            if (filePreviewContainer) {
                filePreviewContainer.classList.remove('active');
            }
            
            // Reset icon
            if (filePreviewIcon) {
                filePreviewIcon.innerHTML = '<i class="bi bi-file-earmark"></i>';
            }
        }
        
        // Send message to server
        fetch(endpoint, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Hide sending indicator
            sendingIndicator.classList.remove('active');
            
            if (data.success) {
                // Load new messages
                loadChatMessages(currentProjectId);
            } else {
                console.error('Failed to send message:', data.message);
                // Show error toast if available
                if (typeof showToast === 'function') {
                    showToast('error', 'Failed to send message', data.message);
                }
            }
        })
        .catch(error => {
            // Hide sending indicator
            sendingIndicator.classList.remove('active');
            console.error('Error sending message:', error);
        });
    }
    
    // Send button click
    if (sendMessageBtn) {
        sendMessageBtn.addEventListener('click', sendMessage);
    }
    
    // Enter key press in input
    if (chatMessageInput) {
        chatMessageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
    }
    
    // Toggle left panel
    if (minimizeLeftPanel) {
        minimizeLeftPanel.addEventListener('click', function() {
            const panel = document.getElementById('chatGroupsPanel');
            panel.classList.toggle('collapsed');
            
            // Update icon if needed
            const collapseProjectsBtn = document.getElementById('collapseProjects');
            if (collapseProjectsBtn) {
                const icon = collapseProjectsBtn.querySelector('i');
                if (panel.classList.contains('collapsed')) {
                    icon.classList.remove('bi-chevron-left');
                    icon.classList.add('bi-chevron-right');
                } else {
                    icon.classList.remove('bi-chevron-right');
                    icon.classList.add('bi-chevron-left');
                }
            }
        });
    }
    
    // Toggle right panel
    if (minimizeRightPanel) {
        minimizeRightPanel.addEventListener('click', function() {
            const panel = document.getElementById('groupMembersPanel');
            panel.classList.toggle('collapsed');
            
            // Update icon if needed
            const collapseMembersBtn = document.getElementById('collapseMembers');
            if (collapseMembersBtn) {
                const icon = collapseMembersBtn.querySelector('i');
                if (panel.classList.contains('collapsed')) {
                    icon.classList.remove('bi-chevron-right');
                    icon.classList.add('bi-chevron-left');
                } else {
                    icon.classList.remove('bi-chevron-left');
                    icon.classList.add('bi-chevron-right');
                }
            }
        });
    }
    
    // Collapsible panels functionality
    const collapseProjects = document.getElementById('collapseProjects');
    const collapseMembers = document.getElementById('collapseMembers');
    
    if (collapseProjects) {
        collapseProjects.addEventListener('click', function() {
            const panel = document.getElementById('chatGroupsPanel');
            panel.classList.toggle('collapsed');
            
            // Rotate chevron icon
            const icon = this.querySelector('i');
            if (panel.classList.contains('collapsed')) {
                icon.classList.remove('bi-chevron-left');
                icon.classList.add('bi-chevron-right');
            } else {
                icon.classList.remove('bi-chevron-right');
                icon.classList.add('bi-chevron-left');
            }
        });
    }
    
    if (collapseMembers) {
        collapseMembers.addEventListener('click', function() {
            const panel = document.getElementById('groupMembersPanel');
            panel.classList.toggle('collapsed');
            
            // Rotate chevron icon
            const icon = this.querySelector('i');
            if (panel.classList.contains('collapsed')) {
                icon.classList.remove('bi-chevron-right');
                icon.classList.add('bi-chevron-left');
            } else {
                icon.classList.remove('bi-chevron-left');
                icon.classList.add('bi-chevron-right');
            }
        });
    }
    
    // Mobile panel toggling
    if (window.innerWidth <= 991) {
        if (minimizeLeftPanel) {
            minimizeLeftPanel.addEventListener('click', function() {
                leftPanel.classList.toggle('active');
            });
        }
        
        if (minimizeRightPanel) {
            minimizeRightPanel.addEventListener('click', function() {
                rightPanel.classList.toggle('active');
            });
        }
    }
    
    // Adjust panels on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth <= 991) {
            if (leftPanel) leftPanel.classList.remove('minimized');
            if (rightPanel) rightPanel.classList.remove('minimized');
            if (leftPanel) leftPanel.classList.remove('active');
            if (rightPanel) rightPanel.classList.remove('active');
        }
    });
    
    // Function to load chat groups
    function loadChatGroups() {
        // Show loading spinner
        if (chatGroupsLoading) {
            chatGroupsLoading.classList.add('active');
        }
        
        fetch('src/model/fetch_chat_groups.php')
            .then(response => response.json())
            .then(data => {
                // Hide loading spinner
                if (chatGroupsLoading) {
                    chatGroupsLoading.classList.remove('active');
                }
                
                if (data.success && data.chatGroups && data.chatGroups.length > 0) {
                    displayChatGroups(data.chatGroups);
                    
                    // Load members for the first group by default
                    const firstGroupId = data.chatGroups[0].id.$oid || data.chatGroups[0].id;
                    loadGroupMembers(firstGroupId);
                } else {
                    displayEmptyChatGroups();
                    console.log('No chat groups found or error:', data.message);
                }
            })
            .catch(error => {
                // Hide loading spinner
                if (chatGroupsLoading) {
                    chatGroupsLoading.classList.remove('active');
                }
                
                displayEmptyChatGroups();
                console.error('Error fetching chat groups:', error);
            });
    }
    
    // Function to display chat groups
    function displayChatGroups(groups) {
        if (!projectChatGroups) return;
        
        projectChatGroups.innerHTML = '';
        
        groups.forEach((group, index) => {
            const groupEl = document.createElement('div');
            groupEl.className = `group-item ${index === 0 ? 'active' : ''}`;
            const groupId = group.id.$oid || group.id;
            groupEl.setAttribute('data-group-id', groupId);
            
            // Group avatar (use project image if available)
            let avatarContent = '';
            if (group.imageUrl) {
                avatarContent = `<img src="${group.imageUrl}" alt="${group.name}" onerror="this.onerror=null;this.src='assets/resources/project_avatar.png';">`;
            } else {
                avatarContent = `<i class="bi bi-hash"></i>`;
            }
            
            groupEl.innerHTML = `
                <div class="group-avatar">
                    ${avatarContent}
                </div>
                <div class="group-info">
                    <div class="group-name">${group.name}</div>
                    <div class="group-last-msg">${group.lastMessage || 'No messages yet'}</div>
                </div>
            `;
            
            groupEl.addEventListener('click', function() {
                // Remove active class from all groups
                document.querySelectorAll('.group-item').forEach(item => {
                    item.classList.remove('active');
                });
                
                // Add active class to this group
                this.classList.add('active');
                
                // Get the group ID
                const groupId = this.getAttribute('data-group-id');
                
                // Set current project
                currentProjectId = groupId;
                currentProjectName = group.name;
                
                // Reset loading state
                isFirstLoad = true;
                lastMessageTimestamp = null;
                
                // Stop existing polling if any
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                }
                
                // Update chat title
                const chatTitle = document.querySelector('.chat-title');
                if (chatTitle) {
                    chatTitle.textContent = group.name || 'Project Chat';
                }
                
                // Load chat messages for this group
                loadChatMessages(groupId);
                
                // Load members for this group
                loadGroupMembers(groupId);
                
                // Start polling for new messages
                pollingInterval = setInterval(() => {
                    if (currentProjectId === groupId) {
                        loadChatMessages(groupId, true);
                    }
                }, 10000); // Poll every 10 seconds
            });
            
            projectChatGroups.appendChild(groupEl);
            
            // If this is the first group and we don't have a current project, set it
            if (index === 0 && !currentProjectId) {
                currentProjectId = groupId;
                currentProjectName = group.name;
                
                // Update chat title
                const chatTitle = document.querySelector('.chat-title');
                if (chatTitle) {
                    chatTitle.textContent = group.name || 'Project Chat';
                }
                
                // Load messages for this group
                loadChatMessages(groupId);
                
                // Start polling for new messages
                pollingInterval = setInterval(() => {
                    if (currentProjectId === groupId) {
                        loadChatMessages(groupId, true);
                    }
                }, 10000); // Poll every 10 seconds
            }
        });
    }
    
    // Function to load group members (supervisor and team members)
    function loadGroupMembers(projectId) {
        // Show loading spinner
        const membersPanelLoading = document.getElementById('membersPanelLoading');
        if (membersPanelLoading) {
            membersPanelLoading.classList.add('active');
        }
        
        // Get supervisor and team members lists
        const supervisorsList = document.getElementById('supervisorsList');
        const teamMembersList = document.getElementById('teamMembersList');
        const teamMemberCount = document.getElementById('teamMemberCount');
        
        if (!supervisorsList || !teamMembersList) return;
        
        // Clear previous members
        supervisorsList.innerHTML = '';
        teamMembersList.innerHTML = '';
        
        // Fetch project details to get supervisor and team members
        fetch(`src/model/get_project.php?id=${projectId}`)
            .then(response => response.json())
            .then(data => {
                // Hide loading spinner
                if (membersPanelLoading) {
                    membersPanelLoading.classList.remove('active');
                }
                
                if (data && data.project) {
                    const project = data.project;
                    
                    // Display supervisor
                    if (project.supervisor && project.supervisor.name) {
                        // Get supervisor data with profile image
                        getUserData(project.supervisor.userId, 'faculty')
                            .then(supervisorData => {
                                const profileImage = supervisorData?.profile_image || 
                                                    supervisorData?.profile_image_url || 
                                                    'assets/resources/user_avatar.png';
                                
                                const supervisorId = project.supervisor.userId.$oid || project.supervisor.userId;
                                
                                supervisorsList.innerHTML = `
                                    <a href="Faculty_Profile.php?id=${supervisorId}" class="member-item-link">
                                        <div class="member-item online">
                                            <div class="member-avatar">
                                                <img src="${profileImage}" alt="${project.supervisor.name}" 
                                                     onerror="this.onerror=null;this.src='assets/resources/user_avatar.png';">
                                                <span class="status-indicator"></span>
                                            </div>
                                            <div class="member-info">
                                                <div class="member-name">${project.supervisor.name}</div>
                                                <div class="member-role">${project.supervisor.role || 'Supervisor'}</div>
                                            </div>
                                        </div>
                                    </a>
                                `;
                            })
                            .catch(() => {
                                // Fallback if data fetch fails
                                const supervisorId = project.supervisor.userId.$oid || project.supervisor.userId;
                                
                                supervisorsList.innerHTML = `
                                    <a href="Faculty_Profile.php?id=${supervisorId}" class="member-item-link">
                                        <div class="member-item online">
                                            <div class="member-avatar">
                                                <img src="assets/resources/user_avatar.png" alt="${project.supervisor.name}">
                                                <span class="status-indicator"></span>
                                            </div>
                                            <div class="member-info">
                                                <div class="member-name">${project.supervisor.name}</div>
                                                <div class="member-role">${project.supervisor.role || 'Supervisor'}</div>
                                            </div>
                                        </div>
                                    </a>
                                `;
                            });
                    } else {
                        supervisorsList.innerHTML = `
                            <div class="empty-members-placeholder">
                                <i class="bi bi-person-badge"></i>
                                <p>No supervisor assigned</p>
                            </div>
                        `;
                    }
                    
                    // Display team members
                    if (project.members && project.members.length > 0) {
                        teamMembersList.innerHTML = '';
                        
                        // Update team member count
                        if (teamMemberCount) {
                            teamMemberCount.textContent = project.members.length;
                        }
                        
                        // Process each member and fetch their data
                        project.members.forEach(member => {
                            // Skip if no name
                            if (!member.name) return;
                            
                            const memberUserId = member.userId?.$oid || member.userId || '';
                            
                            // Temporary display while fetching data
                            const tempMemberEl = document.createElement('div');
                            tempMemberEl.className = 'member-item-link-wrapper';
                            tempMemberEl.setAttribute('data-user-id', memberUserId);
                            
                            let memberHTML = '';
                            if (memberUserId) {
                                memberHTML = `
                                    <a href="Student_Profile.php?id=${memberUserId}" class="member-item-link">
                                        <div class="member-item">
                                            <div class="member-avatar">
                                                <img src="assets/resources/user_avatar.png" alt="${member.name}">
                                                <span class="status-indicator"></span>
                                            </div>
                                            <div class="member-info">
                                                <div class="member-name">${member.name}</div>
                                                <div class="member-role">${member.role || 'Team Member'}</div>
                                            </div>
                                        </div>
                                    </a>
                                `;
                            } else {
                                memberHTML = `
                                    <div class="member-item">
                                        <div class="member-avatar">
                                            <img src="assets/resources/user_avatar.png" alt="${member.name}">
                                            <span class="status-indicator"></span>
                                        </div>
                                        <div class="member-info">
                                            <div class="member-name">${member.name}</div>
                                            <div class="member-role">${member.role || 'Team Member'}</div>
                                        </div>
                                    </div>
                                `;
                            }
                            
                            tempMemberEl.innerHTML = memberHTML;
                            teamMembersList.appendChild(tempMemberEl);
                            
                            // Try to get user data and update the element
                            if (member.userId) {
                                console.log(`Fetching data for member: ${member.name}, ID: ${member.userId.$oid || member.userId}`);
                                getUserData(member.userId, 'student')
                                    .then(userData => {
                                        if (userData) {
                                            console.log(`Got user data for: ${member.name}`, userData);
                                            const userIdStr = member.userId.$oid || member.userId;
                                            const userElement = teamMembersList.querySelector(`[data-user-id="${userIdStr}"]`);
                                            if (userElement) {
                                                console.log(`Found element for user: ${member.name}`);
                                                // Update profile image if available
                                                const profileImage = userData.profile_image || 
                                                                    userData.profile_image_url || 
                                                                    userData.basic_info?.profile_image_url ||
                                                                    'assets/resources/user_avatar.png';
                                                
                                                console.log(`Profile image path for ${member.name}: ${profileImage}`);
                                                
                                                const imgElement = userElement.querySelector('.member-avatar img');
                                                if (imgElement) {
                                                    imgElement.src = profileImage;
                                                    imgElement.onerror = function() {
                                                        console.log(`Error loading image for ${member.name}, using default`);
                                                        this.onerror = null;
                                                        this.src = 'assets/resources/user_avatar.png';
                                                    };
                                                }
                                                
                                                // Randomly assign online status for demo
                                                const isOnline = Math.random() < 0.3;
                                                if (isOnline) {
                                                    const memberItem = userElement.querySelector('.member-item');
                                                    if (memberItem) {
                                                        memberItem.classList.add('online');
                                                    }
                                                }
                                            } else {
                                                console.error(`Couldn't find element for user ID: ${userIdStr}`);
                                            }
                                        } else {
                                            console.log(`No user data found for: ${member.name}`);
                                        }
                                    })
                                    .catch(error => {
                                        console.error(`Error fetching data for ${member.name}:`, error);
                                    });
                            }
                        });
                    } else {
                        teamMembersList.innerHTML = `
                            <div class="empty-members-placeholder">
                                <i class="bi bi-people"></i>
                                <p>No team members</p>
                            </div>
                        `;
                        
                        // Update team member count to 0
                        if (teamMemberCount) {
                            teamMemberCount.textContent = '0';
                        }
                    }
                } else {
                    // Display empty states
                    supervisorsList.innerHTML = `
                        <div class="empty-members-placeholder">
                            <i class="bi bi-person-badge"></i>
                            <p>No supervisor assigned</p>
                        </div>
                    `;
                    
                    teamMembersList.innerHTML = `
                        <div class="empty-members-placeholder">
                            <i class="bi bi-people"></i>
                            <p>No team members</p>
                        </div>
                    `;
                    
                    // Update team member count to 0
                    if (teamMemberCount) {
                        teamMemberCount.textContent = '0';
                    }
                    
                    console.log('No project data found or error:', data?.message || 'Unknown error');
                }
            })
            .catch(error => {
                // Hide loading spinner
                if (membersPanelLoading) {
                    membersPanelLoading.classList.remove('active');
                }
                
                // Display empty states
                supervisorsList.innerHTML = `
                    <div class="empty-members-placeholder">
                        <i class="bi bi-person-badge"></i>
                        <p>Failed to load supervisor</p>
                    </div>
                `;
                
                teamMembersList.innerHTML = `
                    <div class="empty-members-placeholder">
                        <i class="bi bi-people"></i>
                        <p>Failed to load team members</p>
                    </div>
                `;
                
                console.error('Error fetching project members:', error);
            });
    }
    
    // Cache for user data to prevent redundant requests
    const userDataCache = {
        faculty: {},
        student: {}
    };
    
    // Function to get user data with caching
    async function getUserData(userId, userType = null) {
        if (!userId) return null;
        
        // Extract ObjectId if needed
        let userIdStr = userId;
        if (typeof userId === 'object' && userId.$oid) {
            userIdStr = userId.$oid;
        }
        
        // Check if we already have cached data for this user
        if (userType === 'faculty' && userDataCache.faculty[userIdStr]) {
            return userDataCache.faculty[userIdStr];
        }
        
        if (userType === 'student' && userDataCache.student[userIdStr]) {
            return userDataCache.student[userIdStr];
        }
        
        // If userType is not specified, check both caches
        if (!userType) {
            if (userDataCache.faculty[userIdStr]) {
                return userDataCache.faculty[userIdStr];
            }
            if (userDataCache.student[userIdStr]) {
                return userDataCache.student[userIdStr];
            }
        }
        
        // Try to fetch user data
        try {
            // First, check if we already have this type of data globally available
            if (userType === 'faculty' && window.facultyData) {
                const faculty = window.facultyData.find(f => 
                    (f._id && f._id.$oid === userIdStr) || (f._id === userIdStr)
                );
                if (faculty) {
                    userDataCache.faculty[userIdStr] = faculty;
                    return faculty;
                }
            }
            
            // Fetch user profile data
            let url, resultField;
            
            if (userType === 'faculty' || (!userType && !userDataCache.faculty[userIdStr])) {
                // Try faculty endpoint
                const response = await fetch(`src/model/get_faculty_data.php?id=${userIdStr}`);
                const data = await response.json();
                
                if (data && data.success && data.faculty) {
                    userDataCache.faculty[userIdStr] = data.faculty;
                    return data.faculty;
                }
            }
            
            if (userType === 'student' || (!userType && !userDataCache.student[userIdStr])) {
                // Try student endpoint
                const response = await fetch(`src/model/get_student_data.php?id=${userIdStr}`);
                const data = await response.json();
                
                if (data && data.success && data.student) {
                    userDataCache.student[userIdStr] = data.student;
                    return data.student;
                }
            }
            
            // If we get here, either both lookups failed or the specific one failed
            console.log(`User data not found for userId: ${userIdStr}, type: ${userType || 'any'}`);
            return null;
            
        } catch (error) {
            console.error('Error fetching user data:', error);
            return null;
        }
    }
    
    // Function to display empty state for chat groups
    function displayEmptyChatGroups() {
        if (!projectChatGroups) return;
        
        projectChatGroups.innerHTML = `
            <div class="empty-chat-groups">
                <i class="bi bi-chat-square-text"></i>
                <p>You don't have any project chat groups yet.<br>Join a project to start chatting.</p>
            </div>
        `;
    }

    // Handle clicking on members to open direct messages
    document.addEventListener('click', function(e) {
        // Find the closest member-item parent
        const memberItem = e.target.closest('.member-item');
        
        if (memberItem && memberItem.closest('.project-chat-overlay')) {
            // Don't execute this handler if the item is inside a link
            if (e.target.closest('.member-item-link')) {
                return;
            }
            
            // Get the member name
            const memberName = memberItem.querySelector('.member-name').textContent;
            
            // For now, just show a message - would implement direct messaging in the future
            console.log(`Open direct message with ${memberName}`);
            
            // Add visual feedback
            memberItem.classList.add('active');
            setTimeout(() => {
                memberItem.classList.remove('active');
            }, 300);
            
            // Future: Implement direct messaging feature
        }
    });

    // Function to preload faculty data
    function preloadFacultyData() {
        // Check if we already have faculty data
        if (window.facultyData) return;
        
        console.log('Preloading faculty data...');
        fetch('src/model/load_faculty.php')
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)) {
                    window.facultyData = data;
                    console.log(`Loaded ${data.length} faculty members`);
                    
                    // Cache faculty data by ID for quick lookup
                    data.forEach(faculty => {
                        if (faculty._id) {
                            const facultyId = faculty._id.$oid || faculty._id;
                            userDataCache.faculty[facultyId] = faculty;
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error preloading faculty data:', error);
            });
    }

    // Function to load chat messages
    function loadChatMessages(projectId, isPoll = false) {
        if (!projectId || !messagesContainer) return;
        
        // Don't show loading indicator for polling
        if (!isPoll) {
            // Show loading spinner
            const messageLoading = document.createElement('div');
            messageLoading.className = 'loading-spinner chat-spinner active text-center my-3';
            messageLoading.id = 'messageLoading';
            messageLoading.innerHTML = `
                <div class="spinner-border text-primary spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading messages...</span>
                </div>
                <div class="text-muted small mt-1">Loading messages...</div>
            `;
            
            // Only add loading indicator if it's the first load
            if (isFirstLoad) {
                messagesContainer.innerHTML = '';
                messagesContainer.appendChild(messageLoading);
            }
        }
        
        // Prepare query parameters
        let url = `src/model/load_chat_messages.php?projectId=${projectId}`;
        
        // If we have a last message timestamp and this is a poll, only get newer messages
        if (lastMessageTimestamp && isPoll) {
            url += `&after=${lastMessageTimestamp}`;
        }
        
        // Fetch messages
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Remove loading spinner if it exists
                const loadingEl = document.getElementById('messageLoading');
                if (loadingEl) {
                    loadingEl.remove();
                }
                
                if (data.success) {
                    // If this is a poll and we have new messages, append them
                    if (isPoll && data.messages.length > 0) {
                        appendMessages(data.messages);
                    } 
                    // If this is the first load or not a poll, replace all messages
                    else if (!isPoll || isFirstLoad) {
                        displayMessages(data.messages);
                        isFirstLoad = false;
                    }
                    
                    // Update last message timestamp if we have messages
                    if (data.messages.length > 0) {
                        const lastMsg = data.messages[data.messages.length - 1];
                        lastMessageTimestamp = lastMsg.timestamp;
                    }
                    
                    // Focus the message input
                    if (!isPoll && chatMessageInput) {
                        chatMessageInput.focus();
                    }
                } else {
                    console.error('Failed to load messages:', data.message);
                    
                    // Show no messages placeholder if there's a problem
                    if (!isPoll && isFirstLoad) {
                        const noMessagesPlaceholder = document.getElementById('noMessagesPlaceholder');
                        if (noMessagesPlaceholder) {
                            noMessagesPlaceholder.style.display = 'flex';
                        }
                    }
                }
            })
            .catch(error => {
                // Remove loading spinner if it exists
                const loadingEl = document.getElementById('messageLoading');
                if (loadingEl) {
                    loadingEl.remove();
                }
                
                console.error('Error loading messages:', error);
            });
    }
    
    // Function to display messages
    function displayMessages(messages) {
        if (!messagesContainer) return;
        
        // Clear messages container
        messagesContainer.innerHTML = '';
        
        // If no messages, show placeholder
        if (!messages || messages.length === 0) {
            messagesContainer.innerHTML = `
                <div id="noMessagesPlaceholder" class="empty-messages-placeholder">
                    <i class="bi bi-chat-square-text"></i>
                    <p>No messages yet. Be the first to send a message!</p>
                </div>
            `;
            return;
        }
        
        // Hide no messages placeholder
        const noMessagesPlaceholder = document.getElementById('noMessagesPlaceholder');
        if (noMessagesPlaceholder) {
            noMessagesPlaceholder.style.display = 'none';
        }
        
        // Group messages by date
        let currentDate = null;
        
        messages.forEach(message => {
            // Format message timestamp to date
            const messageDate = new Date(message.timestamp * 1000).toLocaleDateString();
            
            // If this is a new date, add a date separator
            if (messageDate !== currentDate) {
                const dateSeparator = document.createElement('div');
                dateSeparator.className = 'date-separator';
                dateSeparator.textContent = messageDate;
                messagesContainer.appendChild(dateSeparator);
                currentDate = messageDate;
            }
            
            // Append message to container
            appendSingleMessage(message, messagesContainer);
        });
        
        // Scroll to the bottom of the messages container
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
    
    // Function to append new messages
    function appendMessages(messages) {
        if (!messagesContainer || !messages || messages.length === 0) return;
        
        // Hide no messages placeholder if it exists
        const noMessagesPlaceholder = document.getElementById('noMessagesPlaceholder');
        if (noMessagesPlaceholder) {
            noMessagesPlaceholder.style.display = 'none';
        }
        
        // Get last date in the current message list
        let lastDateEl = messagesContainer.querySelector('.date-separator:last-of-type');
        let lastDate = lastDateEl ? lastDateEl.textContent : null;
        
        messages.forEach(message => {
            // Format message timestamp to date
            const messageDate = new Date(message.timestamp * 1000).toLocaleDateString();
            
            // If this is a new date, add a date separator
            if (messageDate !== lastDate) {
                const dateSeparator = document.createElement('div');
                dateSeparator.className = 'date-separator';
                dateSeparator.textContent = messageDate;
                messagesContainer.appendChild(dateSeparator);
                lastDate = messageDate;
            }
            
            // Append message to container
            appendSingleMessage(message, messagesContainer);
        });
        
        // Scroll to the bottom only if user is already at the bottom
        const isAtBottom = messagesContainer.scrollTop + messagesContainer.clientHeight >= messagesContainer.scrollHeight - 100;
        
        if (isAtBottom) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }
    
    // Function to append a single message
    function appendSingleMessage(message, container) {
        // Create message element
        const messageEl = document.createElement('div');
        messageEl.className = `message-item ${message.isCurrentUser ? 'my-message' : 'other-message'}`;
        messageEl.setAttribute('data-message-id', message.id);
        
        // System message has different styling
        if (message.isSystem) {
            messageEl.className = 'system-message';
            messageEl.innerHTML = `
                <div class="system-text">
                    ${message.message}
                </div>
            `;
            container.appendChild(messageEl);
            return;
        }
        
        // Regular message
        let html = '';
        
        // Only add avatar for other users' messages
        if (!message.isCurrentUser) {
            html += `
                <div class="message-avatar">
                    <img src="${message.profileImage}" alt="${message.sender.name}" 
                         onerror="this.onerror=null;this.src='assets/resources/user_avatar.png';">
                </div>
            `;
        }
        
        // Add message content
        html += `
            <div class="message-content">
                <div class="message-header">
                    <span class="message-sender">${message.isCurrentUser ? 'Me' : message.sender.name}</span>
                    <span class="message-time">${message.formattedTime}</span>
                </div>
                <div class="message-text">
                    ${message.message}
                </div>
            `;
        
        // Add attachment if exists
        if (message.attachment) {
            const attachment = message.attachment;
            
            // Image attachment shows preview
            if (attachment.fileCategory === 'image') {
                html += `
                    <div class="image-attachment">
                        <a href="${attachment.filePath}" target="_blank">
                            <img src="${attachment.filePath}" alt="${attachment.fileName}" 
                                 onerror="this.onerror=null;this.style.display='none';">
                        </a>
                    </div>
                `;
            } else {
                // Other file types
                html += `
                    <div class="message-attachment">
                        <div class="attachment-icon">
                            <i class="${attachment.iconClass || 'bi-file-earmark'}"></i>
                        </div>
                        <div class="attachment-details">
                            <div class="attachment-name">${attachment.fileName}</div>
                            <div class="attachment-meta">
                                <span class="attachment-size">${attachment.formattedSize || '0 B'}</span>
                                <span class="attachment-type">${attachment.fileExtension.toUpperCase()}</span>
                            </div>
                        </div>
                        <a href="${attachment.filePath}" class="attachment-download" download="${attachment.fileName}">
                            Download
                        </a>
                    </div>
                `;
            }
        }
        
        html += '</div>'; // Close message-content
        
        messageEl.innerHTML = html;
        container.appendChild(messageEl);
    }
});
</script> 