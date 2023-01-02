<?php

namespace App\Security\Voter;

use App\Entity\Customer;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerVoter extends Voter
{
    const VIEW = 'CUSTOMER_VIEW';
    const UPDATE = 'CUSTOMER_UPDATE';
    const DELETE = 'CUSTOMER_DELETE';

    public function __construct(private readonly Security $security)
    {

    }
    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html


        return in_array($attribute, [self::VIEW, self::UPDATE, self::DELETE,])
            && $subject instanceof Customer;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool {

        $user = $token->getUser();

        if (! $user instanceof UserInterface) {
            return false;
        }
        if ($this->security->isGranted('ROLE_ADMIN'))
            return true;
        // check if user has client
        if (null === $subject->getName()) return false;
        // ... (check conditions and return true to grant permission) ...

        // control des conditions et indique quelle méthode lancer
        return match ($attribute) {

            self::UPDATE,
            self::VIEW,
            self::DELETE => $this->canOperate($subject,  $user),
            default => false,
        };
    }
    private function canOperate(Customer $customer, User $user): bool
    {
        if ($this->security->isGranted('ROLE_ADMIN') or $customer === $user->getCustomer()) {
            return true;
        }
        return false;
    }

}