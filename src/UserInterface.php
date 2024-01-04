<?php

namespace Vasildakov\Specification;

interface UserInterface
{
    public function getCountry(): string;

    public function getAge(): int;

    public function getGender(): string;
}
