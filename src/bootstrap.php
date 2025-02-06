<?php

use Illuminate\Config\Repository;

// Load configuration files
$configPath = dirname(__DIR__) . '/config'; // Adjust based on structure
$configFiles = glob($configPath . '/*.php');

$configData = [];
foreach ($configFiles as $file) {
    $key = basename($file, '.php'); // Use file name as the config key
    $configData[$key] = require $file;
}

// Create config repository
$config = new Repository($configData);

// Global function for easy access
function config($key, $default = null) {
    global $config;
    return $config->get($key, $default);
}
