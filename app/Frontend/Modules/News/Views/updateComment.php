<form action="" method="post">
    <?php if (isset($erreurs) && in_array(\Library\Entities\Comment::AUTEUR_INVALIDE, $erreurs)): ?>
        <p>L'auteur est invalide.</p>
    <?php endif; ?>
    <label>Pseudo</label>
    <input type="text" name="pseudo" value="<?= htmlspecialchars($comment['auteur']); ?>"/><br/>
    <?php if (isset($erreurs) && in_array(\Library\Entities\Comment::CONTENU_INVALIDE, $erreurs)): ?>
        <p>Le contenu est invalide.</p>
    <?php endif; ?>
    <label>Contenu</label>
    <textarea name="contenu" rows="7" cols="50"><?= htmlspecialchars($comment['contenu']) ?></textarea><br/>
    <input type="hidden" name="news" value="<?= $comment['news']; ?>"/>
    <input type="submit" value="Modifier"/>
</form>