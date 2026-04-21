DELIMITER //

CREATE TRIGGER update_stock_after_complete
AFTER UPDATE ON don_hang
FOR EACH ROW
BEGIN
    -- Kiểm tra nếu trạng thái chuyển từ bất kỳ trạng thái nào sang 'Hoàn thành'
    IF NEW.trang_thai = 'Hoàn thành' AND OLD.trang_thai <> 'Hoàn thành' THEN
        
        -- Cập nhật bảng mon_an dựa trên các món có trong chi_tiet_don_hang
        UPDATE mon_an m
        JOIN chi_tiet_don_hang ctdh ON m.id_mon_an = ctdh.id_mon_an
        SET m.so_luong_ton = m.so_luong_ton - ctdh.so_luong,
            m.so_luong_da_ban = m.so_luong_da_ban + ctdh.so_luong
        WHERE ctdh.id_don_hang = NEW.id_don_hang;
        
    END IF;
END //

DELIMITER ;