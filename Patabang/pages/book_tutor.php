<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['tutor_id'])) {
    $tutor_id = $_GET['tutor_id'];
    $student_id = $_SESSION['user_id'];

    // Check if a request already exists
    $check_sql = "SELECT * FROM matches WHERE student_id = ? AND tutor_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $student_id, $tutor_id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<p>You have already sent a request to this tutor.</p>";
    } else {
        // Insert booking request
        $sql = "INSERT INTO matches (student_id, tutor_id, status) VALUES (?, ?, 'pending')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $student_id, $tutor_id);

        if ($stmt->execute()) {
            echo "<p>Request sent successfully!</p>";
        } else {
            echo "<p>Error sending request.</p>";
        }

        $stmt->close();
    }

    $check_stmt->close();
}
?>

<a href="pages/find_tutors.php">Back to Tutors</a>
