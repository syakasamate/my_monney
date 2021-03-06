<?php

namespace App\Security\Voter;

use App\Entity\Compte;
use Exception;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserVoter extends Voter
{

    const ROLE_SUPER_ADMIN ='ROLE_SUPER_ADMIN';
    const  ROLE_ADMIN='ROLE_ADMIN';
    const ROLE_CAISSIER='ROLE_CAISSIER';
    const ROLE_PARTENAIRE="ROLE_PARTENAIRE";
    const ROLE_USER_PARTENAIRE="ROLE_USER_PARTENAIRE";
    const ROLE_ADMIN_PARTENAIRE="ROLE_ADMIN_PARTENAIRE";
    const NON="Acces Non Autorisé!!!";
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
            && $subject instanceof   User;
    }
    /** @var User $subject */
     /**
        * @param User $subject
        */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {

     
        if($this->tokenStorage->getToken()->getRoles()[0]==self::ROLE_SUPER_ADMIN){
            if ($subject->getRoles()[0]==self::ROLE_USER_PARTENAIRE || $subject->getRoles()[0]==self::ROLE_ADMIN_PARTENAIRE)
            {
                throw new \Exception(sprintf(self::NON));
            }
        }
        if($this->tokenStorage->getToken()->getRoles()[0]==self::ROLE_CAISSIER){
            throw new \Exception(sprintf(self::NON));
        }
        
        elseif($this->tokenStorage->getToken()->getRoles()[0]==self::ROLE_ADMIN){
            if ($subject->getRoles()[0]==self::ROLE_SUPER_ADMIN || $subject->getRoles()[0]==self::ROLE_ADMIN||
             $subject->getRoles()[0]==self::ROLE_USER_PARTENAIRE|| $subject->getRoles()[0]==self::ROLE_ADMIN_PARTENAIRE){
                throw new \Exception(sprintf(self::NON));

        }



                
        }elseif($this->tokenStorage->getToken()->getRoles()[0]==self::ROLE_PARTENAIRE){
            if ($subject->getRoles()[0]==self::ROLE_SUPER_ADMIN || $subject->getRoles()[0]==self::ROLE_ADMIN|| $subject->getRoles()[0]==self::ROLE_PARTENAIRE
            || $subject->getRoles()[0]==self::ROLE_CAISSIER)
            {
                throw new \Exception(sprintf(self::NON));
            }
        }
        
        elseif($this->tokenStorage->getToken()->getRoles()[0]==self::ROLE_USER_PARTENAIRE){
            if ($subject->getRoles()[0]==self::ROLE_SUPER_ADMIN || $subject->getRoles()[0]==self::ROLE_ADMIN|| $subject->getRoles()[0]==self::ROLE_PARTENAIRE
            || $subject->getRoles()[0]==self::ROLE_CAISSIER || $subject->getRoles()[0]==self::ROLE_ADMIN_PARTENAIRE )
            {
                throw new \Exception(sprintf(self::NON));
            }
        }


        
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }
        
       
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {


            case'EDIT':
            if ($this->security->isGranted(self::ROLE_ADMIN)|| $this->security->isGranted(self::ROLE_SUPER_ADMIN)|| $this->security->isGranted(self::ROLE_PARTENAIRE ) 
            ||$this->security->isGranted(self::ROLE_ADMIN_PARTENAIRE))
            {
                return true;
            }
            break;


            case'ADD':
                if ($this->security->isGranted(self::ROLE_ADMIN)|| $this->security->isGranted(self::ROLE_SUPER_ADMIN)|| $this->security->isGranted(self::ROLE_PARTENAIRE ) 
            ||$this->security->isGranted(self::ROLE_ADMIN_PARTENAIRE))
            {
                return true;
            }
            break;

            case'VIEW':
                if ($this->security->isGranted(self::ROLE_ADMIN)|| $this->security->isGranted(self::ROLE_SUPER_ADMIN)|| $this->security->isGranted(self::ROLE_PARTENAIRE ) 
            ||$this->security->isGranted(self::ROLE_ADMIN_PARTENAIRE))
            {
                return true;
            }
            break;

            return false;

            default:

        break;
            
        }
      
    }
}
