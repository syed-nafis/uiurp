<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$collection = $client->uiurp->faculties;

$faculties = $collection->find([], [
    'projection' => [
        'name' => 1,
        'bio' => 1,
        'job_title' => 1,
        'office_number' => 1,
        'profile_image' => 1,
        'interested_fields_of_research' => 1
    ]
])->toArray();

echo json_encode($faculties);
?>