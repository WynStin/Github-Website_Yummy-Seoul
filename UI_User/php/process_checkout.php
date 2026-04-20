<?php
require_once '../../SQL_Connect/db.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if ($input) {
    try {
        $pdo->beginTransaction();

        // 1. Lưu vào bảng don_hang
        $stmt = $pdo->prepare("INSERT INTO don_hang (id_khach_hang, tong_gia, tien_ship, dia_chi_giao_hang, pt_thanh_toan, trang_thai) VALUES (?, ?, ?, ?, ?, 'Đã đặt')");
        $stmt->execute([
            $_SESSION['id_nguoi_dung'],
            $input['total'],
            20000,
            $input['address'],
            $input['paymentMethod']
        ]);
        
        $orderId = $pdo->lastInsertId();

        // 2. Lưu chi tiết vào bảng chi_tiet_don_hang
        $stmtDetail = $pdo->prepare("INSERT INTO chi_tiet_don_hang (id_don_hang, id_mon_an, so_luong, don_gia) VALUES (?, ?, ?, ?)");
        foreach ($input['items'] as $item) {
            $stmtDetail->execute([$orderId, $item['id'], $item['quantity'], $item['price']]);
        }

        $pdo->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>