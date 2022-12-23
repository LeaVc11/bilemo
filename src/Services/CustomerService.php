<?php

namespace App\Services;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use JetBrains\PhpStorm\NoReturn;

class CustomerService
{

    // je crée une méthode dans mon Service

    // je crée un constructeur dans des paramètres pour construire ce que je veux
    //avec comme paramètre le customerRepo ù il y a déjà des méthodes faites pas symfony
    public function __construct(
        private readonly CustomerRepository $customerRepository
    )
    {

    }
    // je crée une méthode findAll (trouver tous les customer) un id dans l'entity Customer
   public function findAll(): array
    {
        //retourne à cette méthode. Une méthode qui est dans le customerRepo et qui envoie un message
      return $this->customerRepository->findAll();
//        dd($this->customerRepository->findAll());
    }
    // je crée une méthode find (trouver) un id dans l'entity Customer
    public function find(int $id): ?Customer
    {
    //retourne à cette méthode. Une méthode qui est dans le customerRepo
        return $this->customerRepository->find($id);
    }
}