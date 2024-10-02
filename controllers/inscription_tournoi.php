<?php
session_start(); // Démarrer la session

// Connexion à la base de données
include '../db.php';

// Vérifie que l'utilisateur est connecté et est un client
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'client') {
    header('Location: index.php?route=login'); // Redirection si non connecté
    exit;
}

// Traitement de l'inscription au tournoi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tournoi_id'])) {
    $utilisateur_id = $_SESSION['user_id'];
    $tournoi_id = (int)$_POST['tournoi_id'];

    // Insertion de l'inscription dans la BDD
    $stmt = $pdo->prepare("INSERT INTO Inscriptions (utilisateur_id, tournoi_id) VALUES (?, ?)");
    
    if ($stmt->execute([$utilisateur_id, $tournoi_id])) {
        // Redirection après une inscription réussie
        header('Location: ../index.php?route=tournois&success=1'); // Assurez-vous que le chemin est correct
        exit;
    } else {
        echo "Erreur lors de l'inscription au tournoi : " . implode(", ", $stmt->errorInfo());
    }
} else {
    // Redirection si la méthode n'est pas POST ou si le tournoi_id n'est pas défini
    header('Location: ../index.php?route=tournois&error=1');
    exit;
}

?>