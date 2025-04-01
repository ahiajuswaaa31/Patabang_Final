<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user's MBTI type
$sql = "SELECT mbti_type FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($user_mbti);
$stmt->fetch();
$stmt->close();

// MBTI Compatibility Chart (Basic Example)
$compatibility = [
    "ENTJ" => ["INTP", "ENTP", "ENFP"],
    "ENTP" => ["INTJ", "ENTJ", "ENFP"],
    "ENFJ" => ["INFJ", "INFP", "ENTP"],
    "ENFP" => ["ENTP", "INTP", "INFJ"],
    "INTJ" => ["ENTP", "INTP", "INFJ"],
    "INTP" => ["ENTJ", "INTJ", "ENFP"],
    "INFJ" => ["ENFJ", "INFP", "INTP"],
    "INFP" => ["ENFJ", "INFJ", "ENFP"],
    "ESTJ" => ["ISTJ", "ESFJ", "ENTJ"],
    "ESFJ" => ["ISFJ", "ESTJ", "ENFJ"],
    "ESTP" => ["ISTP", "ENTP", "ESFP"],
    "ESFP" => ["ISFP", "ESTP", "ENFP"],
    "ISTJ" => ["ESTJ", "ISFJ", "INTJ"],
    "ISFJ" => ["ESFJ", "ISTJ", "INFP"],
    "ISTP" => ["ESTP", "ISFP", "INTP"],
    "ISFP" => ["ESFP", "ISTP", "INFP"]
];

$compatible_types = isset($compatibility[$user_mbti]) ? $compatibility[$user_mbti] : [];

// Fetch compatible tutors
$sql = "SELECT u.full_name, t.subjects, t.rate, t.availability, u.mbti_type 
        FROM users u 
        JOIN tutors t ON u.id = t.user_id 
        WHERE u.mbti_type IN ('" . implode("','", $compatible_types) . "')";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Find Tutors - Patabang</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Find a Tutor</h2>
    <p>Showing tutors compatible with your MBTI type: <strong><?php echo $user_mbti; ?></strong></p>

    <table border="1">
        <tr>
            <th>Name</th>
            <th>Subjects</th>
            <th>Rate</th>
            <th>Availability</th>
            <th>MBTI Type</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['full_name']; ?></td>
                <td><?php echo $row['subjects']; ?></td>
                <td>₱<?php echo $row['rate']; ?>/hr</td>
                <td><?php echo $row['availability']; ?></td>
                <td><?php echo $row['mbti_type']; ?></td>
                <td><a href="book_tutor.php?tutor_id=<?php echo $row['full_name']; ?>">Book</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
