<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        $error = "Invalid email or password too short (min 6 chars).";
    } else {
        $pdo = getPDO();

        // check exists
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email already registered.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (email, password_hash, created_at) VALUES (?, ?, NOW())');
            $stmt->execute([$email, $hash]);
            header('Location: index.html?registered=1');
            exit;
        }
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Register</title></head>
<body>
<h1>Register</h1>
<?php if (!empty($error)) echo '<p style="color:red;">'.htmlspecialchars($error).'</p>'; ?>
<form method="post" action="register.php">
  <label>Email: <input type="email" name="email" required></label><br>
  <label>Password: <input type="password" name="password" minlength="6" required></label><br>
  <button type="submit">Create account</button>
</form>
<p><a href="index.html">Back to login</a></p>
</body>
</html>
