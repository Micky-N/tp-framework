<?php

namespace Library\Models;

use Library\Entities\Customer;
use PDO;

class CustomerManagerPDO extends CustomerManager
{

    public function getList($debut = -1, $limit = -1): array
    {
        $sql = 'SELECT * FROM customers ORDER BY id DESC';
        if ($debut != -1 || $limit != -1) {
            $sql .= ' LIMIT ' . (int)$limit . ' OFFSET ' . (int)$debut;
        }
        $request = $this->dao->query($sql);
        $listCustomers = $request->fetchAll();
        if ($listCustomers) {
            return array_map(fn($customer) => new Customer($customer), $listCustomers);
        }
        return [];
    }

    public function getUnique(int $id): Customer|false
    {
        $request = $this->dao->prepare('SELECT * FROM customers WHERE id = :id');
        $request->bindValue(':id', $id, PDO::PARAM_INT);
        $request->execute();
        if ($customer = $request->fetch()) {
            return new Customer($customer);
        }
        return false;
    }

    /**
     * @param array $columns
     * @param bool $one
     * @return Customer[]|Customer|false
     */
    public function getBy(array $columns, bool $one = false): array|Customer|false
    {
        $sqlColumns = [];
        foreach ($columns as $filter => $value) {
            $sqlColumns[] = "$filter = :$filter";
        }
        $request = $this->dao->prepare("SELECT * FROM customers WHERE " . join(' AND ', $sqlColumns));
        foreach ($columns as $column => $value) {
            $request->bindValue(":$column", $value);
        }
        $request->execute();
        if ($one) {
            if ($customer = $request->fetch()) {
                return new Customer($customer);
            }
        } else {
            if ($listCustomers = $request->fetchAll()) {
                return array_map(fn($customer) => new Customer($customer), $listCustomers);
            }
        }
        return [];
    }

    public function count(): int
    {
        return $this->dao->query('SELECT COUNT(*) FROM customers')->fetchColumn();
    }

    public function delete(int $id): void
    {
        $this->dao->exec('DELETE FROM customers WHERE id = ' . $id);
    }

    public function add(Customer $customer): void
    {
        $request = $this->dao->prepare('INSERT INTO customers SET email = :email, password = :password, created_at = NOW(), updated_at = NOW()');
        $request->bindValue(':email', $customer->email());
        $request->bindValue(':password', password_hash($customer->password(), PASSWORD_DEFAULT));
        $request->execute();
    }

    public function modify(Customer $customer): void
    {
        $request = $this->dao->prepare('UPDATE customers SET email = :email, password = :password, updated_at = NOW() WHERE id = :id');
        $request->bindValue(':email', $customer->email());
        $request->bindValue(':password', $customer->password());
        $request->bindValue(':id', $customer->id(), \PDO::PARAM_INT);
        $request->execute();
    }
}