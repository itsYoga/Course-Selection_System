<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'school_db');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = $conn->real_escape_string($_POST['identifier']); // 輸入的用戶名或電子郵件
    $password = md5($_POST['password']); // 密碼雜湊處理（建議改用 password_hash）

    // 同時檢查 username 和 email
    $query = "SELECT * FROM users WHERE (username='$identifier' OR email='$identifier') AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        header("Location: main.php");
        exit();
    } else {
        echo "<script>alert('Invalid username/email or password');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('background.webp') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 90%;
            text-align: center;
        }

        .login-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s;
        }

        .login-container input[type="text"]:focus,
        .login-container input[type="password"]:focus {
            border-color: #007BFF;
        }

        .login-container button {
            background-color: #007BFF;
            color: #fff;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 20px 30px;
            }

            .login-container h1 {
                font-size: 20px;
            }

            .login-container input[type="text"],
            .login-container input[type="password"] {
                font-size: 14px;
            }

            .login-container button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form method="POST" action="">
            <input type="text" name="identifier" placeholder="Username or Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>