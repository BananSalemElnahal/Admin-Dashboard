<?php
// تضمين الاتصال بقاعدة البيانات
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* نفس التنسيق الذي استخدمناه في الصفحة الرئيسية */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f0f4f8;
            color: #2d3a56;
            transition: background-color 0.3s ease;
        }
        .sidebar {
            width: 260px;
            background-color: #6a4c93;
            color: #fff;
            padding: 30px 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .sidebar:hover {
            width: 280px;
            background-color: #5a3d72;
        }
        .sidebar h1 {
            font-size: 28px;
            margin-bottom: 30px;
            color: #f0e6f1;
            text-align: left;
            letter-spacing: 1px;
        }
        .sidebar ul {
            list-style: none;
        }
        .sidebar ul li {
            margin: 18px 0;
        }
        .sidebar ul li a {
            color: #e1bee7;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 18px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .sidebar ul li a:hover {
            color: #f0e6f1;
            transform: translateX(5px);
        }
        .sidebar ul li a i {
            margin-right: 15px;
            transition: transform 0.3s ease;
        }
        .sidebar ul li a:hover i {
            transform: rotate(360deg);
        }
        .main-content {
            flex: 1;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .header h2 {
            font-size: 32px;
            font-weight: 600;
            color: #2d3a56;
            transition: color 0.3s ease;
        }
        .header h2:hover {
            color: #8e24aa;
        }
        .back-link {
            color: #8e24aa;
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .back-link:hover {
            color: #f0e6f1;
        }
        .table-section {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #8e24aa;
            color: #fff;
            font-weight: 600;
        }
        tr:hover {
            background-color: #f1f1f1;
            transform: scale(1.02);
            transition: transform 0.2s ease;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>Dashboard</h1>
        <ul>
            <li><a href="Home.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="users.php"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="settings.php"><i class="fas fa-cogs"></i> Settings</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="header">
            <h2>Users List</h2>
            <a href="home.php" class="back-link">Back to Dashboard</a>
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
                    // استعلام لجلب بيانات المستخدمين من قاعدة البيانات
                    $stmt = $pdo->query('SELECT * FROM users');
                    while ($row = $stmt->fetch()) {
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
