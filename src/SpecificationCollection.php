<?php

declare(strict_types=1);

namespace VasilDakov\Specification;

use Countable;
use IteratorAggregate;

/**
 * @template-implements IteratorAggregate<non-negative-int, Specification>
 *
 * @immutable
 */
final class SpecificationCollection implements IteratorAggregate, Countable
{
    /**
     * @var list<SpecificationInterface>
     */
    private array $specifications;

    /**
     * @param array $specifications
     * @return SpecificationCollection
     */
    public static function fromArray(array $specifications): self
    {
        assert(array_is_list($specifications));

        return new self(...$specifications);
    }

    private function __construct(SpecificationInterface ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function add(SpecificationInterface $specification): void
    {
        $this->specifications[] = $specification;
    }

    /**
     * @return list<SpecificationInterface>
     */
    public function asArray(): array
    {
        return $this->specifications;
    }

    /**
     * @return SpecificationCollectionIterator<non-negative-int, Specification>
     */
    public function getIterator(): SpecificationCollectionIterator
    {
        return new SpecificationCollectionIterator($this);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->specifications);
    }
}
