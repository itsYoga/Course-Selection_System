<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Redirect based on role
if ($_SESSION['role'] === 'student') {
    header("Location: student_main.php");
    exit();
} elseif ($_SESSION['role'] === 'teacher') {
    header("Location: instructor_main.php");
    exit();
} else {
    echo "Invalid role!";
    exit();
}
?>