<?php
session_start();


$admin_user = "admin";
$admin_pass = "1234"; 

if (isset($_POST['connect'])) {
    if ($_POST['user'] == $admin_user && $_POST['password'] == $admin_pass) {
        $_SESSION['logged_in'] = true; 
        header("Location: index.php"); 
        exit;
    } else {
        $error = "Identifiants incorrects !";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.0/dist/darkly/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh; 
        }
        .card {
            border: 1px solid #444; 
            box-shadow: 0 0 20px rgba(0,0,0,0.5); 
        }
    </style>
</head>
<body>

    <div class="card p-5" style="width: 100%; max-width: 400px;">
        <h2 class="text-center text-info mb-4">Espace Admin</h2>
        
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Utilisateur</label>
                <input type="text" name="user" class="form-control" placeholder="Entrez: admin" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" placeholder="Entrez: 1234" required>
            </div>
            <button type="submit" name="connect" class="btn btn-success w-100 btn-lg">Se connecter</button>
        </form>
    </div>

</body>
</html>
