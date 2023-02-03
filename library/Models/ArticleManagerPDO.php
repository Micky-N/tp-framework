<?php

namespace Library\Models;

use Library\Abstracts\Entity;
use Library\Entities\News;
use PDO;

class ArticleManagerPDO extends ArticleManager
{

    public function getList($debut = -1, $limit = -1): array
    {
        $sql = 'SELECT * FROM news ORDER BY id DESC';
        if ($debut != -1 || $limit != -1) {
            $sql .= ' LIMIT ' . (int)$limit . ' OFFSET ' . (int)$debut;
        }
        $request = $this->dao->query($sql);
        $listNews = $request->fetchAll();
        if ($listNews) {
            return array_map(fn($news) => new News($news), $listNews);
        }
        return [];
    }

    public function getUnique(int $id): News|false
    {
        $requete = $this->dao->prepare('SELECT * FROM news WHERE id = :id');
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
        $request = $this->dao->prepare('INSERT INTO news SET author = :author, title = :title, content = :content, created_at = NOW(), updated_at = NOW()');
        $request->bindValue(':title', $news->title());
        $request->bindValue(':author', $news->author());
        $request->bindValue(':content', $news->content());
        $request->execute();
    }

    protected function modify(News $news): void
    {
        $request = $this->dao->prepare('UPDATE news SET author = :author, title = :title, content = :content, updated_at = NOW() WHERE id = :id');
        $request->bindValue(':title', $news->title());
        $request->bindValue(':author', $news->author());
        $request->bindValue(':content', $news->content());
        $request->bindValue(':id', $news->id(), \PDO::PARAM_INT);
        $request->execute();
    }
}