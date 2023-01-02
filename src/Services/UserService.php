<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {

    }
    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }
    public function find(int $id): ?User
    {
        return $this->userRepository->find($id);
    }
}