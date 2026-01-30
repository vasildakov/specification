<?php

declare(strict_types=1);

namespace VasilDakov\SpecificationTests\Assets\User;

use VasilDakov\Specification\UserInterface;

final class User implements UserInterface
{
    public function __construct(
        private string $country,
        private int $age,
        private string $gender
    ) {
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function isMale(): bool
    {
        return $this->getGender() == 'Male';
    }

    public function isFemale(): bool
    {
        return $this->getGender() == 'Female';
    }

    public function isAdult(): bool
    {
        return $this->getAge() >= 18;
    }
}
