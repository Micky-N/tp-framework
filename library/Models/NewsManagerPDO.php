<?php

namespace Library\Models;

use Library\Abstracts\Entity;
use Library\Entities\News;
use PDO;

class NewsManagerPDO extends NewsManager
{

    public function getList($debut = -1, $limite = -1): false|array
    {
        $sql = 'SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM news ORDER BY id DESC';
        if ($debut != -1 || $limite != -1) {
            $sql .= ' LIMIT ' . (int)$limite . ' OFFSET ' . (int)$debut;
        }
        $requete = $this->dao->query($sql);
        $listNews = $requete->fetchAll();
        if ($listNews) {
            return array_map(fn($news) => new News($news), $listNews);
        }
        return [];
    }

    public function getUnique($id): Entity|false
    {
        $requete = $this->dao->prepare('SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM news WHERE id = :id');
        $requete->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $requete->execute();
        if ($news = $requete->fetch()) {
            return new News($news);
        }
        return false;
    }

    public function count(): int
    {
        return $this->dao->query('SELECT COUNT(*) FROM news')->fetchColumn();
    }

    public function delete(int $id): void
    {
        $this->dao->exec('DELETE FROM news WHERE id = ' . $id);
    }

    protected function add(News $news): void
    {
        $requete = $this->dao->prepare('INSERT INTO news SET auteur = :auteur, titre = :titre, contenu = :contenu, dateAjout = NOW(), dateModif = NOW()');
        $requete->bindValue(':titre', $news->titre());
        $requete->bindValue(':auteur', $news->auteur());
        $requete->bindValue(':contenu', $news->contenu());
        $requete->execute();
    }

    protected function modify(News $news): void
    {
        $requete = $this->dao->prepare('UPDATE news SET auteur = :auteur, titre = :titre, contenu = :contenu, dateModif = NOW() WHERE id = :id');
        $requete->bindValue(':titre', $news->titre());
        $requete->bindValue(':auteur', $news->auteur());
        $requete->bindValue(':contenu', $news->contenu());
        $requete->bindValue(':id', $news->id(), \PDO::PARAM_INT);
        $requete->execute();
    }
}