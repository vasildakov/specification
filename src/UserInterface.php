<?php

namespace Vasildakov\Specification;

interface UserInterface
{
    public function getCountry(): string;

    public function getAge(): int;

    public function getGender(): string;

    public function isMale(): bool;

    public function isFemale(): bool;

    public function isAdult(): bool;
}
