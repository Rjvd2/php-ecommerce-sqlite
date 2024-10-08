<?php
require_once __DIR__ . '/../../models/Payment.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['order_id'], $data['amount'], $data['payment_method'], $data['payment_status'])) {
            echo json_encode(['error' => 'Missing required fields']);
            http_response_code(400);
            exit();
        }

        $order_id = $data['order_id'];
        $amount = $data['amount'];
        $payment_method = $data['payment_method'];
        $payment_status = $data['payment_status'];

        $paymentModel = new Payment();
        if ($paymentModel->create($order_id, $amount, $payment_method, $payment_status)) {
            echo json_encode(['success' => 'Payment created successfully']);
            http_response_code(201);
        } else {
            echo json_encode(['error' => 'Failed to create payment']);
            http_response_code(500);
        }
    } else {
        echo json_encode(['error' => 'Invalid request method']);
        http_response_code(405);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    http_response_code(500);
}
?>
