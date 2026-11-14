<?php
// api/read.php - Lấy danh sách công việc
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Phương thức không được hỗ trợ']);
    exit();
}

try {
    // Hỗ trợ lấy theo id cụ thể (?id=1) hoặc toàn bộ
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
        $stmt->execute([(int)$_GET['id']]);
        $task = $stmt->fetch();

        if ($task) {
            echo json_encode(['success' => true, 'data' => $task]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy công việc']);
        }
        exit();
    }

    // Lọc theo status (?status=0 hoặc ?status=1) nếu có
    if (isset($_GET['status']) && in_array($_GET['status'], ['0', '1'], true)) {
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE status = ? ORDER BY id DESC");
        $stmt->execute([(int)$_GET['status']]);
    } else {
        $stmt = $pdo->query("SELECT * FROM tasks ORDER BY id DESC");
    }

    $tasks = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'count' => count($tasks),
        'data' => $tasks
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Lỗi truy vấn: ' . $e->getMessage()]);
}
