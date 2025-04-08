<?php
session_start();
// تحقق إذا كان المستخدم قد سجل الدخول وكان دوره "يوزر"
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_role'] != 'user') {
    header("Location: login.php");  // إذا لم يكن يوزر، إعادة التوجيه إلى صفحة تسجيل الدخول
    exit();
}

// هنا يمكنك إضافة المحتوى المخصص للمستخدم العادي
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
    <!-- إضافة CSS أو روابط تخصيص أخرى هنا -->
</head>
<body>
    <h1>Welcome, User!</h1>
    <p>This is the user page where you can view your dashboard or other user-related content.</p>
</body>
</html>
