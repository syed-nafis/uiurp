<?php
session_start();

require __DIR__ . '/vendor/autoload.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

// Connect to MongoDB
$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $client->uiurp;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Literature Matrix</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
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
        }

        .tag.selected {
            background: var(--tag-blue);
        }

        .tag:hover {
            opacity: 0.8;
        }

        .literature-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .literature-table th,
        .literature-table td {
            padding: 12px;
            border: 1px solid var(--notion-border);
        }

        .literature-table th {
            background: var(--notion-gray);
            font-weight: 500;
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
        }

        .cell-loading {
            background-color: var(--tag-blue);
            opacity: 0.7;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>
    <div class="container">
        <h1 class="mb-4">Literature Matrix</h1>
        
        <!-- Tag Management Section -->
        <div class="mb-4">
            <h4>Available Tags</h4>
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
            <input type="file" id="pdfUpload" accept=".pdf" class="form-control mb-3">
            <button class="btn btn-notion" onclick="handleFileUpload()">Upload</button>
            <div id="fileList"></div>
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

        // Available tags with different colors
        const availableTags = [
            { name: 'Methodology', color: 'var(--tag-blue)' },
            { name: 'Findings', color: 'var(--tag-green)' },
            { name: 'Research Gap', color: 'var(--tag-purple)' },
            { name: 'Future Work', color: 'var(--tag-orange)' }
        ];

        let selectedTags = new Set();
        let uploadedFiles = [];

        // Store PDF text content for retry functionality
        let pdfContents = new Map(); // Map to store PDF text content by filename

        // Initialize the page
        function init() {
            renderTags();
            updateTable();
        }

        // Render tags in the tag container
        function renderTags() {
            const tagContainer = document.getElementById('tagContainer');
            tagContainer.innerHTML = '';

            availableTags.forEach(tag => {
                const tagElement = document.createElement('span');
                tagElement.className = `tag ${selectedTags.has(tag.name) ? 'selected' : ''}`;
                tagElement.textContent = tag.name;
                tagElement.style.backgroundColor = tag.color;
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
        }

        // Add new tag
        function addNewTag() {
            const input = document.getElementById('newTagInput');
            const tagName = input.value.trim();
            
            if (tagName && !availableTags.some(tag => tag.name === tagName)) {
                const colors = ['var(--tag-blue)', 'var(--tag-green)', 'var(--tag-purple)', 'var(--tag-orange)'];
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                
                availableTags.push({ name: tagName, color: randomColor });
                input.value = '';
                renderTags();
                updateTable();
            }
        }

        // Function to extract text from PDF
        async function extractTextFromPDF(file) {
            return new Promise((resolve, reject) => {
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

        // Function to analyze text with Gemini
        async function analyzeWithGemini(text, tag) {
            const prompt = `Analyze the following research paper text and extract information relevant to the category "${tag}". 
                          Provide a concise summary (max 100 words) of the key points related to this category.
                          Text: ${text}`; // Limiting text length to avoid token limits

            try {
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
                            temperature: 0.4, // Lower temperature for more focused responses
                            topK: 32,
                            topP: 0.8,
                            maxOutputTokens: 512, // Adjusted for flash model
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
                console.log(response);
                const data = await response.json();
                console.log(data);
                if (data.candidates && data.candidates[0].content.parts[0].text) {
                    return data.candidates[0].content.parts[0].text;
                }
                return "Analysis failed";
            } catch (error) {
                console.error('Gemini API Error:', error);
                return "Analysis failed";
            }
        }

        // Modified handleFileUpload function to store PDF content
        async function handleFileUpload() {
            const fileInput = document.getElementById('pdfUpload');
            const file = fileInput.files[0];
            
            if (file && file.type === 'application/pdf') {
                try {
                    // Show loading state
                    const loadingDiv = document.createElement('div');
                    loadingDiv.className = 'alert alert-info';
                    loadingDiv.textContent = `Analyzing ${file.name}...`;
                    document.getElementById('fileList').appendChild(loadingDiv);

                    // Extract text from PDF
                    const text = await extractTextFromPDF(file);
                    
                    // Store PDF content for later use
                    pdfContents.set(file.name, text);
                    
                    // Analyze text for each selected tag
                    const fileData = {
                        name: file.name,
                        data: {}
                    };

                    for (const tag of selectedTags) {
                        loadingDiv.textContent = `Analyzing ${file.name} for ${tag}...`;
                        const analysis = await analyzeWithGemini(text, tag);
                        fileData.data[tag] = analysis;
                    }

                    uploadedFiles.push(fileData);
                    
                    // Remove loading state
                    loadingDiv.remove();
                    
                    // Update UI
                    updateFileList();
                    updateTable();
                    fileInput.value = '';

                } catch (error) {
                    console.error('Error processing file:', error);
                    alert('Error processing file. Please try again.');
                }
            }
        }

        // Function to retry analysis for a specific file
        async function retryAnalysis(fileName) {
            const text = pdfContents.get(fileName);
            if (!text) {
                alert('PDF content not found. Please upload the file again.');
                return;
            }

            // Find the file in uploadedFiles
            const fileIndex = uploadedFiles.findIndex(f => f.name === fileName);
            if (fileIndex === -1) return;

            // Update retry button state
            const retryButton = document.querySelector(`[data-filename="${fileName}"]`);
            if (retryButton) {
                retryButton.classList.add('loading');
                retryButton.disabled = true;
                retryButton.textContent = 'Analyzing...';
            }

            // Add loading state to cells
            const cells = document.querySelectorAll(`td[data-filename="${fileName}"]`);
            cells.forEach(cell => cell.classList.add('cell-loading'));

            try {
                // Re-analyze for each selected tag
                for (const tag of selectedTags) {
                    const analysis = await analyzeWithGemini(text, tag);
                    uploadedFiles[fileIndex].data[tag] = analysis;
                }

                // Update UI
                updateTable();
            } catch (error) {
                console.error('Error retrying analysis:', error);
                alert('Error retrying analysis. Please try again.');
            } finally {
                // Reset retry button state
                if (retryButton) {
                    retryButton.classList.remove('loading');
                    retryButton.disabled = false;
                    retryButton.textContent = 'Retry Analysis';
                }
                // Remove loading state from cells
                cells.forEach(cell => cell.classList.remove('cell-loading'));
            }
        }

        // Modified updateFileList function to include retry button
        function updateFileList() {
            const fileList = document.getElementById('fileList');
            fileList.innerHTML = '';

            uploadedFiles.forEach(file => {
                const fileItem = document.createElement('div');
                fileItem.className = 'file-item';
                
                const fileName = document.createElement('span');
                fileName.textContent = file.name;
                
                const fileActions = document.createElement('div');
                fileActions.className = 'file-actions';
                
                const retryButton = document.createElement('button');
                retryButton.className = 'retry-button';
                retryButton.textContent = 'Retry Analysis';
                retryButton.setAttribute('data-filename', file.name);
                retryButton.onclick = () => retryAnalysis(file.name);
                
                fileActions.appendChild(retryButton);
                fileItem.appendChild(fileName);
                fileItem.appendChild(fileActions);
                fileList.appendChild(fileItem);
            });
        }

        // Modified updateTable function to add data attributes
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
                    td.onblur = (e) => {
                        file.data[tag] = e.target.textContent;
                    };
                    row.appendChild(td);
                });

                body.appendChild(row);
            });
        }

        // Export table to Excel
        function exportTable() {
            const table = document.getElementById('literatureTable');
            const wb = XLSX.utils.table_to_book(table, { sheet: "Literature Matrix" });
            XLSX.writeFile(wb, "literature_matrix.xlsx");
        }

        // Initialize the page when loaded
        window.onload = init;
    </script>
</body>
</html>
