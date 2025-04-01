<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    // Calculate MBTI type based on responses
    $q1 = isset($_POST['q1']) ? $_POST['q1'] : 0;
    $q2 = isset($_POST['q2']) ? $_POST['q2'] : 0;
    $q3 = isset($_POST['q3']) ? $_POST['q3'] : 0;
    $q4 = isset($_POST['q4']) ? $_POST['q4'] : 0;

    // Example logic to determine MBTI type (this should be replaced with actual logic)
    $mbti_type = '';
    if ($q1 + $q2 > 1) {
        $mbti_type .= 'E'; // Extraverted
    } else {
        $mbti_type .= 'I'; // Introverted
    }
    if ($q3 + $q4 > 1) {
        $mbti_type .= 'S'; // Sensing
    } else {
        $mbti_type .= 'N'; // Intuitive
    }


    $stmt = $conn->prepare("INSERT INTO mbti_test_results (user_id, mbti_type) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $mbti_type);
    $stmt->execute();
    header("Location: pages/find_tutors.php");

    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>MBTI Test - Patabang</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Take the MBTI Test</h2>
    <form method="POST">
<h2>Answer the following questions to determine your MBTI type:</h2>
<form method="POST">
    <label>1. I prefer to focus on the outer world rather than my own inner world.</label><br>
    <input type="radio" name="q1" value="1"> Agree
    <input type="radio" name="q1" value="0"> Disagree<br><br>

    <label>2. I enjoy working in groups rather than alone.</label><br>
    <input type="radio" name="q2" value="1"> Agree
    <input type="radio" name="q2" value="0"> Disagree<br><br>

    <label>3. I prefer to plan things in advance rather than being spontaneous.</label><br>
    <input type="radio" name="q3" value="1"> Agree
    <input type="radio" name="q3" value="0"> Disagree<br><br>

    <label>4. I tend to rely on my intuition rather than facts.</label><br>
    <input type="radio" name="q4" value="1"> Agree
    <input type="radio" name="q4" value="0"> Disagree<br><br>

    <button type="submit">Submit</button>

        <button type="submit">Submit</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
