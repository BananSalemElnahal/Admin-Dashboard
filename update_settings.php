<?php
session_start();
include 'db_connect.php'; // تأكد من أنك تتصل بقاعدة البيانات بشكل صحيح

// التحقق من أن المستخدم هو المشرف (صاحب id=4)
if ($_SESSION['user_id'] != 4) {
    die("ليس لديك صلاحية لتغيير كلمة المرور.");
}

// الحصول على ID المستخدم من الجلسة
$user_id = $_SESSION['user_id'];

// معالجة البيانات من النموذج
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = trim($_POST['current_password'] ?? ''); // كلمة المرور الحالية
    $new_password = trim($_POST['new_password'] ?? ''); // كلمة المرور الجديدة
    $confirm_password = trim($_POST['confirm_password'] ?? ''); // تأكيد كلمة المرور الجديدة

    // التحقق من الحقول
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['error_message'] = "جميع الحقول مطلوبة!";
        header("Location: update_settings.php");
        exit();
    }

    if ($new_password !== $confirm_password) {
        $_SESSION['error_message'] = "كلمتا المرور الجديدتان غير متطابقتين!";
        header("Location: update_settings.php");
        exit();
    }

    if (strlen($new_password) < 6) {
        $_SESSION['error_message'] = "يجب أن تحتوي كلمة المرور على 6 أحرف على الأقل!";
        header("Location: update_settings.php");
        exit();
    }

    // استعلام للتحقق من كلمة المرور الحالية في قاعدة البيانات
    $query = "SELECT password FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row || !password_verify($current_password, $row['password'])) {
        $_SESSION['error_message'] = "كلمة المرور الحالية غير صحيحة!";
        header("Location: update_settings.php");
        exit();
    }

    // تشفير كلمة المرور الجديدة
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // استعلام لتحديث كلمة المرور في قاعدة البيانات
    $update_query = "UPDATE users SET password = :new_password WHERE id = :user_id";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->bindParam(':new_password', $hashed_password);
    $update_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // تنفيذ الاستعلام وتحديث كلمة المرور
    if ($update_stmt->execute()) {
        session_regenerate_id(true); // لتأمين الجلسة بعد تغيير كلمة المرور
        $_SESSION['success_message'] = "تم تحديث كلمة المرور بنجاح!";
        header("Location: Admin Dashboard.php"); // العودة إلى صفحة الداشبورد
        exit();
    } else {
        $_SESSION['error_message'] = "حدث خطأ أثناء تحديث كلمة المرور!";
        header("Location: update_settings.php");
        exit();
    }
}

// إذا كان المطلوب هو تعيين كلمة مرور ثابتة للمستخدم صاحب id=4:
if ($_SESSION['user_id'] == 4) {
    // تعيين كلمة مرور جديدة للمستخدم صاحب id=4
    $new_password = '12345678';  // كلمة المرور الجديدة

    // تشفير كلمة المرور الجديدة
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // استعلام لتحديث كلمة المرور في قاعدة البيانات
    $update_query = "UPDATE users SET password = :new_password WHERE id = :user_id";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->bindParam(':new_password', $hashed_password);
    $update_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // تنفيذ الاستعلام وتحديث كلمة المرور
    if ($update_stmt->execute()) {
        echo "تم تحديث كلمة المرور بنجاح!";
    } else {
        echo "حدث خطأ أثناء تحديث كلمة المرور!";
    }
}
?>
