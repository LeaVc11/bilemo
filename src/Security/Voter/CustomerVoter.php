<?php

namespace App\Security\Voter;
// au chargement d'une page, le container de service va te préparer énormément de chose pour
// que tu puisses les appeler facilement il te suffit de taper dans la console
// la commande php bin/console debug:container pour voir tout ce qu'il a préparé pour toi
// si dans cette grande liste tu fais un ctrl+f pour chercher la classe que tu appelles
//  ici avec un use tu verras bien Symfony\Component\Security\Core\Authorization\Voter\Voter
// quand tu vas regarder cette classe en cliquant dessus tu t'aperçois qu'elle a besoin de la TokenInterface et
// des trucs bizarre $subject ou encore $attributes (on verra plus tard)
// avec la methode supports le voter va déterminer si $attributes et $subject sont
// supportés par le Voter. Mais on s'en moque, c'est à cette classe de faire le travail
// de vérification, toi tu vas simplement l'utiliser. D'ailleurs tu as surement du
// demandé au maker de t'écrire ton CustomerVoter, donc il te prépare tout pour faire
// fonctionner avec Symfony\Component\Security\Core\Authorization\Voter\Voter;


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
    const VIEW = 'VIEW';

    // tu nommes des droits DELETE
    const UPDATE = 'UPDATE';

    // tu nommes des droits DELETE
    const DELETE = 'DELETE';


    private  $security;

    public function __construct(Security $security)
    {
        // le constructeur de CustomerVoter tu lui dis
        // que ta classe aura une propriété $security
        // qui provient du SecurityBundle que tu utilises plus bas
        // pour le is_granted dans voteOnAttribute etc
        $this->security = $security;
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
            && $subject instanceof \App\Entity\Customer;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool {
        // ici récupère le user connecté
        $customer = $token->getUser();

        if (!$customer instanceof Customer) {
//            si le user en session n'est pas une instance de la classe Customer on sort
            return false;
        }
// je vérifie si l'utilisateur est admin
        if ($this->security->isGranted('ROLE_ADMIN'))
            return true;
        $user = $subject;

        // control des conditions et indique quelle méthode lancer
        return match ($attribute) {
//            pour le cas ou $attribut match avec self::VIEW donc 'VIEW' lance la methode canView de cette classe
            self::VIEW => $this->canView($customer, $user),
//            pour le cas ou $attribut match avec self::UPDATE ou self::DELETE lance la methode canEditOrDelete
            self::UPDATE, self::DELETE => $this->canEditOrDelete($customer, $user),
//            gérer l'exception au cas où
            default => throw new \LogicException('This code should not be reached!')
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
//    private function canView(Customer $customer, User $user): bool {
//
//        if ($this->canEditOrDelete($customer, $user)) {
//            return true;
//        }
//        return false;
//    }
//
//    private function canEditOrDelete(Customer $customer, User $user): bool {
//        // L'admin peut modifier
//        return $user === $customer->getUser();
//    }

}