<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Main Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        h1 {
            color: #333333;
            font-size: 24px;
            margin-bottom: 15px;
        }
        p {
            color: #666666;
            margin: 15px 0;
            font-size: 16px;
        }
        a {
            display: block;
            margin: 10px 0;
            padding: 12px 20px;
            font-size: 16px;
            text-decoration: none;
            color: #ffffff;
            background-color: #007BFF;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Manage courses and student enrollments.</p>
        <a href="frontend/php/information_modify.php">Modify Courses</a>
        <a href="change_password.php">Change Password</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>