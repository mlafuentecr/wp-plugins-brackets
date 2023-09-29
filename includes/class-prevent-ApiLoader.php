<?php

/**
 * Register Api 
 *
 * @link       https://revmasters.com
 * @since      1.0.0
 *
 * @package    Prevent_Brackets
 * @subpackage Prevent_Brackets/includes
 */


class ApiLoader {
    private $apiUrl;

    public function __construct($apiUrl) {
        $this->apiUrl = $apiUrl;
    }

    public function loadData() {
        // Initialize a cURL session
        $ch = curl_init($this->apiUrl);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL session and store the response in a variable
        $response = curl_exec($ch);

        // Check for cURL errors
        if(curl_errno($ch)) {
            throw new Exception("Error loading data from API: " . curl_error($ch));
        }

        // Close the cURL session
        curl_close($ch);

        // Parse the JSON response into an associative array
        $data = json_decode($response, true);

        // Check if the JSON decoding was successful
        if ($data === null) {
            throw new Exception("Error decoding JSON data from API");
        }

        return $data;
    }
}

// Example usage:
$apiUrl = 'https://api.example.com/data';
$apiLoader = new ApiLoader($apiUrl);

try {
    $apiData = $apiLoader->loadData();
    // Now you can work with the $apiData array
    print_r($apiData);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
