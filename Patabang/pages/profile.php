<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch tutor profile
$sql = "SELECT * FROM tutors WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tutor = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bio = $_POST['bio'];
    $subjects = $_POST['subjects'];
    $rate = $_POST['rate'];
    $availability = $_POST['availability'];

    if ($tutor) {
        $sql = "UPDATE tutors SET bio=?, subjects=?, rate=?, availability=? WHERE user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsi", $bio, $subjects, $rate, $availability, $user_id);
    } else {
        $sql = "INSERT INTO tutors (user_id, bio, subjects, rate, availability) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issds", $user_id, $bio, $subjects, $rate, $availability);
    }

    if ($stmt->execute()) {
        echo "<p>Profile updated successfully!</p>";
    } else {
        echo "<p>Error updating profile.</p>";
    }
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile - Patabang</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Update Your Tutor Profile</h2>
    <form method="POST">
        <label>Bio:</label><br>
        <textarea name="bio" required><?php echo $tutor['bio'] ?? ''; ?></textarea><br>

        <label>Subjects (comma-separated):</label><br>
        <input type="text" name="subjects" value="<?php echo $tutor['subjects'] ?? ''; ?>" required><br>

        <label>Rate per hour (PHP):</label><br>
        <input type="number" name="rate" value="<?php echo $tutor['rate'] ?? ''; ?>" step="0.01" required><br>

        <label>Availability:</label><br>
        <input type="text" name="availability" value="<?php echo $tutor['availability'] ?? ''; ?>" required><br>

        <button type="submit">Save Profile</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
