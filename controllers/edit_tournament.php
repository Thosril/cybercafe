<?php 
// Dans votre contrôleur, par exemple update_tournament.php
include $_SERVER['DOCUMENT_ROOT'] . '/cyber/db.php';

$id = $_GET['id']; // ID du tournoi à modifier
$stmt = $pdo->prepare("SELECT * FROM Tournoi WHERE id = ?");
$stmt->execute([$id]);
$tournoi = $stmt->fetch(PDO::FETCH_ASSOC);

// Assurez-vous que vous avez bien récupéré le tournoi
if (!$tournoi) {
    // Gérer le cas où le tournoi n'existe pas
    die("Tournoi non trouvé");
}

// Maintenant incluez la vue
include 'views/edit_tournament.php';
?>