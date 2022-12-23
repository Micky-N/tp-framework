<form action="" method="post">
    <?php if (isset($erreurs) && in_array(\Library\Entities\News::AUTEUR_INVALIDE, $erreurs)): ?>
        <p>L'auteur est invalide.</p>
    <?php endif; ?>
    <label>Auteur</label>
    <input type="text" name="auteur" value="<?= $news['auteur'] ?? '' ?>"/><br/>
    <?php if (isset($erreurs) && in_array(\Library\Entities\News::TITRE_INVALIDE, $erreurs)): ?>
        <p>Le titre est invalide.</p>
    <?php endif; ?>
    <label>Titre</label>
    <input type="text" name="titre" value="<?= $news['titre'] ?? '' ?>"/>
    <br/>
    <?php if (isset($erreurs) && in_array(\Library\Entities\News::CONTENU_INVALIDE, $erreurs)): ?>
        <p>Le contenu est invalide.</p>
    <?php endif; ?>
    <label>Contenu</label>
    <textarea rows="8" cols="60" name="contenu"><?= $news['contenu'] ?? '' ?></textarea><br/>
    <?php if (isset($news) && !$news->isNew()): ?>
        <input type="hidden" name="id" value="<?= $news['id']; ?>"/>
        <input type="submit" value="Modifier" name="modifier"/>
    <?php else: ?>
        <input type="submit" value="Ajouter"/>
    <?php endif; ?>
</form>