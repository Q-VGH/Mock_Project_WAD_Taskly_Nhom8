-- Database: taskly_db
CREATE DATABASE IF NOT EXISTS taskly_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE taskly_db;

-- Tasks table
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    due_date DATE NULL,
    status TINYINT(1) DEFAULT 0 COMMENT '0: Dang lam, 1: Hoan thanh',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample data
INSERT INTO tasks (title, description, priority, due_date, status) VALUES
('Hoàn thành slide thuyết trình BTL', 'Chuẩn bị nội dung cho bài báo cáo nhóm', 'high', CURDATE() + INTERVAL 3 DAY, 0),
('Viết tài liệu API cho Frontend', 'Tài liệu hướng dẫn gọi các endpoint CRUD', 'medium', CURDATE() + INTERVAL 2 DAY, 0),
('Review lại cấu trúc Database', 'Kiểm tra kiểu dữ liệu và ràng buộc các bảng', 'low', CURDATE(), 1);
