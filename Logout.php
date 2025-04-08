<?php
// تضمين الاتصال بقاعدة البيانات
include 'db_connect.php';

// التأكد من أن النموذج تم إرساله
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // التحقق من أن كلمة المرور الجديدة تتطابق مع تأكيد كلمة المرور
    if ($new_password !== $confirm_password) {
        echo "كلمة المرور الجديدة لا تتطابق مع التأكيد.";
        exit;
    }

    // تحقق من كلمة المرور الحالية
    // افترض أنك تخزن كلمة المرور بشكل مشفر في قاعدة البيانات
    $stmt = $pdo->prepare('SELECT password FROM users WHERE id = :id');
    $stmt->execute(['id' => 1]); // افترض أن المستخدم هو المسؤول
    $row = $stmt->fetch();

    if ($row && password_verify($current_password, $row['password'])) {
        // تحديث كلمة المرور
        $new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);
        $update_stmt = $pdo->prepare('UPDATE users SET password = :password WHERE id = :id');
        $update_stmt->execute([
            'password' => $new_password_hashed,
            'id' => 1 // افترض أن المستخدم هو المسؤول
        ]);
        echo "تم تحديث كلمة المرور بنجاح.";
    } else {
        echo "كلمة المرور الحالية غير صحيحة.";
    }
}
?>
