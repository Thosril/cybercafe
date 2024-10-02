<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/cyber/db.php');

// Vérifie que l'utilisateur est connecté et est un client
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'client') {
    header('Location: index.php?route=login');
    exit;
}

// Traitement de la désinscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateur_id = $_SESSION['user_id'];
    $tournoi_id = (int)$_POST['tournoi_id'];

    // Suppression de l'inscription dans la BDD
    $stmt = $pdo->prepare("DELETE FROM Inscriptions WHERE utilisateur_id = ? AND tournoi_id = ?");
    if ($stmt->execute([$utilisateur_id, $tournoi_id])) {
        // Redirection après une désinscription réussie
        header('Location: ../index.php?route=tournois&success=2');
        exit;
    } else {
        $error = 'Erreur lors de la désinscription du tournoi.';
        // Gérer l'erreur si nécessaire
    }
}
?>
