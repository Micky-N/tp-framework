<?php

namespace Library\Models;

use Library\Abstracts\Manager;
use Library\Entities\User;

abstract class UserManager extends Manager
{
    abstract public function getList($debut = -1, $limit = -1): array;

    /**
     * Méthode renvoyant le nombre de news total.
     * @return int
     */
    abstract public function count(): int;

    public function save(User $user)
    {
        if ($user->isValid()) {
            $user->isNew() ? $this->add($user) : $this->modify($user);
        } else {
            throw new \RuntimeException('L\'utilisateur doit être validé pour être enregistré');
        }
    }

    /**
     * Méthode permettant d'ajouter une news.
     * @param User $user La news à ajouter
     * @return void
     */
    abstract public function add(User $user): void;

    /**
     * Méthode permettant de modifier une news.
     * @param User $user la news à modifier
     * @return void
     */
    abstract public function modify(User $user): void;

    /**
     * Méthode permettant de supprimer une news.
     * @param int $id L'identifiant de la news à supprimer
     * @return void
     */
    abstract public function delete(int $id): void;
}