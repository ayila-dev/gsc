<?php
// Set header for JSON response
header('Content-Type: application/json; charset=utf-8');

require_once '../Controllers/UsersController.php';

try {
    $usersController = new UsersController();
    $teachers = $usersController->selectAllTeachers();
    echo json_encode(value: $teachers);
} catch (Throwable $e) {
    http_response_code(response_code: 500);
    echo json_encode(value: ['error' => $e->getMessage()]);
}
