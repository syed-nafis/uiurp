<?php
require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * Connect to MongoDB database
 *
 * @return MongoDB\Client
 */
function connectToDatabase() {
    // MongoDB connection URI
    $uri = "mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/";
    
    // Create a new client and connect to the server
    $client = new MongoDB\Client($uri);
    
    return $client;
}
?> 