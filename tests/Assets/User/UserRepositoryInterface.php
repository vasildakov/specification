<?php

declare(strict_types=1);

namespace VasilDakov\SpecificationTests\Assets\User;

interface UserRepositoryInterface
{
    /**
     * @return array<User>
     */
    public function findAll(): array;
}
