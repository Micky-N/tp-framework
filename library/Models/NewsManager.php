<?php

namespace Library\Models;

use Library\Abstracts\Manager;
use Library\Entities\News;

abstract class NewsManager extends Manager
{
    abstract public function getList($debut = -1, $limite = -1): array|false;

    /**
     * Méthode renvoyant le nombre de news total.
     * @return int
     */
    abstract public function count(): int;

    public function save(News $news)
    {
        if ($news->isValid()) {
            $news->isNew() ? $this->add($news) : $this->modify($news);
        } else {
            throw new \RuntimeException('La news doit être validée pour être enregistrée');
        }
    }

    /**
     * Méthode permettant d'ajouter une news.
     * @param News $news La news à ajouter
     * @return void
     */
    abstract protected function add(News $news): void;

    /**
     * Méthode permettant de modifier une news.
     * @param News $news la news à modifier
     * @return void
     */
    abstract protected function modify(News $news): void;

    /**
     * Méthode permettant de supprimer une news.
     * @param int $id L'identifiant de la news à supprimer
     * @return void
     */
    abstract public function delete(int $id): void;
}