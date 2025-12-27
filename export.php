<?php

$host = "localhost"; $user = "root"; $pass = ""; $dbname = "gestion_client_db";
$conn = new mysqli($host, $user, $pass, $dbname);

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=clients_export.csv');

$output = fopen('php://output', 'w');

fputcsv($output, array('ID', 'Nom', 'Prenom', 'Sexe', 'Ville', 'Loisirs'), ";");


$query = "SELECT * FROM clients";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row, ";");
}

fclose($output);
exit;
?>
