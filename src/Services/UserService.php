<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    // je crée une méthode dans mon Service

    // je crée un constructeur dans des paramètres pour construire ce que je veux
    //avec comme paramètre le userRepo ù il y a déjà des méthodes faites pas symfony
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {

    }
    // je crée une méthode findAll (trouver tous les user) un id dans l'entity User
    public function findAll(): array
    {
        //retourne à cette méthode. Une méthode qui est dans le userRepo et qui envoie un message
        return $this->userRepository->findAll();
//        dd($this->userRepository->findAll());
    }
    // je crée une méthode find (trouver) un id dans l'entity User
    public function find(int $id): ?User
    {
        //retourne à cette méthode. Une méthode qui est dans le userRepo
        return $this->userRepository->find($id);
    }
}