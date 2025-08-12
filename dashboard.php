<?php
require_once 'config.php';
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

$pdo = getPDO();
$stmt = $pdo->prepare('SELECT email, created_at FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['email'=>'Unknown', 'created_at'=>'-'];
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Dashboard</title></head>
<body>
<h1>Welcome</h1>
<p>Signed in as: <?=htmlspecialchars($user['email'])?></p>
<p>Member since: <?=htmlspecialchars($user['created_at'])?></p>
<form method="post" action="logout.php"><button type="submit">Logout</button></form>
</body>
</html>
