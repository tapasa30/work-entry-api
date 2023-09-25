<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity;

interface SoftDeleteInterface
{
    public function getDeletedAt(): ?\DateTimeInterface;
    public function setDeletedAt(\DateTimeInterface $deletedAt): void;
}