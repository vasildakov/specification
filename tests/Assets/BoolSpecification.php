<?php

declare(strict_types=1);

namespace Vasildakov\SpecificationTests\Assets;

use Vasildakov\Specification\Specification;

class BoolSpecification extends Specification
{
    private bool $bool;

    public function __construct(bool $bool)
    {
        $this->bool = $bool;
    }

    public function isSatisfiedBy($object): bool
    {
        return $this->bool;
    }

    public function whereExpression(string $alias): string
    {
        return $this->bool ? '1' : '0';
    }
}
