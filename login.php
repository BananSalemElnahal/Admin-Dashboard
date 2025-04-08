<?php
session_start();
// تضمين الاتصال بقاعدة البيانات
include('db_connect.php');  
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// تحقق إذا كان النموذج قد تم إرساله
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $_SESSION['error_message'] = "Please enter both email and password.";
        header("Location: login.php");
        exit();
    }

    // الحصول على بيانات النموذج
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        // استعلام البحث عن المستخدم عبر البريد الإلكتروني
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // ** تسجيل الدخول بنجاح **
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];  // 🔹 حفظ معرف المستخدم في الجلسة
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];  // 🔹 حفظ دور المستخدم (أدمن أو يوزر)

                session_write_close();  // 🔹 حفظ بيانات الجلسة ومنع فقدانها

                // التوجيه بناءً على دور المستخدم
                if ($_SESSION['user_role'] == 'admin') {
                    header("Location: Admin Dashboard.php");  // 🔹 صفحة الأدمن
                } else {
                    header("Location: Home.php");  // 🔹 صفحة المستخدم العادي
                }
                exit();
            }
        }

        // ** في حالة تسجيل الدخول غير الصحيح **
        $_SESSION['error_message'] = "Invalid email or password.";
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $_SESSION['error_message'] = "Database error. Please try again later.";
        header("Location: login.php");
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #8e24aa, #9B8BE3);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            transition: border 0.3s ease;
        }

        .form-input:focus {
            border: 1px solid #5A4E8D;
        }

        .form-button {
            background-color: #8e24aa;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-button:hover {
            background-color: #5a3d72;
        }

        .forgot-password {
            font-size: 14px;
            color: #666;
            margin-top: 10px;
        }

        .forgot-password a {
            color: #5A4E8D;
            text-decoration: none;
            font-weight: bold;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .register-link {
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        .register-link a {
            color: #5A4E8D;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* Animations for better UX */
        .form-input, .form-button {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s forwards;
        }

        .form-input:nth-child(1) {
            animation-delay: 0.2s;
        }

        .form-input:nth-child(2) {
            animation-delay: 0.4s;
        }

        .form-button {
            animation-delay: 0.6s;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <form method="POST" action="login.php">
        <input type="email" name="email" class="form-input" placeholder="Email Address" required>
        <input type="password" name="password" class="form-input" placeholder="Password" required>
        <button type="submit" class="form-button">Login</button>
    </form>
    <div class="forgot-password">
        <a href="#">Forgot Password?</a>
    </div>
    <div class="register-link">
        <p>Don't have an account? <a href="register.php">Sign up</a></p>
    </div>
</div>

</body>
</html>
