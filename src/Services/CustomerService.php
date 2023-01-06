<?php

namespace App\Services;

use App\Entity\Customer;
use App\Entity\User;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;


class CustomerService
{
    // CONTAINER DE SERVICE

//c\'est le hangar ou tu vas ranger les palettes et quand tu vas avoir besoin de remplir un rayon, tu vas aller chercher une palette.
// Avec uniquement de l'injection de dépendances, tu es toute seule à aller chercher la palette et faire la mise en rayon. (fatiguant)
//symfony console debug:autowiring
//vec Autowiring, c'est comme si tu avais un magasinier qui t'apportes la palette dont tu as besoin du coup plus facile pour, la mise en rayon ca va plus vite!
//je fais quand même la mise en rayon, mais le c\'est le magasinier qui fait les allers-retours pour te livrer les palettes
//Le magasinier sait : où c'est rangé, comment c'est rangé, comment te les apporter rapidement et il est capable de gérer son hangar
    // je crée une méthode dans mon Service

    // je crée un constructeur dans des paramètres pour construire ce que je veux
    //avec comme paramètre le customerRepo ù il y a déjà des méthodes faites pas symfony
    public function __construct(
        private readonly CustomerRepository     $customerRepository,
        private readonly TagAwareCacheInterface $cache,
        private readonly SerializerInterface    $serializer,

    )
    {

    }

    // je crée une méthode findAll (trouver tous les customer).

    public function cache(Request $request)
    {
        //chercher sur la route une page avec un numéro
        // avec une valeur par défaut
        //
        $page = (int)$request->get(key: 'page', default: 1);
        //chercher sur la route avec une limit avec un numéro
        //avec une valeur par défaut
        $limit = (int)$request->get(key: 'limit', default: 3);
        //j’ai créé ici un identifiant
        //Il est construit ici avec le mot getAllCustomers
        $idCache = "getAllCustomers-" . $page . "-" . $limit;

        return $this->cache->get($idCache, function (ItemInterface $item) use ($page, $limit) {
            echo("customer");
            $item->tag("customersCache");
            return $this->findAllWithPagination($page, $limit);
        });
    }
    // je crée une méthode find (trouver UN customer).
    public function find(int $id): ?Customer
    {
        return $this->customerRepository->find($id);
    }
     //je crée une méthode cache (mise en place d’un système de cache).

    public function findAllWithPagination($page, $limit)
    {
        // Une méthode qui est dans le customerRepo et qui envoie un tableau d'objets
        // Avec 2 paramètres page et limit
        return $this->customerRepository->findAllWithPagination($page, $limit);

    }

    /**
     * @throws InvalidArgumentException
     */
    public function create(Request $request, User $user)
    {

        $this->cache->invalidateTags(["customerCache"]);
        $customer = $this->serializer->deserialize(
            $request->getContent(), Customer::class, 'json'
        );
        $this->verifyCustomer($customer);
//        dd($customer);
        $customer->setUser($user);
//dd($customer);
        return $customer;
    }

    private function verifyCustomer($customer): bool
    {
        //Il y a  pas de user ds la bdd avec email que tu reçois de la requête tu renvoie true
        if (!$this->customerRepository->findOneBy(['email' => $customer->getEmail()])) {
//            dd('c\'est bon');
            return true;
        }
        // par défaut tu renvoie false
//        dd('c\'est pas bon');
        return false;
    }


}