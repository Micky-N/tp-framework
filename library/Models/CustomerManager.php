<?php

namespace Library\Models;

use Library\Abstracts\Manager;
use Library\Entities\Customer;

abstract class CustomerManager extends Manager
{
    abstract public function getList($debut = -1, $limit = -1): array;

    /**
     * Méthode renvoyant le nombre de news total.
     * @return int
     */
    abstract public function count(): int;

    public function save(Customer $customer)
    {
        if ($customer->isValid()) {
            $customer->isNew() ? $this->add($customer) : $this->modify($customer);
        } else {
            throw new \RuntimeException('L\'utilisateur doit être validé pour être enregistré');
        }
    }

    /**
     * Méthode permettant d'ajouter une news.
     * @param Customer $customer La news à ajouter
     * @return void
     */
    abstract public function add(Customer $customer): void;

    /**
     * Méthode permettant de modifier une news.
     * @param Customer $customer la news à modifier
     * @return void
     */
    abstract public function modify(Customer $customer): void;

    /**
     * Méthode permettant de supprimer une news.
     * @param int $id L'identifiant de la news à supprimer
     * @return void
     */
    abstract public function delete(int $id): void;
}