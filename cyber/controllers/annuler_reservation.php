<?php
// controllers/annuler_reservation.php

ob_start(); // Commence la mise en mémoire tampon de sortie

// Connexion à la base de données
include $_SERVER['DOCUMENT_ROOT'] . '/cyber/db.php';

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?route=login');
    exit;
}

// Traitement de l'annulation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservation_id'])) {
    $reservation_id = (int)$_POST['reservation_id'];

    // Supprimer la réservation de la BDD
    $stmt = $pdo->prepare("DELETE FROM Reservation WHERE id = ? AND utilisateur_id = ?");
    if ($stmt->execute([$reservation_id, $_SESSION['user_id']])) {
        // Optionnel : Mettre à jour le statut du poste
        $stmt = $pdo->prepare("UPDATE Postes SET statut = 'disponible' WHERE id = (SELECT poste_id FROM Reservation WHERE id = ?)");
        $stmt->execute([$reservation_id]);

        header('Location: index.php?route=profil&success=1');
        exit;
    } else {
        $error = 'Erreur lors de l\'annulation de la réservation.';
    }
}

ob_end_flush(); // Termine la mise en mémoire tampon et envoie le contenu
?>
