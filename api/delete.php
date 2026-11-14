<?php
// api/delete.php - Xóa công việc theo ID
require_once __DIR__ . '/config.php';

if (!in_array($_SERVER['REQUEST_METHOD'], ['DELETE', 'POST'], true)) {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Phương thức không được hỗ trợ']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);

$id = 0;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
} elseif (isset($input['id']) && is_numeric($input['id'])) {
    $id = (int)$input['id'];
}

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID công việc không hợp lệ']);
    exit();
}

try {
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Xóa công việc thành công'
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Không tìm thấy công việc để xóa'
        ]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Lỗi khi xóa: ' . $e->getMessage()]);
}
