<?php
// api/update.php - Cập nhật công việc (sửa nội dung hoặc đổi trạng thái hoàn thành)
require_once __DIR__ . '/config.php';

if (!in_array($_SERVER['REQUEST_METHOD'], ['PUT', 'POST'], true)) {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Phương thức không được hỗ trợ']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);

$id = isset($input['id']) ? (int)$input['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID công việc không hợp lệ']);
    exit();
}

// Kiểm tra task có tồn tại không
$check = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
$check->execute([$id]);
$task = $check->fetch();

if (!$task) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy công việc']);
    exit();
}

// Cho phép cập nhật từng trường (partial update)
$title = isset($input['title']) ? trim($input['title']) : $task['title'];
$description = array_key_exists('description', $input) ? trim($input['description']) : $task['description'];
$priority = isset($input['priority']) && in_array($input['priority'], ['low', 'medium', 'high'], true) ? $input['priority'] : $task['priority'];
$due_date = array_key_exists('due_date', $input) ? $input['due_date'] : $task['due_date'];
$status = isset($input['status']) ? ((int)$input['status'] ? 1 : 0) : $task['status'];

if (empty($title)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Tiêu đề không được để trống']);
    exit();
}

try {
    $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, priority = ?, due_date = ?, status = ? WHERE id = ?");
    $stmt->execute([$title, $description ?: null, $priority, $due_date ?: null, $status, $id]);

    echo json_encode([
        'success' => true,
        'message' => 'Cập nhật công việc thành công'
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Lỗi khi cập nhật: ' . $e->getMessage()]);
}
