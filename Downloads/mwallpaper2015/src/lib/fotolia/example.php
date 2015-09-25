#!/usr/bin/env php
<?php

require_once 'fotolia-api.php';

$api = new Fotolia_Api('5XEVph1BVGHkZz3VChlwtIHFsUW9gUMc');

// searching for files
$results = $api->getSearchResults(
    array(
        'words' => 'car',
        'language_id' => Fotolia_Api::LANGUAGE_ID_EN_US,
        'limit' => 1,
    ));

printf("Found %d results", $results['nb_results']);

foreach ($results as $key => $value) {
    // iterating only over numeric keys and silently skip other keys
    if (is_numeric($key)) {
        printf("matching media ID: %d", $value['id']);
    }
}

// download comp file
//$comp_dl_data = $api->getMediaComp(35957426);
//$api->downloadMediaComp($comp_dl_data['url'], '/tmp/comp.jpg');

// loggin in and retrieving user data
$api->loginUser('shankar23', 'shankar123');
print_r($api->getUserData());

var_dump($api->getCategories1());
// purchasing and downloading a file
//$dl_data = $api->getMedia(35957426, 'XS');
//$api->downloadMedia($dl_data['url'], '/tmp/' . $dl_data['name']);
