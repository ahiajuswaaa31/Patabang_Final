<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tutor_id = $_POST['tutor_id'];
    $student_id = $_SESSION['user_id'];
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];

    $stmt = $conn->prepare("INSERT INTO tutor_ratings (tutor_id, student_id, rating, feedback) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $tutor_id, $student_id, $rating, $feedback);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Rate Tutor - Patabang</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Rate Your Tutor</h2>
    <form method="POST">
        <input type="hidden" name="tutor_id" value="<?= $_GET['tutor_id'] ?>">
        <label for="rating">Rate (1-5 stars):</label>
        <select name="rating" required>
            <option value="5">⭐⭐⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="2">⭐⭐</option>
            <option value="1">⭐</option>
        </select>
        <label for="feedback">Feedback:</label>
        <textarea name="feedback" required></textarea>
        <button type="submit">Submit</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
