<?php

namespace App\Security\Voter;

use App\Entity\Customer;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Bundle\SecurityBundle\Security;


class CustomerVoter extends Voter
{
    const VIEW = 'VIEW';
    const UPDATE = 'UPDATE';
    const DELETE = 'DELETE';

    private  $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::VIEW, self::UPDATE, self::DELETE,])
            && $subject instanceof \App\Entity\Customer;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool {
        $customer = $token->getUser();

        if (!$customer instanceof Customer) {
            return false;
        }
// je vérifie si l'utilisateur est admin
      if ($this->security->isGranted('ROLE_ADMIN'))
          return true;
        $user = $subject;
        return match ($attribute) {
            self::VIEW => $this->canView($customer, $user),
            // je vérifie si je peux mettre à jour ou supprimer
            self::UPDATE, self::DELETE => $this->canEditOrDelete($customer, $user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }
    private function canView(Customer $customer, User $user): bool {

        if ($this->canEditOrDelete($customer, $user)) {
            return true;
        }
        return false;
    }

    private function canEditOrDelete(Customer $customer, User $user): bool {
        // L'admin peut modifier
        return $user === $customer->getUser();
    }

}
