<?php
session_start();
include 'includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patabang - Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="background-color: white; color: black;">

    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h1 style="color: red;">Welcome to Patabang</h1>
        <p>Your personalized tutor matching system based on MBTI.</p>

        <div class="home-links">
            <a href="pages/mbti_test.php" class="btn">Take MBTI Test</a>
            <a href="pages/tutors.php" class="btn">Find Tutors</a>
            <a href="pages/bookings.php" class="btn">View Bookings</a>
            <a href="pages/rate_tutor.php" class="btn">Rate a Tutor</a>
        </div>
        <footer class="footer">
            <p>&copy; 2023 Patabang. All rights reserved.</p>
        </footer>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
