<?php

namespace App\Security\Voter;

use Exception;
use App\Entity\User;

use App\Entity\Compte;
use App\Entity\Depot;
use App\Entity\Partenaire;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PartenaireVoter extends Voter
{

    const ROLE_SUPER_ADMIN ='ROLE_SUPER_ADMIN';
    const  ROLE_ADMIN='ROLE_ADMIN';
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
            && $subject instanceof   Partenaire;
    }
    /** @var  Partenaire $subject */
     /**
        * @param  Partenaire $subject
        */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, array(self::ROLE_SUPER_ADMIN,self::ROLE_ADMIN))) {
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
