<?php

namespace Library\Entities;

use DateTime;
use Library\Abstracts\Entity;

class News extends Entity
{
    const AUTEUR_INVALIDE = 1;
    const TITRE_INVALIDE = 2;
    const CONTENU_INVALIDE = 3;
    protected string $auteur;
    protected string $titre;
    protected string $contenu;
    protected DateTime $dateAjout;
    protected DateTime $dateModif;

    public function isValid(): bool
    {
        return !(empty($this->auteur) || empty($this->titre) || empty($this->contenu));
    }

    // SETTERS //
    public function setAuteur(string $auteur): void
    {
        if (empty($auteur)) {
            $this->erreurs[] = self::AUTEUR_INVALIDE;
        } else {
            $this->auteur = $auteur;
        }
    }

    public function setTitre(string $titre): void
    {
        if (empty($titre)) {
            $this->erreurs[] = self::TITRE_INVALIDE;
        } else {
            $this->titre = $titre;
        }
    }

    public function setContenu(string $contenu): void
    {
        if (empty($contenu)) {
            $this->erreurs[] = self::CONTENU_INVALIDE;
        } else {
            $this->contenu = $contenu;
        }
    }

    public function setDateAjout(string|DateTime $dateAjout)
    {
        if(is_string($dateAjout)){
            $dateAjout = new DateTime($dateAjout);
        }
        $this->dateAjout = $dateAjout;
    }

    public function setDateModif(string|DateTime $dateModif)
    {
        if(is_string($dateModif)){
            $dateModif = new DateTime($dateModif);
        }
        $this->dateModif = $dateModif;
    }

    // GETTERS //
    public function auteur(): string
    {
        return $this->auteur ?? '';
    }

    public function titre(): string
    {
        return $this->titre ?? '';
    }

    public function contenu(): string
    {
        return $this->contenu ?? '';
    }

    public function dateAjout(): DateTime
    {
        return $this->dateAjout;
    }

    public function dateModif(): DateTime
    {
        return $this->dateModif;
    }
}