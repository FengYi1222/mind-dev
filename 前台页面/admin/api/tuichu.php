<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'logout') {
  // 删除了登录标识
  unset($_SESSION['current_login_user']);
}
  header('Location: /前台页面/admin/a-admin.php');

?>
