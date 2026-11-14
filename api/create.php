<?php
// api/create.php - Tạo mới công việc
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Phương thức không được hỗ trợ']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);

$title = trim($input['title'] ?? '');
$description = trim($input['description'] ?? '');
$priority = in_array($input['priority'] ?? '', ['low', 'medium', 'high'], true) ? $input['priority'] : 'medium';
$due_date = !empty($input['due_date']) ? $input['due_date'] : null;

if (empty($title)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Tiêu đề không được để trống']);
    exit();
}

try {
    $stmt = $pdo->prepare("INSERT INTO tasks (title, description, priority, due_date, status) VALUES (?, ?, ?, ?, 0)");
    $stmt->execute([$title, $description ?: null, $priority, $due_date]);

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Thêm công việc thành công',
        'id' => (int)$pdo->lastInsertId()
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Lỗi khi thêm: ' . $e->getMessage()]);
}
