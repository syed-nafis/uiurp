<?php
header('Content-Type: application/json');
// Suppose $keywords is your data array
$keywords = [
    ['name' => 'ai', 'frequency' => 0],
    // ... other entries
];
echo json_encode($keywords);
?>
