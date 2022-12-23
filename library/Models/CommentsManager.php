<?php

namespace Library\Models;

use Library\Abstracts\Manager;
use Library\Entities\Comment;
use RuntimeException;

abstract class CommentsManager extends Manager
{
    /**
     * Méthode permettant d'enregistrer un commentaire.
     * @param Comment $comment Le commentaire à enregistrer
     * @return void
     */
    public function save(Comment $comment): void
    {
        if ($comment->isValid()) {
            $comment->isNew() ? $this->add($comment) : $this->modify($comment);
        } else {
            throw new RuntimeException('Le commentaire doit être validé pour être enregistré');
        }
    }

    /**
     * Méthode permettant d'ajouter un commentaire
     * @param Comment $comment Le commentaire à ajouter
     * @return void
     */
    abstract protected function add(Comment $comment): void;

    /**
     * Méthode permettant de récupérer une liste de commentaires.
     * @param int $news La news sur laquelle on veut récupérer les commentaires
     * @return array|false
     */
    abstract public function getListOf(int $news): array|false;

    /**
     * Méthode permettant de modifier un commentaire.
     * @param Comment $comment Le commentaire à modifier
     * @return void
     */
    abstract protected function modify(Comment $comment): void;
    /**
     * Méthode permettant d'obtenir un commentaire spécifique.
     * @param int $id L'identifiant du commentaire
     * @return Comment|false
     */
    abstract public function get(int $id): Comment|false;

    /**
     * Méthode permettant de supprimer un commentaire.
     * @param int $id L'identifiant du commentaire à supprimer
     * @return void
     */
    abstract public function delete(int $id): void;
}