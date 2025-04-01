<?php
include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $mbti_type = $_POST['mbti_type'];

    $sql = "INSERT INTO users (full_name, email, password, role, mbti_type) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $full_name, $email, $password, $role, $mbti_type);

    if ($stmt->execute()) {
        echo "Registration successful!";
    header("Location: auth/login.php");

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
