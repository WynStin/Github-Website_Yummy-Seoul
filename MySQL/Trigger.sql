DELIMITER //

CREATE TRIGGER update_stock_after_complete
AFTER UPDATE ON don_hang
FOR EACH ROW
BEGIN
    IF NEW.trang_thai = 'Hoàn thành' AND OLD.trang_thai <> 'Hoàn thành' THEN
        -- 1. Cập nhật số lượng và lượt bán
        UPDATE mon_an m
        JOIN chi_tiet_don_hang ctdh ON m.id_mon_an = ctdh.id_mon_an
        SET m.so_luong_ton = m.so_luong_ton - ctdh.so_luong,
            m.so_luong_da_ban = m.so_luong_da_ban + ctdh.so_luong
        WHERE ctdh.id_don_hang = NEW.id_don_hang;

        -- 2. Nếu số lượng sau khi trừ <= 0 thì đổi trạng thái thành 'Hết hàng'
        UPDATE mon_an 
        SET trang_thai = 'Hết hàng', so_luong_ton = 0 
        WHERE so_luong_ton <= 0;
        
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER check_stock_before_insert
BEFORE INSERT ON chi_tiet_don_hang
FOR EACH ROW
BEGIN
    DECLARE stock_available INT;
    
    -- Lấy số lượng tồn hiện tại của món ăn
    SELECT so_luong_ton INTO stock_available 
    FROM mon_an 
    WHERE id_mon_an = NEW.id_mon_an;
    
    -- Kiểm tra ràng buộc
    IF NEW.so_luong <= 0 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Số lượng đặt phải lớn hơn 0!';
    ELSEIF NEW.so_luong > stock_available THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Số lượng vượt quá tồn kho hiện tại!';
    END IF;
END //

DELIMITER ;