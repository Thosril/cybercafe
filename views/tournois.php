<?php
// Démarre la session s'il n'y a pas déjà une session active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/cyber/db.php');

// Récupère tous les tournois depuis la base de données
$stmt = $pdo->prepare("SELECT * FROM Tournoi"); // Assurez-vous que la table s'appelle bien 'Tournois'
$stmt->execute();
$tournois = $stmt->fetchAll(); // Récupère tous les tournois sous forme de tableau

// Affiche un message de succès si applicable
if (isset($_GET['success'])) {
    if ($_GET['success'] == 2) {
        echo "<p style='color: green;'>Désinscription réussie !</p>";
    } elseif ($_GET['success'] == 1) {
        echo "<p style='color: green;'>Inscription réussie !</p>";
    }
}
?>

<style>
    .tableau {
        background-color: #333;
        border: 2px solid #333;
        border-radius: 13px;
        padding: 10px;
        margin-top: 2%;
    }
</style>

<?php if (count($tournois) > 0): ?>
    <?php foreach ($tournois as $tournoi): ?>
        <div class="tableau">
            <h3><?php echo htmlspecialchars($tournoi['nom']); ?></h3>
            <p>Date : <?php echo htmlspecialchars($tournoi['date']); ?></p>
            <p>Description : <?php echo htmlspecialchars($tournoi['description']); ?></p>
            <p>Statut : <?php echo htmlspecialchars($tournoi['statut']); ?></p>

            <?php 
            
            // Vérifie si l'utilisateur est connecté
            if (isset($_SESSION['user_id'])) {
                
            // Vérifie si l'utilisateur est déjà inscrit
            $stmt = $pdo->prepare("SELECT * FROM Inscriptions WHERE utilisateur_id = ? AND tournoi_id = ?");
            $stmt->execute([$_SESSION['user_id'], $tournoi['id']]);
            $deja_inscrit = $stmt->fetch();
            
            

            if (!$deja_inscrit): ?>
                <!-- Formulaire d'inscription -->
                <form action="../cyber/controllers/inscription_tournoi.php" method="POST">
                    <input type="hidden" name="tournoi_id" value="<?= $tournoi['id'] ?>">
                    <button type="submit" name="inscription">S'inscrire au Tournoi</button>
                </form>
            <?php else: ?>
                <p>Vous êtes déjà inscrit à ce tournoi.</p>
                <!-- Formulaire de désinscription -->
                <form action="../cyber/controllers/delete_inscription.php" method="POST" style="display:inline;">
                    <input type="hidden" name="tournoi_id" value="<?php echo $tournoi['id']; ?>">
                    <button type="submit" name="retirer" onclick="return confirm('Êtes-vous sûr de vouloir vous retirer ?');">Se désinscrire du Tournoi</button>
                </form>
            <?php endif; } ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun tournoi disponible pour le moment.</p>
<?php endif; ?>
