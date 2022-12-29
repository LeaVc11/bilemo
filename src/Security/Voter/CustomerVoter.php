<?php

namespace App\Security\Voter;

use App\Entity\Customer;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Bundle\SecurityBundle\Security;

// le truc à comprendre c'est que cette classe avec ses méthodes ne fait que dire oui ou non
// dis-toi que c'est un if un peu plus compliqué

class CustomerVoter extends Voter
{
    // ici, tu vas indiquer ce que tu accordes comme authorization pour
    // des raisons de clarté, tu vas mettre des noms qui évoquent l'action
    // tu nommes des droits VIEW
    const VIEW = 'CUSTOMER_VIEW';

    // tu nommes des droits DELETE
    const UPDATE = 'CUSTOMER_UPDATE';

    // tu nommes des droits DELETE
    const DELETE = 'CUSTOMER_DELETE';

    public function __construct(private readonly Security $security)
    {
        // le constructeur de CustomerVoter tu lui dis
        // que ta classe aura une propriété $security
        // qui provient du SecurityBundle que tu utilises plus bas
        // pour le is_granted dans voteOnAttribute etc

    }
    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html

        // pour comprendre cette méthode fait un dd($attribute); et demandes toi ce que fait in_array() de php
        // mais ça renvoi true si $attributes est dans le tableau passé en deuxième paramètre => https://www.php.net/manual/fr/function.in-array.php
        return in_array($attribute, [self::VIEW, self::UPDATE, self::DELETE,])
            // tu peux aussi faire un dd($subject); comme ça tu vois tout de suite à quoi correspondent les nommages
            // doit renvoyer true aussi si $subject est bien une instance de Customer mais on peut deviner ce qu'il représente: ton Customer
            && $subject instanceof Customer;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool {
        // ici récupère le customer connecté
        $customer = $token->getUser();

        if (!$customer instanceof Customer) {
//            si le user en session n'est pas une instance de la classe Customer on sort
            return false;
        }
// je vérifie si l'utilisateur est admin
        if ($this->security->isGranted('ROLE_ADMIN'))
            return true;
        // check if user has client
        if (null === $subject->getName()) return false;
        // ... (check conditions and return true to grant permission) ...

        // control des conditions et indique quelle méthode lancer
        return match ($attribute) {

            self::UPDATE,
            self::VIEW,
            self::DELETE => $this->canOperate($subject, $customer),
            default => false,
        };
    }
//    moi j'avais fait une seule méthode canOperate elle donnerait ça pour toi
    private function canOperate(Customer $customer, User $user): bool
    {
        // si il y a le role_admin sur ton user en session ou que le $customer est le proriétaire alors return true
        if ($this->security->isGranted('ROLE_ADMIN') or $customer === $user->getCustomer()) {
            return true;
        }
        // sinon sort de là
        return false;
    }

}