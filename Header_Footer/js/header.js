function openAdminModal() {
    document.getElementById('adminModal').classList.add('open');
}

function closeAdminModal() {
    document.getElementById('adminModal').classList.remove('open');
}

document.getElementById('adminLoginForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const email = document.getElementById('adminEmail').value;
    const pass = document.getElementById('adminPassword').value;
    if (email === 'admin@yummyseoul.com' && pass === '123456') {
        window.location.href = '../../UI_Manager/php/dashboard.php'; // Đường dẫn trang quản lý
    } else {
        alert('Sai tài khoản hoặc mật khẩu quản lý!');
    }
});
window.onclick = function (event) {
    const modal = document.getElementById('adminModal');
    if (event.target == modal) {
        closeAdminModal();
    }
}