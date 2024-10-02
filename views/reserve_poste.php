<h2>Réserver un poste</h2>

<?php if (isset($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="index.php?route=reserve_poste">
    <label for="poste_id">Choisir un poste :</label>
    <select name="poste_id" required>
        <?php foreach ($postes as $poste): ?>
            <option value="<?= $poste['id'] ?>"><?= htmlspecialchars($poste['nom']) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="date">Date :</label>
    <input type="date" name="date" required>

    <label for="heure_debut">Heure de début :</label>
    <input type="time" name="heure_debut" required>

    <label for="duree">Durée (minutes) :</label>
    <input type="number" name="duree" required>

    <button type="submit">Réserver</button>
</form>
