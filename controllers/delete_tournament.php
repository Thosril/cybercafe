<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/cyber/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Préparez et exécutez la requête de suppression
    $stmt = $pdo->prepare("DELETE FROM Tournoi WHERE id = ?");
    if ($stmt->execute([$id])) {
        header('Location: index.php?route=tournois');
        exit;
    } else {
        die('Erreur lors de la suppression du tournoi.');
    }
}
?>
