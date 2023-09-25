<?php

declare(strict_types=1);

namespace App\WorkEntry\Application\Factory;

use App\User\Domain\Entity\User;
use App\WorkEntry\Domain\Entity\WorkEntry;

class CreateWorkEntryEntityFactory
{
    public function build(User $user, \DateTime $startDate): WorkEntry
    {
        $workEntry = new WorkEntry();

        $workEntry->setUser($user);
        $workEntry->setStartDate($startDate);
        $workEntry->setCreatedAt(new \DateTime());

        return $workEntry;
    }
}