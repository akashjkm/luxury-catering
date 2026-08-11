<?php
require_once 'config.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    if ($user === ADMIN_USER && $pass === ADMIN_PASS) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Gourmet Affair</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --gold: #C9A962; --gold-dark: #A88B4A; --black: #0A0A0A; --charcoal: #1C1C1C; --cream: #FAF7F2; }
        body { background: var(--black); font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: var(--charcoal); border: 1px solid rgba(201,169,98,0.2); padding: 50px; width: 100%; max-width: 420px; }
        .login-brand { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; color: #fff; text-align: center; margin-bottom: 8px; }
        .login-brand span { color: var(--gold); font-style: italic; }
        .login-subtitle { color: rgba(255,255,255,0.4); text-align: center; font-size: 0.85rem; margin-bottom: 35px; }
        .form-control { background: var(--black); border: 1px solid rgba(255,255,255,0.1); border-radius: 0; color: #fff; padding: 14px 16px; }
        .form-control:focus { background: var(--black); border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,169,98,0.1); color: #fff; }
        .form-control::placeholder { color: rgba(255,255,255,0.3); }
        .form-label { color: rgba(255,255,255,0.6); font-size: 0.8rem; letter-spacing: 1px; text-transform: uppercase; }
        .btn-login { background: var(--gold); color: #fff; border: none; border-radius: 0; padding: 14px; width: 100%; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; font-size: 0.8rem; transition: all 0.3s; }
        .btn-login:hover { background: var(--gold-dark); }
        .alert-error { background: rgba(220,53,69,0.1); border: 1px solid rgba(220,53,69,0.3); color: #ff6b6b; border-radius: 0; font-size: 0.85rem; padding: 12px; }
        .input-group-text { background: var(--black); border: 1px solid rgba(255,255,255,0.1); border-right: none; color: var(--gold); border-radius: 0; }
        .form-control.with-icon { border-left: none; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-brand">Gourmet<span>Affair</span></div>
        <p class="login-subtitle">Admin Panel</p>

        <?php if ($error): ?>
        <div class="alert alert-error mb-4"><i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control with-icon" placeholder="Enter username" required autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control with-icon" placeholder="Enter password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-login">Sign In</button>
        </form>

        <p style="color: rgba(255,255,255,0.25); font-size: 0.75rem; text-align: center; margin-top: 25px;">
            Default: admin / admin123
        </p>
    </div>
</body>
</html>
