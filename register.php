<?php
// تضمين الاتصال بقاعدة البيانات
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // تشفير كلمة المرور
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // التحقق من وجود البريد الإلكتروني في قاعدة البيانات
    $email_check_query = "SELECT COUNT(*) FROM users WHERE email = :email";
    $email_check_stmt = $pdo->prepare($email_check_query);
    $email_check_stmt->bindParam(':email', $email);
    $email_check_stmt->execute();
    $email_count = $email_check_stmt->fetchColumn();

    if ($email_count > 0) {
        die("Error: Email is already registered.");
    }


    // استعلام لإدخال المستخدم في قاعدة البيانات
    $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);

    // تنفيذ الاستعلام
    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Error registering user.";
    }
}
?>
