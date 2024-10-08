<?php
require_once __DIR__ . '/../../models/User.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        
        $userModel = new User();
        if ($userModel->delete($id)) {
            echo json_encode(['success' => 'User deleted successfully']);
            http_response_code(200);
        } else {
            echo json_encode(['error' => 'User deletion failed']);
            http_response_code(500);
        }
    } else {
        echo json_encode(['error' => 'Invalid request method or missing user ID']);
        http_response_code(400);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    http_response_code(500);
}
?>
