<?php

namespace App\Security\Voter;

use Exception;
use App\Entity\User;

use App\Entity\Compte;
use App\Entity\Depot;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DepotVoter extends Voter
{

    const ROLE_SUPER_ADMIN ='ROLE_SUPER_ADMIN';
    const  ROLE_ADMIN='ROLE_ADMIN';
    const ROLE_CAISSIER='ROLE_CAISSIER';
    private $security;
    private $decisionManager;
    protected $tokenStorage;


    public function __construct(Security $security ,AccessDecisionManagerInterface $decisionManager,
    TokenStorageInterface $tokenStorage)
    {
        $this->decisionManager = $decisionManager;
        $this->tokenStorage = $tokenStorage;
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['EDIT','ADD','VIEW'])
            && $subject instanceof   Depot;
    }
    /** @var User $subject */
     /**
        * @param User $subject
        */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, array(self::ROLE_SUPER_ADMIN,self::ROLE_ADMIN,self::ROLE_CAISSIER))) {
            return true;
        }
        
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }
        
        throw new \Exception(sprintf('Acces non Autoriser!!'));

    }
}
