<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $err = "Invalid credentials.";
} else {
    $pdo = getPDO();
    $stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($password, $row['password_hash'])) {
        // safe session start
        session_regenerate_id(true);
        $_SESSION['user_id'] = $row['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        $err = "Invalid credentials.";
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Login failed</title></head>
<body>
<h1>Login failed</h1>
<p style="color:red;"><?=htmlspecialchars($err ?? 'Error')?></p>
<p><a href="index.html">Back to login</a></p>
</body>
</html>
