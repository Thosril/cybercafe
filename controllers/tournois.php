<?php 
session_start(); // Démarre la session

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    // Redirection si l'utilisateur n'est pas connecté
    header('Location: login.php');
    exit;
}

// Vérifie si le formulaire d'inscription a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateur_id = $_SESSION['user_id'];
    $tournoi_id = (int)$_POST['tournoi_id'];

    if (isset($_POST['inscription'])) {
        // Vérifie si l'utilisateur est déjà inscrit
        $stmtCheck = $pdo->prepare("SELECT * FROM Inscriptions WHERE utilisateur_id = ? AND tournoi_id = ?");
        $stmtCheck->execute([$utilisateur_id, $tournoi_id]);

        if ($stmtCheck->fetch()) {
            echo "Vous êtes déjà inscrit à ce tournoi.";
        } else {
            // Inscription au tournoi
            $stmt = $pdo->prepare("INSERT INTO Inscriptions (utilisateur_id, tournoi_id) VALUES (?, ?)");
            if ($stmt->execute([$utilisateur_id, $tournoi_id])) {
                header('Location: ../views/tournois.php?success=inscription');
                exit;
            } else {
                echo "Erreur lors de l'inscription au tournoi.";
            }
        }
    } elseif (isset($_POST['retirer'])) {
        // Désinscription du tournoi
        $stmt = $pdo->prepare("DELETE FROM Inscriptions WHERE utilisateur_id = ? AND tournoi_id = ?");
        if ($stmt->execute([$utilisateur_id, $tournoi_id])) {
            header('Location: ../views/tournois.php?success=desinscription');
            exit;
        } else {
            echo "Erreur lors de la désinscription du tournoi.";
        }
    }
}

// Récupération des tournois
$stmt = $pdo->query('SELECT * FROM Tournoi ORDER BY date DESC');
$tournois = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inclusion de la vue des tournois
include '../views/tournois.php';
?>
