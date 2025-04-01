<?php
include '../includes/db_connect.php';
$tutor_id = $_GET['tutor_id'];

$stmt = $conn->prepare("SELECT AVG(rating) as avg_rating FROM tutor_ratings WHERE tutor_id = ?");
$stmt->bind_param("i", $tutor_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$avg_rating = round($row['avg_rating'], 1);

$stmt = $conn->prepare("SELECT rating, feedback FROM tutor_ratings WHERE tutor_id = ?");
$stmt->bind_param("i", $tutor_id);
$stmt->execute();
$reviews = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tutor Profile - Patabang</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Tutor Profile</h2>
    <p>Average Rating: ⭐ <?= $avg_rating ?>/5</p>

    <h3>Student Reviews:</h3>
    <?php while ($review = $reviews->fetch_assoc()): ?>
        <p>⭐ <?= $review['rating'] ?>/5</p>
        <p><?= $review['feedback'] ?></p>
        <hr>
    <?php endwhile; ?>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
