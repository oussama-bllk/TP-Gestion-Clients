<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "gestion_client_db");
if ($conn->connect_error) die("Erreur : " . $conn->connect_error);

if (isset($_POST['ajouter'])) {
    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $sexe = $_POST['sexe'];
    $ville = $_POST['ville'];
    $loisirs = isset($_POST['loisirs']) ? implode(", ", $_POST['loisirs']) : "";

    $sql = "INSERT INTO clients (nom, prenom, sexe, ville, loisirs) VALUES ('$nom', '$prenom', '$sexe', '$ville', '$loisirs')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "<div class='alert alert-dismissible alert-success'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>Client ajouté avec succès !</div>";
    } else {
        $message = "<div class='alert alert-dismissible alert-danger'>Erreur SQL : " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.0/dist/darkly/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Gestion Clients</a>
            <div class="d-flex">
                <span class="navbar-text me-3">Bienvenue, Admin</span>
                <a href="logout.php" class="btn btn-secondary btn-sm">Se déconnecter</a>
            </div>
        </div>
    </nav>

    <div class="container">

        <?php if(isset($message)) echo $message; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="card border-primary mb-3">
                    <div class="card-header">Nouveau Client</div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-2">
                                <input type="text" name="nom" class="form-control" placeholder="Nom" required>
                            </div>
                            <div class="mb-2">
                                <input type="text" name="prenom" class="form-control" placeholder="Prénom" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label mt-2">Sexe :</label><br>
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="sexe" id="btnradio1" value="Homme" checked>
                                    <label class="btn btn-outline-info" for="btnradio1">Homme</label>

                                    <input type="radio" class="btn-check" name="sexe" id="btnradio2" value="Femme">
                                    <label class="btn btn-outline-warning" for="btnradio2">Femme</label>
                                </div>
                            </div>
                            <div class="mb-2">
                                <select name="ville" class="form-select">
                                    <option value="Oujda">Oujda</option>
                                    <option value="Casablanca">Casablanca</option>
                                    <option value="Rabat">Rabat</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Loisirs :</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="loisirs[]" value="Sport">
                                    <label class="form-check-label">Sport</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="loisirs[]" value="Lecture">
                                    <label class="form-check-label">Lecture</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="loisirs[]" value="Voyage">
                                    <label class="form-check-label">Voyage</label>
                                </div>
                            </div>
                            <button type="submit" name="ajouter" class="btn btn-primary w-100">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border-secondary mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Liste des Clients</span>
                        <a href="export.php" class="btn btn-success btn-sm">Exporter CSV</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr class="table-active">
                                    <th>ID</th>
                                    <th>Nom & Prénom</th>
                                     <th>Sexe</th>
                                    <th>Ville</th>
                                    <th>Loisirs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $conn->query("SELECT * FROM clients ORDER BY id DESC");
                                while($row = $result->fetch_assoc()) {
                                    $badgeSexe = ($row['sexe'] == 'Homme') ? 'badge bg-info' : 'badge bg-warning';
                                    
                                    echo "<tr>
                                        <td>{$row['id']}</td>
                                        <td><strong>{$row['nom']}</strong> {$row['prenom']}</td>
                                        <td><span class='$badgeSexe'>{$row['sexe']}</span></td>
                                        <td>{$row['ville']}</td>
                                        <td>{$row['loisirs']}</td>
                                    </tr>";
                                }
                                ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
