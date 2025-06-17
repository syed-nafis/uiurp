<?php
session_start();

require __DIR__ . '/vendor/autoload.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

// Get project ID from URL
$projectId = isset($_GET['id']) ? $_GET['id'] : null;
if (!$projectId) {
    header('Location: index.php');
    exit();
}

// Connect to MongoDB
$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $client->uiurp;
$project_collection = $db->projectsV2;
$literature_collection = $db->literature_matrix;

// Get project details
$project = $project_collection->findOne(['_id' => new MongoDB\BSON\ObjectId($projectId)]);
if (!$project) {
    header('Location: index.php');
    exit();
}

$userId = $_SESSION['user_id'];

// Get literature matrix data for this project
$literatureMatrix = $literature_collection->findOne(['projectId' => new MongoDB\BSON\ObjectId($projectId)]);

// Initialize default tags
$defaultTags = [
    ['name' => 'Publication Year', 'color' => 'var(--tag-blue)'],
    ['name' => 'Research Aim / Objective', 'color' => 'var(--tag-green)'],
    ['name' => 'Dataset', 'color' => 'var(--tag-purple)'],
    ['name' => 'Methodology', 'color' => 'var(--tag-orange)'],
    ['name' => 'Findings', 'color' => 'var(--tag-blue)'],
    ['name' => 'Research Gap', 'color' => 'var(--tag-green)'],
    ['name' => 'Future Work', 'color' => 'var(--tag-purple)'],
    ['name' => 'Relevance', 'color' => 'var(--tag-orange)'],
    ['name' => 'Keywords/Theme', 'color' => 'var(--tag-blue)'],
    ['name' => 'Citation/BibTeX', 'color' => 'var(--tag-green)']
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Literature Matrix - <?php echo htmlspecialchars($project->title); ?></title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Include custom CSS for Notion-like design -->
    <style>
        :root {
            --notion-gray: #f7f6f3;
            --notion-border: #e3e3e1;
            --tag-blue: #deeafd;
            --tag-green: #dbeddb;
            --tag-purple: #e9e3fd;
            --tag-orange: #ffe2dd;
        }

        body {
            background-color: #ffffff;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, "Apple Color Emoji", Arial, sans-serif;
            padding-top: 60px; /* Add padding for fixed navbar */
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 15px; /* Add horizontal padding */
        }

        .tag-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding: 1rem;
            background: var(--notion-gray);
            border-radius: 8px;
            border: 1px solid var(--notion-border);
        }

        .tag {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            user-select: none;
            position: relative;
        }

        .tag.selected {
            background-color: var(--tag-blue) !important;
            color: #000;
            font-weight: 500;
        }

        .tag:hover {
            opacity: 0.8;
        }

        .literature-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            table-layout: fixed; /* Add fixed table layout */
        }

        .literature-table thead {
            position: sticky;
            top: 0;
            z-index: 2;
            background: var(--notion-gray);
        }

        .literature-table th {
            position: sticky;
            top: 0;
            background: var(--notion-gray);
            z-index: 2;
            padding: 12px 15px;
            border-bottom: 2px solid var(--notion-border);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Set specific widths for different columns */
        .literature-table th:first-child,
        .literature-table td:first-child {
            width: 250px; /* Fixed width for filename column */
            max-width: 250px;
        }

        .literature-table td {
            background: white;
            padding: 12px 15px;
            border: 1px solid var(--notion-border);
            vertical-align: top;
            word-wrap: break-word; /* Allow word wrapping */
            overflow-wrap: break-word;
        }

        /* Add ellipsis for long filenames */
        .literature-table td:first-child {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Show full filename on hover */
        .literature-table td:first-child:hover {
            white-space: normal;
            overflow: visible;
            position: relative;
            z-index: 1;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Ensure other columns take up remaining space evenly */
        .literature-table th:not(:first-child),
        .literature-table td:not(:first-child) {
            width: auto;
            min-width: 200px;
        }

        .upload-section {
            margin: 2rem 0;
            padding: 2rem;
            background: var(--notion-gray);
            border-radius: 8px;
            border: 1px solid var(--notion-border);
        }

        .btn-notion {
            background: black;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-notion:hover {
            background: #333;
        }

        #fileList {
            margin-top: 1rem;
        }

        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem;
            background: white;
            border-radius: 4px;
            margin-bottom: 0.5rem;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }
        .alert-info {
            background-color: var(--tag-blue);
            color: #004085;
        }

        .retry-button {
            background: var(--tag-blue);
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            margin-left: 8px;
            transition: all 0.2s;
        }

        .retry-button:hover {
            background: #c5d9fc;
        }

        .retry-button.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .file-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cell-loading {
            background-color: var(--tag-blue);
            opacity: 0.7;
        }

        .delete-file {
            color: #dc3545;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .delete-file:hover {
            background-color: #dc3545;
            color: white;
        }

        .tag-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .loading-spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-left-color: #000;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .last-edit-info {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }

        /* Add loading animation */
        .analysis-progress {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            text-align: center;
        }

        .progress-bar {
            width: 100%;
            height: 4px;
            background: #f0f0f0;
            border-radius: 2px;
            margin-top: 10px;
        }

        .progress-bar-fill {
            height: 100%;
            background: var(--tag-blue);
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        /* Fix table header alignment */
        .table-responsive {
            overflow-x: auto;
            margin-top: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 8px;
            position: relative;
        }

        /* Trendy generation overlay */
        .generation-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(30, 144, 255, 0.15); /* blue haze */
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(2px);
        }
        .spinner-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(255,255,255,0.85);
            padding: 2rem 3rem;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(30,144,255,0.15);
        }
        .trendy-spinner {
            width: 3rem;
            height: 3rem;
            border: 4px solid #b3d8fd;
            border-top: 4px solid #1e90ff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 1rem;
        }
        .spinner-text {
            font-size: 1.2rem;
            color: #1e90ff;
            font-weight: 500;
            letter-spacing: 0.03em;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .generation-status-row {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .spinner-inline {
            width: 1.5rem;
            height: 1.5rem;
            border: 3px solid #b3d8fd;
            border-top: 3px solid #1e90ff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        .spinner-inline-text {
            font-size: 1.1rem;
            color: #1e90ff;
            font-weight: 500;
            letter-spacing: 0.02em;
        }
        .file-item.generating {
            background: #e6f2ff !important;
            box-shadow: 0 2px 8px rgba(30,144,255,0.06);
        }
        .spinner-inline {
            width: 1.5rem;
            height: 1.5rem;
            border: 3px solid #b3d8fd;
            border-top: 3px solid #1e90ff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 0.5rem;
        }
        .spinner-inline-text {
            font-size: 1.1rem;
            color: #1e90ff;
            font-weight: 500;
            letter-spacing: 0.02em;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Literature Matrix - <?php echo htmlspecialchars($project->title); ?></h1>
            <a href="Project_details.php?id=<?php echo $projectId; ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Back to Project
            </a>
        </div>
        
        <!-- Tag Management Section -->
        <div class="mb-4">
            <h4>Choose Your Columns</h4>
            <div class="tag-container" id="tagContainer">
                <!-- Tags will be dynamically added here -->
            </div>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="newTagInput" placeholder="Add new tag">
                <button class="btn btn-notion" onclick="addNewTag()">Add Tag</button>
            </div>
        </div>

        <!-- File Upload Section -->
        <div class="upload-section">
            <h4>Upload PDF Files</h4>
            <input type="file" id="pdfUpload" accept=".pdf" class="form-control mb-3" multiple>
            <button class="btn btn-notion" onclick="handleFileUpload()">Upload Files</button>
            <div id="fileList" class="mt-3"></div>
            <div id="generateButtonContainer" class="mt-3" style="display: none;">
                <hr class="my-3">
                <button class="btn btn-notion" onclick="generateMatrix()" id="generateBtn">
                    Generate Matrix
                </button>
            </div>
            <div id="generationStatusRow" class="generation-status-row mt-3"></div>
        </div>

        <!-- Literature Matrix Table -->
        <div class="table-responsive">
            <table class="literature-table" id="literatureTable">
                <thead>
                    <tr id="tableHeader">
                        <th>File Name</th>
                        <!-- Dynamic columns will be added here based on selected tags -->
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Table content will be dynamically added here -->
                </tbody>
            </table>
        </div>

        <!-- Export Button -->
        <div class="mt-4">
            <button class="btn btn-notion" onclick="exportTable()">Export to Excel</button>
        </div>
    </div>

    <!-- Include necessary JavaScript libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    <script>
        // Set worker path for pdf.js
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

        const GEMINI_API_KEY = 'AIzaSyBTQJjyfEL0sNGGU8xFW8Ff-KkrQQwB4rI';
        const GEMINI_API_URL = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent';
        const PROJECT_ID = '<?php echo $projectId; ?>';
        const USER_ID = '<?php echo $userId; ?>';
        const USER_NAME = '<?php echo $_SESSION['username']; ?>';

        // Available tags with different colors
        let availableTags = <?php echo json_encode($defaultTags); ?>;
        let selectedTags = new Set(<?php 
            if ($literatureMatrix && isset($literatureMatrix['selectedTags'])) {
                // Convert BSON array to PHP array first
                $selectedTags = iterator_to_array($literatureMatrix['selectedTags']);
                echo json_encode(array_map(function($tag) { return $tag['name']; }, $selectedTags));
            } else {
                echo '[]';
            }
        ?>);

        // Store PDF text content for retry functionality
        let pdfContents = new Map(); // Map to store PDF text content by filename
        let uploadedFiles = <?php 
            if ($literatureMatrix && isset($literatureMatrix['files'])) {
                // Convert BSON array to PHP array
                $files = iterator_to_array($literatureMatrix['files']);
                echo json_encode($files);
            } else {
                echo '[]';
            }
        ?>;

        // Initialize the page
        function init() {
            renderTags();
            updateTable();
            updateFileList();
        }

        // Render tags in the tag container
        function renderTags() {
            const tagContainer = document.getElementById('tagContainer');
            tagContainer.innerHTML = '';

            availableTags.forEach(tag => {
                const tagElement = document.createElement('span');
                tagElement.className = `tag ${selectedTags.has(tag.name) ? 'selected' : ''}`;
                const indicator = document.createElement('span');
                indicator.className = 'tag-indicator';
                indicator.style.backgroundColor = tag.color;
                tagElement.appendChild(indicator);
                tagElement.appendChild(document.createTextNode(tag.name));
                
                // Always set a background color
                tagElement.style.backgroundColor = selectedTags.has(tag.name) ? tag.color : '#ffffff';
                tagElement.style.border = '1px solid ' + tag.color;
                
                tagElement.onclick = () => toggleTag(tag.name);
                tagContainer.appendChild(tagElement);
            });
        }

        // Toggle tag selection
        function toggleTag(tagName) {
            if (selectedTags.has(tagName)) {
                selectedTags.delete(tagName);
            } else {
                selectedTags.add(tagName);
            }
            renderTags();
            updateTable();
            saveToDatabase();
        }

        // Add new tag
        function addNewTag() {
            const input = document.getElementById('newTagInput');
            const tagName = input.value.trim();
            
            if (tagName && !availableTags.some(tag => tag.name === tagName)) {
                const colors = ['var(--tag-blue)', 'var(--tag-green)', 'var(--tag-purple)', 'var(--tag-orange)'];
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                
                availableTags.push({ name: tagName, color: randomColor });
                selectedTags.add(tagName);
                input.value = '';
                renderTags();
                updateTable();
                saveToDatabase();
            }
        }

        // Function to extract text from PDF with chunking
        async function extractTextFromPDF(file) {
            return new Promise((resolve, reject) => {
                // Check file size
                const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB
                if (file.size > MAX_FILE_SIZE) {
                    reject(`File ${file.name} is too large. Maximum size is 10MB.`);
                    return;
                }

                const reader = new FileReader();
                reader.onload = async function(event) {
                    try {
                        const typedarray = new Uint8Array(event.target.result);
                        const pdf = await pdfjsLib.getDocument(typedarray).promise;
                        
                        let fullText = '';
                        for(let i = 1; i <= pdf.numPages; i++) {
                            const page = await pdf.getPage(i);
                            const textContent = await page.getTextContent();
                            const pageText = textContent.items.map(item => item.str).join(' ');
                            fullText += pageText + '\n';
                        }
                        resolve(fullText);
                    } catch (error) {
                        reject(error);
                    }
                };
                reader.readAsArrayBuffer(file);
            });
        }

        // Function to analyze text with Gemini (with retry)
        async function analyzeWithGemini(text, tag) {
            const MAX_RETRIES = 3;
            const RETRY_DELAY = 2000; // 2 seconds
            // const CHUNK_SIZE = 5000; // characters per chunk

            // No chunking: send the entire text in one call
            let retries = 0;
            while (retries < MAX_RETRIES) {
                try {
                    const prompt = `Analyze this research paper text and extract information relevant to the category "${tag}". 
Provide a very concise summary of the key points related to this category.
Text: ${text}`;

                    const response = await fetch(`${GEMINI_API_URL}?key=${GEMINI_API_KEY}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            contents: [{
                                parts: [{
                                    text: prompt
                                }]
                            }],
                            generationConfig: {
                                temperature: 0.4,
                                topK: 32,
                                topP: 0.8,
                                maxOutputTokens: 512,
                            },
                            safetySettings: [
                                {
                                    category: "HARM_CATEGORY_HARASSMENT",
                                    threshold: "BLOCK_MEDIUM_AND_ABOVE"
                                },
                                {
                                    category: "HARM_CATEGORY_HATE_SPEECH",
                                    threshold: "BLOCK_MEDIUM_AND_ABOVE"
                                },
                                {
                                    category: "HARM_CATEGORY_SEXUALLY_EXPLICIT",
                                    threshold: "BLOCK_MEDIUM_AND_ABOVE"
                                },
                                {
                                    category: "HARM_CATEGORY_DANGEROUS_CONTENT",
                                    threshold: "BLOCK_MEDIUM_AND_ABOVE"
                                }
                            ]
                        })
                    });

                    if (response.status === 429) {
                        throw new Error('Rate limit exceeded');
                    }

                    const data = await response.json();
                    if (data.candidates && data.candidates[0].content.parts[0].text) {
                        return data.candidates[0].content.parts[0].text;
                    }
                    throw new Error('Analysis failed');
                } catch (error) {
                    retries++;
                    if (retries === MAX_RETRIES) {
                        console.error('Gemini API Error:', error);
                        return "Analysis failed after multiple retries";
                    }
                    // Wait before retrying
                    await new Promise(resolve => setTimeout(resolve, RETRY_DELAY));
                }
            }
        }

        // Handle file upload
        async function handleFileUpload() {
            const fileInput = document.getElementById('pdfUpload');
            const files = fileInput.files;
            
            if (files.length === 0) {
                alert('Please select at least one PDF file.');
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file.type !== 'application/pdf') {
                    alert(`${file.name} is not a PDF file. Skipping...`);
                    continue;
                }

                // Create FormData
                const formData = new FormData();
                formData.append('file', file);
                formData.append('projectId', PROJECT_ID);
                formData.append('userId', USER_ID);
                formData.append('userName', USER_NAME);

                try {
                    // Show loading state
                    const loadingDiv = document.createElement('div');
                    loadingDiv.className = 'alert alert-info';
                    loadingDiv.innerHTML = `Uploading ${file.name}... <div class="loading-spinner"></div>`;
                    document.getElementById('fileList').appendChild(loadingDiv);

                    // Upload file
                    const response = await fetch('src/model/upload_literature_file.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();
                    if (result.success) {
                        // Extract text from PDF
                        const text = await extractTextFromPDF(file);
                        pdfContents.set(file.name, text);

                        // Add file to uploadedFiles array
                        uploadedFiles.push({
                            name: file.name,
                            path: result.filePath,
                            uploadedAt: new Date().toISOString(),
                            uploadedBy: {
                                userId: USER_ID,
                                name: USER_NAME
                            },
                            data: {}
                        });

                        loadingDiv.remove();
                        updateFileList();
                        saveToDatabase();
                    } else {
                        loadingDiv.className = 'alert alert-danger';
                        loadingDiv.textContent = `Failed to upload ${file.name}: ${result.message}`;
                    }
                } catch (error) {
                    console.error('Error uploading file:', error);
                    loadingDiv.className = 'alert alert-danger';
                    loadingDiv.textContent = `Error uploading ${file.name}`;
                }
            }

            fileInput.value = '';
        }

        // Update generateMatrix function
        async function generateMatrix() {
            const generateBtn = document.getElementById('generateBtn');
            generateBtn.disabled = true;
            generateBtn.textContent = 'Generating...';

            // Find files that need generation (missing at least one selected tag)
            const filesToProcess = uploadedFiles.filter(file => {
                return Array.from(selectedTags).some(tag => !file.data || !file.data[tag]);
            });

            // Mark files as generating
            filesToProcess.forEach(file => file.isGenerating = true);
            updateFileList();

            try {
                let totalTags = selectedTags.size;
                for (const file of filesToProcess) {
                    const text = pdfContents.get(file.name);
                    if (!text) continue;

                    for (const tag of selectedTags) {
                        if (file.data && file.data[tag]) {
                            continue; // Skip already generated tags
                        }
                        const analysis = await analyzeWithGemini(text, tag);
                        if (!file.data) file.data = {};
                        file.data[tag] = analysis;
                        file.lastEditedBy = {
                            userId: USER_ID,
                            name: USER_NAME,
                            timestamp: new Date().toISOString()
                        };
                    }
                    // Mark file as done
                    file.isGenerating = false;
                    updateFileList();
                }
                updateTable();
                saveToDatabase();
            } catch (error) {
                console.error('Error generating matrix:', error);
                alert('Error generating matrix. Please try again.');
            } finally {
                generateBtn.disabled = false;
                generateBtn.textContent = 'Generate Matrix';
                // Remove all generating flags
                uploadedFiles.forEach(file => file.isGenerating = false);
                updateFileList();
            }
        }

        // Function to delete a file
        async function deleteFile(fileName) {
            if (!confirm(`Are you sure you want to delete ${fileName}?`)) {
                return;
            }

            try {
                const response = await fetch('src/model/delete_literature_file.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        projectId: PROJECT_ID,
                        fileName: fileName
                    })
                });

                const result = await response.json();
                if (result.success) {
                    uploadedFiles = uploadedFiles.filter(file => file.name !== fileName);
                    pdfContents.delete(fileName);
                    updateFileList();
                    updateTable();
                    saveToDatabase();
                } else {
                    alert(`Failed to delete ${fileName}: ${result.message}`);
                }
            } catch (error) {
                console.error('Error deleting file:', error);
                alert(`Error deleting ${fileName}`);
            }
        }

        // Update file list
        function updateFileList() {
            const fileList = document.getElementById('fileList');
            const generateButtonContainer = document.getElementById('generateButtonContainer');
            fileList.innerHTML = '';

            if (uploadedFiles.length > 0) {
                uploadedFiles.forEach(file => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item';
                    if (file.isGenerating) fileItem.classList.add('generating');
                    
                    // Spinner for generating files
                    if (file.isGenerating) {
                        const spinner = document.createElement('div');
                        spinner.className = 'spinner-inline';
                        fileItem.appendChild(spinner);
                    }

                    const fileName = document.createElement('span');
                    fileName.textContent = file.name;
                    
                    const fileActions = document.createElement('div');
                    fileActions.className = 'file-actions';
                    
                    const retryButton = document.createElement('button');
                    retryButton.className = 'retry-button';
                    retryButton.textContent = 'Retry Analysis';
                    retryButton.setAttribute('data-filename', file.name);
                    retryButton.onclick = () => retryAnalysis(file.name);
                    
                    const deleteButton = document.createElement('i');
                    deleteButton.className = 'bi bi-x-circle delete-file';
                    deleteButton.onclick = () => deleteFile(file.name);
                    
                    fileActions.appendChild(retryButton);
                    fileActions.appendChild(deleteButton);
                    fileItem.appendChild(fileName);
                    fileItem.appendChild(fileActions);
                    fileList.appendChild(fileItem);
                });

                // Show generate button container if there are files
                generateButtonContainer.style.display = 'block';
            } else {
                // Hide generate button container if no files
                generateButtonContainer.style.display = 'none';
            }
        }

        // Update table
        function updateTable() {
            const header = document.getElementById('tableHeader');
            const body = document.getElementById('tableBody');

            // Update header
            header.innerHTML = '<th>File Name</th>';
            selectedTags.forEach(tag => {
                const th = document.createElement('th');
                th.textContent = tag;
                header.appendChild(th);
            });

            // Update body
            body.innerHTML = '';
            uploadedFiles.forEach(file => {
                const row = document.createElement('tr');
                row.innerHTML = `<td>${file.name}</td>`;
                
                selectedTags.forEach(tag => {
                    const td = document.createElement('td');
                    td.contentEditable = true;
                    td.textContent = file.data[tag] || '';
                    td.setAttribute('data-filename', file.name);
                    td.setAttribute('data-tag', tag);
                    
                    // Add last edit info if available
                    if (file.lastEditedBy) {
                        const lastEditInfo = document.createElement('div');
                        lastEditInfo.className = 'last-edit-info';
                        lastEditInfo.textContent = `Last edited by ${file.lastEditedBy.name} on ${new Date(file.lastEditedBy.timestamp).toLocaleString()}`;
                        td.appendChild(lastEditInfo);
                    }
                    
                    td.onblur = (e) => {
                        const fileObj = uploadedFiles.find(f => f.name === file.name);
                        if (fileObj) {
                            fileObj.data[tag] = e.target.textContent;
                            fileObj.lastEditedBy = {
                                userId: USER_ID,
                                name: USER_NAME,
                                timestamp: new Date().toISOString()
                            };
                            saveToDatabase();
                        }
                    };
                    row.appendChild(td);
                });

                body.appendChild(row);
            });
        }

        // Save to database
        async function saveToDatabase() {
            try {
                // Convert selectedTags Set to array of objects
                const selectedTagsArray = Array.from(selectedTags).map(tagName => {
                    const existingTag = availableTags.find(t => t.name === tagName);
                    return {
                        name: tagName,
                        color: existingTag ? existingTag.color : 'var(--tag-blue)'
                    };
                });

                // Clean up files data before sending
                const cleanFiles = uploadedFiles.map(file => {
                    // Create a clean copy without any functions or complex objects
                    return {
                        name: String(file.name),
                        path: String(file.path || ''),
                        uploadedAt: String(file.uploadedAt || new Date().toISOString()),
                        uploadedBy: {
                            userId: String(file.uploadedBy?.userId || USER_ID),
                            name: String(file.uploadedBy?.name || USER_NAME)
                        },
                        data: Object.fromEntries(
                            Object.entries(file.data || {}).map(([key, value]) => [key, String(value || '')])
                        ),
                        lastEditedBy: file.lastEditedBy ? {
                            userId: String(file.lastEditedBy.userId),
                            name: String(file.lastEditedBy.name),
                            timestamp: String(file.lastEditedBy.timestamp)
                        } : null
                    };
                });

                const response = await fetch('src/model/save_literature_matrix.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        projectId: String(PROJECT_ID),
                        selectedTags: selectedTagsArray,
                        files: cleanFiles
                    })
                });

                const result = await response.json();
                if (!result.success) {
                    throw new Error(result.message || 'Failed to save changes');
                }
            } catch (error) {
                console.error('Failed to save to database:', error);
                alert('Failed to save changes. Please try again.');
            }
        }

        // Export table to Excel
        function exportTable() {
            const table = document.getElementById('literatureTable');
            const wb = XLSX.utils.table_to_book(table, { sheet: "Literature Matrix" });
            XLSX.writeFile(wb, `literature_matrix_${PROJECT_ID}.xlsx`);
        }

        // Initialize with some default selected tags
        window.onload = function() {
            // Select some default tags
            ['Publication Year', 'Research Aim / Objective', 'Methodology', 'Findings'].forEach(tagName => {
                selectedTags.add(tagName);
            });
            init();
        };
    </script>
</body>
</html>
