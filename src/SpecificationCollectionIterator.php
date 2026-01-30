<?php

declare(strict_types=1);

namespace Vasildakov\Specification;

use Iterator;

/**
 * @template-implements Iterator<non-negative-int, SpecificationInterface>
 */
class SpecificationCollectionIterator implements Iterator
{
    /**
     * @var list<Specification>
     */
    private readonly array $specifications;

    /**
     * @var non-negative-int
     */
    private int $position = 0;

    public function __construct(SpecificationCollection $specifications)
    {
        $this->specifications = $specifications->asArray();
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->specifications[$this->position]);
    }

    /**
     * @return non-negative-int
     */
    public function key(): int
    {
        return $this->position;
    }

    public function current(): SpecificationInterface
    {
        assert(isset($this->specifications[$this->position]));

        return $this->specifications[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }
}
