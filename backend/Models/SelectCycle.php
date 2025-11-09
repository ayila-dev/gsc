<?php
// Set header for JSON response
header('Content-Type: application/json; charset=utf-8');

require_once '../Controllers/SettingsController.php';

try {
    $settingsController = new SettingsController();
    $cycles = $settingsController->selectAllCycles();
    echo json_encode(value: $cycles);
} catch (Throwable $e) {
    http_response_code(response_code: 500);
    echo json_encode(value: ['error' => $e->getMessage()]);
}

?>