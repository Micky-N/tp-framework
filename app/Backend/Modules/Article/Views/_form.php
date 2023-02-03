<form action="" method="post">
    <?php if (isset($errors) && in_array(\Library\Entities\News::INVALID_AUTHOR, $errors)): ?>
        <p>L'auteur est invalide.</p>
    <?php endif; ?>
    <label>Auteur</label>
    <input type="text" name="author" value="<?= $news['author'] ?? '' ?>"/><br/>
    <?php if (isset($errors) && in_array(\Library\Entities\News::INVALID_TITLE, $errors)): ?>
        <p>Le titre est invalide.</p>
    <?php endif; ?>
    <label>Titre</label>
    <input type="text" name="title" value="<?= $news['title'] ?? '' ?>"/>
    <br/>
    <?php if (isset($errors) && in_array(\Library\Entities\News::INVALID_CONTENT, $errors)): ?>
        <p>Le contenu est invalide.</p>
    <?php endif; ?>
    <label>Contenu</label>
    <textarea rows="8" cols="60" name="content"><?= $news['content'] ?? '' ?></textarea><br/>
    <?php if (isset($news) && !$news->isNew()): ?>
        <input type="hidden" name="id" value="<?= $news['id']; ?>"/>
        <input type="submit" value="Modifier" name="modifier"/>
    <?php else: ?>
        <input type="submit" value="Ajouter"/>
    <?php endif; ?>
</form>