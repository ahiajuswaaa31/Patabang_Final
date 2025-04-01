<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

$sql = $role === 'tutor' ? 
    "SELECT m.id, u.full_name AS student_name, m.status FROM matches m 
     JOIN users u ON m.student_id = u.id WHERE m.tutor_id = ?" :
    "SELECT m.id, u.full_name AS tutor_name, m.status FROM matches m 
     JOIN users u ON m.tutor_id = u.id WHERE m.student_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard - Patabang</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Dashboard</h2>
    <table>
        <tr>
            <th><?php echo ($role === 'tutor') ? 'Student' : 'Tutor'; ?></th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo ($role === 'tutor') ? $row['student_name'] : $row['tutor_name']; ?></td>
                <td><?php echo ucfirst($row['status']); ?></td>
                <td>
                    <?php if ($role === 'tutor' && $row['status'] == 'pending'): ?>
                        <a href="update_booking.php?id=<?php echo $row['id']; ?>&status=approved">Approve</a> |
                        <a href="update_booking.php?id=<?php echo $row['id']; ?>&status=rejected">Reject</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
