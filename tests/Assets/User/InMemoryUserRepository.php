<?php

declare(strict_types=1);

namespace VasilDakov\SpecificationTests\Assets\User;

use VasilDakov\Specification\SpecificationInterface;

final class InMemoryUserRepository implements UserRepositoryInterface
{
    private array $users = [];

    public function __construct()
    {
        $this->users = [
            new User('USA', 25, 'Male'),
            new User('Germany', 30, 'Female'),
            new User('UK', 17, 'Male'),
            new User('Spain', 22, 'Female'),
            new User('Germany', 19, 'Male'),
            new User('Germany', 22, 'Male'),
        ];
    }

    public function findAll(): array
    {
        return $this->users;
    }

    /**
     * @return array<User>
     */
    public function findBySpecification(SpecificationInterface $specification): array
    {
        return array_filter(
            $this->users,
            fn(User $user): bool => $specification->isSatisfiedBy($user)
        );
    }
}
