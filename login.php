<?php
session_start();

// Identifiants (en dur pour faire simple)
$admin_user = "admin";
$admin_pass = "1234"; 

if (isset($_POST['connect'])) {
    if ($_POST['user'] == $admin_user && $_POST['password'] == $admin_pass) {
        $_SESSION['logged_in'] = true;
        header("Location: index.php"); // Redirection vers la gestion
        exit;
    } else {
        $error = "Identifiants incorrects !";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5" style="max-width: 400px;">
    <h3 class="text-center">Connexion Admin</h3>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    
    <div class="card p-4">
        <form method="post">
            <div class="mb-3">
                <label>Utilisateur</label>
                <input type="text" name="user" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="connect" class="btn btn-primary w-100">Se connecter</button>
        </form>
    </div>
</body>
</html>