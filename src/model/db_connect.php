<?php
require_once __DIR__ . '/../../vendor/autoload.php';

// MongoDB connection URI
$uri = "mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority";

function connectToDatabase() {
    // MongoDB connection URI
    $uri = "mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority";
    
    // Create a new client and connect to the server
    $client = new MongoDB\Client($uri);
    return $client;
}

try {
    // Create a new client and connect to the server
    $client = new MongoDB\Client($uri);
    $db = $client->uiurp;
} catch (Exception $e) {
    error_log("MongoDB Connection Error: " . $e->getMessage());
    die("Could not connect to the database");
}
?> 
