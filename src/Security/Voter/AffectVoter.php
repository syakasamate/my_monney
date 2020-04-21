<?php

namespace App\Security\Voter;

use App\Entity\AffectCompte;
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

class AffectVoter extends Voter
{

    const ROLE_PARTENAIRE ='ROLE_PARTENAIRE';
    const  ROLE_ADMIN_PARTENAIRE='ROLE_ADMIN_PARTENAIRE';
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
            && $subject instanceof   AffectCompte;
    }
    /** @var AffectCompte $subject */
     /**
        * @param AffectCompte $subject
        */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, array(self::ROLE_ADMIN_PARTENAIRE,self::ROLE_PARTENAIRE))) {
            return true;
        }
        
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }
        
        // ... (check conditions and return true to grant permission) ...
        
      
    }
}
