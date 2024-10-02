<?php
// Connexion à la base de données (assure-toi que $pdo est bien défini avant)
$tournoi = null;
$tournois = []; // Initialise la variable pour éviter l'erreur

// Si on modifie un tournoi, récupérer les données du tournoi spécifique
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM Tournoi WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $tournoi = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Récupérer la liste de tous les tournois
$stmt = $pdo->prepare('SELECT * FROM Tournoi');
$stmt->execute();
$tournois = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Afficher la liste des tournois avec des liens pour modifier ou supprimer
foreach ($tournois as $tournoi_item) {
    echo "<p>{$tournoi_item['nom']} ({$tournoi_item['date']}) 
          <a href='index.php?route=manage_tournois&id={$tournoi_item['id']}'>Modifier</a> | 
          <a href='index.php?route=manage_tournois&delete={$tournoi_item['id']}'>Supprimer</a></p>";
}
?>

<h1><?php echo $tournoi ? 'Modifier le tournoi' : 'Créer un tournoi'; ?></h1>

<form method="POST" action="index.php?route=manage_tournois">
    <input type="hidden" name="id" value="<?php echo $tournoi['id'] ?? ''; ?>">

    <label for="nom">Nom du tournoi :</label>
    <input type="text" id="nom" name="nom" value="<?php echo $tournoi['nom'] ?? ''; ?>" required>

    <label for="description">Description :</label>
    <textarea id="description" name="description" required><?php echo $tournoi['description'] ?? ''; ?></textarea>

    <label for="date">Date :</label>
    <input type="date" id="date" name="date" value="<?php echo $tournoi['date'] ?? ''; ?>" required>

    <label for="statut">Statut :</label>
    <select id="statut" name="statut" required>
        <option value="ouvert" <?php if (isset($tournoi['statut']) && $tournoi['statut'] == 'ouvert') echo 'selected'; ?>>Ouvert</option>
        <option value="fermé" <?php if (isset($tournoi['statut']) && $tournoi['statut'] == 'fermé') echo 'selected'; ?>>Fermé</option>
        <option value="en cours" <?php if (isset($tournoi['statut']) && $tournoi['statut'] == 'en cours') echo 'selected'; ?>>En cours</option>
        <option value="fermé" <?php if (isset($tournoi['statut']) && $tournoi['statut'] == 'fermé') echo 'selected'; ?>>Fermé</option>
        <option value="terminé" <?php if (isset($tournoi['statut']) && $tournoi['statut'] == 'terminé') echo 'selected'; ?>>Terminé</option>


    </select>

    <button type="submit" name="action" value="<?php echo $tournoi ? 'modifier' : 'créer'; ?>">
        <?php echo $tournoi ? 'Modifier' : 'Créer'; ?>
    </button>
</form>

<?php if ($tournoi): ?>
    <form method="POST" action="index.php?route=manage_tournois">
        <input type="hidden" name="id" value="<?php echo $tournoi['id']; ?>">
        <button type="submit" name="action" value="supprimer">Supprimer</button>
    </form>
<?php endif; ?>
