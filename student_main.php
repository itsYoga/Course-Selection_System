<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Main Page</title>
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
        #loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        #loading img {
            width: 400px; /* 增大寬度 */
            height: 400px; /* 增大高度 */
        }
    </style>
    <script>
        function showLoading(event) {
            event.preventDefault(); // Prevent default link behavior
            const loadingDiv = document.getElementById('loading');
            loadingDiv.style.display = 'flex';
            setTimeout(() => {
                window.location.href = event.target.href; // Navigate after showing loading
            }, 500); // Adjust delay if needed
        }
    </script>
</head>
<body>
    <div id="loading">
        <img src="loading.gif" alt="Loading">
    </div>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Manage your courses and schedule.</p>
        <a href="frontend/php/course_add_drop.php" onclick="showLoading(event)">Enroll/Drop Courses</a>
        <a href="schedule.php" onclick="showLoading(event)">View Schedule</a>
        <a href="change_password.php" onclick="showLoading(event)">Change Password</a>
        <a href="logout.php" onclick="showLoading(event)">Logout</a>
    </div>
</body>
</html>