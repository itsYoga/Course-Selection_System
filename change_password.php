<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'school_db');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = md5($_POST['current_password']); // 當前密碼（建議改用 password_hash 和 password_verify）
    $new_password = md5($_POST['new_password']); // 新密碼
    $user_id = $_SESSION['user_id'];

    // 檢查當前密碼是否正確
    $query = "SELECT * FROM users WHERE user_id='$user_id' AND password='$current_password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // 更新密碼
        $update = "UPDATE users SET password='$new_password' WHERE user_id='$user_id'";
        if ($conn->query($update)) {
            echo "<script>alert('Password changed successfully!'); window.location='main.php';</script>";
        } else {
            echo "<script>alert('Failed to update password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Current password is incorrect.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .password-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .password-container h1 {
            color: #333;
            margin-bottom: 15px;
        }
        .password-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .password-container input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s;
        }
        .password-container input:focus {
            border-color: #007BFF;
        }
        .password-container button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .password-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="password-container">
        <h1>Change Password</h1>
        <form method="POST" action="">
            <input type="password" name="current_password" placeholder="Current Password" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <button type="submit">Update Password</button>
        </form>
    </div>
</body>
</html>