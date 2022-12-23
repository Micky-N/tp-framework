<?php

namespace Library\Entities;

use DateTime;
use Library\Abstracts\Entity;

class Comment extends Entity
{
    const AUTEUR_INVALIDE = 1;
    const CONTENU_INVALIDE = 2;
    protected int $news;
    protected string $auteur;
    protected string $contenu;
    protected DateTime $date;

    public function isValid(): bool
    {
        return !(empty($this->auteur) || empty($this->contenu));
    }

    // SETTERS
    public function setNews(int $news)
    {
        $this->news = $news;
    }

    public function setAuteur(string $auteur)
    {
        if (empty($auteur)) {
            $this->erreurs[] = self::AUTEUR_INVALIDE;
        } else {
            $this->auteur = $auteur;
        }
    }

    public function setContenu(string $contenu)
    {
        if (empty($contenu)) {
            $this->erreurs[] = self::CONTENU_INVALIDE;
        } else {
            $this->contenu = $contenu;
        }
    }

    public function setDate(DateTime|string $date)
    {
        if(is_string($date)){
            $date = new DateTime($date);
        }
        $this->date = $date;
    }

    // GETTERS
    public function news(): int
    {
        return $this->news;
    }

    public function auteur(): string
    {
        return $this->auteur ?? '';
    }

    public function contenu(): string
    {
        return $this->contenu ?? '';
    }

    public function date(): DateTime
    {
        return $this->date;
    }
}