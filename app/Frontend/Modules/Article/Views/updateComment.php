<form action="" method="post">
    <?php if (isset($errors) && in_array(\Library\Entities\Comment::INVALID_AUTHOR, $errors)): ?>
        <p>L'auteur est invalide.</p>
    <?php endif; ?>
    <label>Pseudo</label>
    <input type="text" name="author" value="<?= htmlspecialchars($comment['author']); ?>"/><br/>
    <?php if (isset($errors) && in_array(\Library\Entities\Comment::INVALID_CONTENT, $errors)): ?>
        <p>Le contenu est invalide.</p>
    <?php endif; ?>
    <label>Contenu</label>
    <textarea name="content" rows="7" cols="50"><?= htmlspecialchars($comment['content']) ?></textarea><br/>
    <input type="hidden" name="newsId" value="<?= $comment['news_id']; ?>"/>
    <input type="submit" value="Modifier"/>
</form>