<?php
session_start();

// تحقق من تسجيل الدخول
if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    header("Location: login.php");
    exit();
}

// أعد إنشاء معرف الجلسة لمنع اختطاف الجلسات
session_regenerate_id(true);

// تحقق مما إذا كان المستخدم مسؤولًا
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: unauthorized.php"); // صفحة رفض الوصول
    exit();
}

// تضمين الاتصال بقاعدة البيانات
include 'db_connect.php';
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background-color: #2c3e50; color: #fff; padding: 20px; }
        .sidebar h1 { font-size: 24px; margin-bottom: 20px; }
        .sidebar ul { list-style: none; }
        .sidebar ul li { margin: 15px 0; }
        .sidebar ul li a { color: #fff; text-decoration: none; }
        .main-content { flex: 1; padding: 20px; background-color: #ecf0f1; }
        .header { margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .logout-form { display: inline; }
        .logout-form button { background: none; border: none; color: white; cursor: pointer; font-size: 16px; }
        .cards { display: flex; gap: 20px; }
        .card { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); flex: 1; text-align: center; }
        .table-section { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #3498db; color: #fff; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>Dashboard</h1>
        <ul>
            <li><a href="Home.php">Home</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li>
                <form class="logout-form" action="logout.php" method="POST">
                    <button type="submit">Logout</button>
                </form>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <div class="header">
            <h2>Welcome to Admin Dashboard</h2>
            <p>Logged in as: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        </div>
        <div class="cards">
            <div class="card">
                <h3>Total Users</h3>
                <p>
                    <?php
                    $stmt = $pdo->query('SELECT COUNT(*) FROM users');
                    echo $stmt->fetchColumn();
                    ?>
                </p>
            </div>
            <div class="card">
                <h3>Active Sessions</h3>
                <p>350</p>
            </div>
            <div class="card">
                <h3>Revenue</h3>
                <p>$12,500</p>
            </div>
        </div>
        <div class="table-section">
            <h3>Recent Users</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->prepare('SELECT name, email, status FROM users LIMIT 10');
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
