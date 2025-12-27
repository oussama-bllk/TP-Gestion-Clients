<?php
// Connexion à la base de données
$host = "localhost"; $user = "root"; $pass = ""; $dbname = "gestion_client_db";
$conn = new mysqli($host, $user, $pass, $dbname);

// Configuration des en-têtes pour dire au navigateur "C'est un fichier CSV"
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=clients_export.csv');

// Création du fichier de sortie
$output = fopen('php://output', 'w');

// Ajouter les titres des colonnes (pour Excel)
fputcsv($output, array('ID', 'Nom', 'Prenom', 'Sexe', 'Ville', 'Loisirs'), ";");

// Récupérer les clients
$query = "SELECT * FROM clients";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    // Écrire chaque ligne dans le fichier CSV
    fputcsv($output, $row, ";");
}

fclose($output);
exit;
?>