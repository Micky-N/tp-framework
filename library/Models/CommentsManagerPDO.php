<?php

namespace Library\Models;

use Exception;
use InvalidArgumentException;
use Library\Entities\Comment;
use PDO;

class CommentsManagerPDO extends CommentsManager
{

    /**
     * @param $news
     * @return false|Comment[]
     * @throws Exception
     */
    public function getListOf($news): false|array
    {
        if (!is_integer($news)) {
            throw new InvalidArgumentException('L\'identifiant de la news passé doit être un nombre entier valide');
        }
        $q = $this->dao->prepare('SELECT id, news, auteur, contenu, date FROM comments WHERE news = :news');
        $q->bindValue(':news', $news, PDO::PARAM_INT);
        $q->execute();
        $q->execute();
        if ($comments = $q->fetchAll()) {
            return array_map(fn($comment) => new Comment($comment), $comments);
        }
        return false;
    }

    public function get(int $id): Comment|false
    {
        $q = $this->dao->prepare('SELECT id, news, auteur, contenu FROM comments WHERE id = :id');
        $q->bindValue(':id', $id, \PDO::PARAM_INT);
        $q->execute();
        if ($comment = $q->fetch()) {
            return new Comment($comment);
        }
        return false;
    }

    public function delete(int $id): void
    {
        $this->dao->exec('DELETE FROM comments WHERE id = ' . $id);
    }

    /**
     * @inheritDoc
     */
    protected function add(Comment $comment): void
    {
        $q = $this->dao->prepare('INSERT INTO comments SET news = :news, auteur = :auteur, contenu = :contenu, date = NOW()');
        $q->bindValue(':news', $comment->news(), PDO::PARAM_INT);
        $q->bindValue(':auteur', $comment->auteur());
        $q->bindValue(':contenu', $comment->contenu());
        $q->execute();
        $comment->setId($this->dao->lastInsertId());
    }

    /**
     * @param Comment $comment
     * @return void
     */
    protected function modify(Comment $comment): void
    {
        $q = $this->dao->prepare('UPDATE comments SET auteur = :auteur, contenu = :contenu WHERE id = :id');
        $q->bindValue(':auteur', $comment->auteur());
        $q->bindValue(':contenu', $comment->contenu());
        $q->bindValue(':id', $comment->id(), \PDO::PARAM_INT);
        $q->execute();
    }
}