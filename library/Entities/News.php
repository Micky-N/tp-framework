<?php

namespace Library\Entities;

use DateTime;
use Exception;
use Library\Abstracts\Entity;

class News extends Entity
{
    const INVALID_AUTHOR = 1;
    const INVALID_TITLE = 2;
    const INVALID_CONTENT = 3;
    protected string $author;
    protected string $title;
    protected string $content;
    protected ?DateTime $createdAt = null;
    protected ?DateTime $updatedAt = null;

    public function isValid(): bool
    {
        return !(empty($this->author) || empty($this->title) || empty($this->content));
    }

    // SETTERS //
    public function setAuthor(string $author): void
    {
        if (empty($author)) {
            $this->errors[] = self::INVALID_AUTHOR;
        } else {
            $this->author = $author;
        }
    }

    public function setTitle(string $title): void
    {
        if (empty($title)) {
            $this->errors[] = self::INVALID_TITLE;
        } else {
            $this->title = $title;
        }
    }

    public function setContent(string $content): void
    {
        if (empty($content)) {
            $this->errors[] = self::INVALID_CONTENT;
        } else {
            $this->content = $content;
        }
    }

    /**
     * @param string|DateTime $created_at
     * @return void
     * @throws Exception
     */
    public function setCreatedAt(string|DateTime $created_at): void
    {
        if(is_string($created_at)){
            $created_at = new DateTime($created_at);
        }
        $this->createdAt = $created_at;
    }

    /**
     * @param string|DateTime $updated_at
     * @return void
     * @throws Exception
     */
    public function setUpdatedAt(string|DateTime $updated_at): void
    {
        if(is_string($updated_at)){
            $updated_at = new DateTime($updated_at);
        }
        $this->updatedAt = $updated_at;
    }

    // GETTERS //
    public function author(): string
    {
        return $this->author ?? '';
    }

    public function title(): string
    {
        return $this->title ?? '';
    }

    public function content(): string
    {
        return $this->content ?? '';
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}