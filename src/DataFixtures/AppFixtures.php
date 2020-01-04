<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
        public function __construct(UserPasswordEncoderInterface $encoder)
        {
        $this->encoder = $encoder;
        }
   
        
        public function load(ObjectManager $manager)
        {
        $roleSupAdmin= new Roles();
        $roleSupAdmin->setLibelle("Role_sup_ADMIN");
        $manager->persist($roleSupAdmin);
        
        $roleAdmin= new Roles();
        $roleAdmin->setLibelle("Role_ADMIN");
        $manager->persist($roleAdmin);
        $roleCaissier= new Roles();
        $roleCaissier->setLibelle("Role_Caissier");
        $manager->persist($roleCaissier);
        $manager->flush();
        
        $this->addReference('role-superadmin', $roleSupAdmin);
        $this->addReference('role-admin', $roleAdmin);
        $this->addReference('role-caissier', $roleCaissier);
        
        $role_superadmin=$this->getReference('role-superadmin');
        $role_admin=$this->getReference('role-admin');
        $role_caissier=$this->getReference('role-caissier');
        
        $user=new User();
        $user->setUsername("syaka015@gmail.com")
        ->setIsActive(true)
        ->setPassword($this->encoder->encodePassword($user,"syaka"))
        ->setRoles(["ROLE_SUPER_ADMIN"])
        ->setRole($role_superadmin);
        
        $manager->persist($user);
        $manager->flush();
        
        }
        
}
