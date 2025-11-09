<?php
// Set header for JSON response
header('Content-Type: application/json; charset=utf-8');

require_once '../Controllers/SettingsController.php';

try {
    $settingsController = new SettingsController();
    $places = $settingsController->selectAllPlaces();
    echo json_encode(value: $places);
} catch (Throwable $e) {
    http_response_code(response_code: 500);
    echo json_encode(value: ['error' => $e->getMessage()]);
}

?>