<?php

namespace Library\Models;

use Library\Entities\User;
use PDO;

class UserManagerPDO extends UserManager
{

    public function getList($debut = -1, $limit = -1): array
    {
        $sql = 'SELECT * FROM users ORDER BY id DESC';
        if ($debut != -1 || $limit != -1) {
            $sql .= ' LIMIT ' . (int)$limit . ' OFFSET ' . (int)$debut;
        }
        $request = $this->dao->query($sql);
        $listUsers = $request->fetchAll();
        if ($listUsers) {
            return array_map(fn($news) => new User($news), $listUsers);
        }
        return [];
    }

    public function getUnique(int $id): User|false
    {
        $request = $this->dao->prepare('SELECT * FROM users WHERE id = :id');
        $request->bindValue(':id', $id, PDO::PARAM_INT);
        $request->execute();
        if ($user = $request->fetch()) {
            return new User($user);
        }
        return false;
    }

    /**
     * @param array $columns
     * @return User[]
     */
    public function getBy(array $columns): array
    {
        $sqlColumns = [];
        foreach ($columns as $filter => $value) {
            $sqlColumns[] = "$filter = :$filter";
        }
        $request = $this->dao->prepare("SELECT * FROM users WHERE " . join(' AND ', $sqlColumns));
        foreach ($columns as $column => $value) {
            $request->bindValue(":$column", $value);
        }
        $request->execute();
        $listUsers = $request->fetchAll();
        if ($listUsers) {
            return array_map(fn($news) => new User($news), $listUsers);
        }
        return [];
    }

    public function count(): int
    {
        return $this->dao->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

    public function delete(int $id): void
    {
        $this->dao->exec('DELETE FROM users WHERE id = ' . $id);
    }

    public function add(User $user): void
    {
        $request = $this->dao->prepare('INSERT INTO users SET email = :email, password = :password, is_admin = 0, created_at = NOW(), updated_at = NOW()');
        $request->bindValue(':email', $user->email());
        $request->bindValue(':password', password_hash($user->password(), PASSWORD_DEFAULT));
        $request->execute();
    }

    public function modify(User $user): void
    {
        $request = $this->dao->prepare('UPDATE users SET email = :email, password = :password, is_admin = :is_admin, updated_at = NOW() WHERE id = :id');
        $request->bindValue(':email', $user->email());
        $request->bindValue(':password', $user->password());
        $request->bindValue(':is_admin', $user->isAdmin());
        $request->bindValue(':id', $user->id(), \PDO::PARAM_INT);
        $request->execute();
    }
}