<?php
session_start();
// Si l'utilisateur n'est pas connecté, on le renvoie vers login.php
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
// 4. Connexion à une base MySQL [cite: 57]
$host = "localhost"; $user = "root"; $pass = ""; $dbname = "gestion_client_db";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) die("Erreur connexion: " . $conn->connect_error);

// 3. Traitement PHP: récupération et insertion [cite: 56, 57]
if (isset($_POST['ajouter'])) {
    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $sexe = $_POST['sexe'];
    $ville = $_POST['ville'];
    $loisirs = isset($_POST['loisirs']) ? implode(", ", $_POST['loisirs']) : "";

    $sql = "INSERT INTO clients (nom, prenom, sexe, ville, loisirs) VALUES ('$nom', '$prenom', '$sexe', '$ville', '$loisirs')";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Client ajouté avec succès</div>";
    } else {
        echo "Erreur: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Gestion des clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <a href="logout.php" class="btn btn-danger float-end">Se déconnecter</a>
    <h2 class="mb-4">Gestion des clients</h2>

    <div class="card p-4 mb-4">
        <h4>Nouveau Client</h4>
        <form name="clientForm" method="POST" action="" onsubmit="return validerForm()">
            <div class="row">
                <div class="col"><input type="text" name="nom" id="nom" class="form-control" placeholder="Nom"></div>
                <div class="col"><input type="text" name="prenom" id="prenom" class="form-control" placeholder="Prénom"></div>
            </div>
            <div class="mt-3">
                <label>Sexe:</label>
                <input type="radio" name="sexe" value="Homme" checked> Homme
                <input type="radio" name="sexe" value="Femme"> Femme
            </div>
            <div class="mt-3">
                <select name="ville" class="form-control">
                    <option value="Oujda">Oujda</option>
                    <option value="Casablanca">Casablanca</option>
                    <option value="Rabat">Rabat</option>
                </select>
            </div>
            <div class="mt-3">
                <label>Loisirs:</label><br>
                <input type="checkbox" name="loisirs[]" value="Sport"> Sport
                <input type="checkbox" name="loisirs[]" value="Lecture"> Lecture
                <input type="checkbox" name="loisirs[]" value="Voyage"> Voyage
            </div>
            <button type="submit" name="ajouter" class="btn btn-primary mt-3">Enregistrer</button>
        </form>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
        <h4>Liste des Clients</h4>
        <a href="export.php" class="btn btn-success">📄 Exporter en CSV</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Sexe</th><th>Ville</th><th>Loisirs</th></tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM clients");
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nom']}</td>
                    <td>{$row['prenom']}</td>
                    <td>{$row['sexe']}</td>
                    <td>{$row['ville']}</td>
                    <td>{$row['loisirs']}</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
    function validerForm() {
        let nom = document.getElementById("nom").value;
        let prenom = document.getElementById("prenom").value;
        if (nom == "" || prenom == "") {
            alert("Veuillez remplir le nom et le prénom !"); // Alerte si champ manquant
            return false;
        }
        return true;
    }
    </script>
</body>
</html>