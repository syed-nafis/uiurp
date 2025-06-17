<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\Exception\ConnectionException;

/**
 * Connect to MongoDB database
 *
 * @return MongoDB\Client
 */
function connectToDatabase() {
    try {
        // Enable error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        // MongoDB connection URI
        $uri = "mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/";
        
        // Create a new client and connect
        $client = new Client($uri);
        
        // Test the connection
        $client->listDatabases();
        
        return $client;
    } catch (ConnectionException $e) {
        error_log("MongoDB Connection Error: " . $e->getMessage());
        throw new Exception("Failed to connect to the database. Please check your internet connection.");
    } catch (Exception $e) {
        error_log("Database Error: " . $e->getMessage());
        throw new Exception("An error occurred while connecting to the database.");
    }
} 