# Mock_Project_WAD_Taskly_Nhom8
Bài tập lớn - Học phần: Phát triển web + BTL - GV: Hoàng Anh Đức - Dự án: Xây dựng hệ thống quản lý kế hoạch cá nhân (Taskly)_Ứng dụng CRUD_Team 4 người

---

## 🛠 Hướng dẫn Cài đặt & Chạy CSDL

1. Mở Laragon, khởi động **Apache** và **MySQL**.
2. Mở phpMyAdmin (hoặc HeidiSQL trong Laragon).
3. Import file `database/schema.sql` để tạo database `taskly_db` và bảng `tasks`.
4. Dự án chạy tại địa chỉ: `http://localhost/taskly/`

---

## 📡 Tài liệu API Backend (Dành cho Frontend JS gọi fetch)

Mọi API đều nhận và trả về dữ liệu định dạng **JSON**.

### 1. Lấy danh sách công việc (`GET`)
- **URL:** `api/read.php`
- **Bộ lọc:**
  - Lấy tất cả: `GET api/read.php`
  - Lấy theo ID: `GET api/read.php?id=1`
  - Lọc trạng thái: `GET api/read.php?status=0` (đang làm) hoặc `?status=1` (đã xong)
- **Response:**
  ```json
  {
    "success": true,
    "count": 3,
    "data": [
      {
        "id": 1,
        "title": "Hoàn thành slide thuyết trình BTL",
        "description": "Chuẩn bị nội dung...",
        "priority": "high",
        "due_date": "2026-11-17",
        "status": 0,
        "created_at": "2026-11-14 08:00:00"
      }
    ]
  }
  ```

---

### 2. Thêm mới công việc (`POST`)
- **URL:** `api/create.php`
- **Body (JSON):**
  ```json
  {
    "title": "Học bài PHP",
    "description": "Chi tiết công việc (tùy chọn)",
    "priority": "medium",
    "due_date": "2026-11-20"
  }
  ```
- **Response (201 Created):**
  ```json
  {
    "success": true,
    "message": "Thêm công việc thành công",
    "id": 4
  }
  ```

---

### 3. Cập nhật công việc (`POST` hoặc `PUT`)
- **URL:** `api/update.php`
- **Body (JSON) - Ví dụ đổi trạng thái hoàn thành:**
  ```json
  {
    "id": 1,
    "status": 1
  }
  ```
- **Body (JSON) - Sửa tiêu đề/chi tiết:**
  ```json
  {
    "id": 1,
    "title": "Tiêu đề mới",
    "priority": "high"
  }
  ```
- **Response:**
  ```json
  {
    "success": true,
    "message": "Cập nhật công việc thành công"
  }
  ```

---

### 4. Xóa công việc (`DELETE` hoặc `POST`)
- **URL:** `api/delete.php`
- **Cách 1 (Query param):** `DELETE api/delete.php?id=1`
- **Cách 2 (JSON body):** `POST api/delete.php` kèm `{"id": 1}`
- **Response:**
  ```json
  {
    "success": true,
    "message": "Xóa công việc thành công"
  }
  ```
