<?php

namespace Library\Entities;

use DateTime;
use Exception;
use Library\Abstracts\Entity;

class Comment extends Entity
{
    const INVALID_AUTHOR = 1;
    const INVALID_CONTENT = 2;
    protected int $newsId;
    protected string $author;
    protected string $content;
    protected ?DateTime $createdAt = null;
    protected ?DateTime $updatedAt = null;

    public function isValid(): bool
    {
        return !(empty($this->author) || empty($this->content));
    }

    // SETTERS
    public function setNewsId(int $newsId)
    {
        $this->newsId = $newsId;
    }

    public function setAuteur(string $author)
    {
        if (empty($author)) {
            $this->errors[] = self::INVALID_AUTHOR;
        } else {
            $this->author = $author;
        }
    }

    public function setContent(string $content)
    {
        if (empty($content)) {
            $this->errors[] = self::INVALID_CONTENT;
        } else {
            $this->content = $content;
        }
    }

    /**
     * @param DateTime|string $createdAt
     * @return void
     * @throws Exception
     */
    public function setCreatedAt(DateTime|string $createdAt): void
    {
        if(is_string($createdAt)){
            $createdAt = new DateTime($createdAt);
        }
        $this->createdAt = $createdAt;
    }

    /**
     * @param DateTime|string $updatedAt
     * @return void
     * @throws Exception
     */
    public function setUpdateAt(DateTime|string $updatedAt): void
    {
        if(is_string($updatedAt)){
            $updatedAt = new DateTime($updatedAt);
        }
        $this->updatedAt = $updatedAt;
    }

    // GETTERS
    public function newsId(): int
    {
        return $this->newsId;
    }

    public function author(): string
    {
        return $this->author ?? '';
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