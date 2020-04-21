<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Roles;
use App\Entity\Tarif;
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
       /* $roleSupAdmin= new Roles();
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
        ->setRole($role_superadmin)
        ->setNom("syaka");
        $manager->persist($user);
        $manager->flush();*/
        $tarif= new Tarif();
        $tarif->setBorneinferieur(1)
        ->setBorneSuperieur(500)
        ->setValeur(50);
        $manager->persist($tarif);
        $manager->flush();
     
        $tarif1= new Tarif();
        $tarif1->setBorneinferieur(5001)
        ->setBorneSuperieur(1500)
        ->setValeur(100);
        $manager->persist($tarif1);
        $manager->flush();

        $tarif2= new Tarif();
        $tarif2->setBorneinferieur(15001)
        ->setBorneSuperieur(3000)
        ->setValeur(200);
        $manager->persist($tarif2);
        $manager->flush();

        $tarif3= new Tarif();
        $tarif3->setBorneinferieur(3001)
        ->setBorneSuperieur(5000)
        ->setValeur(400);
        $manager->persist($tarif3);
        $manager->flush();

        $tarif4= new Tarif();
        $tarif4->setBorneinferieur(5001)
        ->setBorneSuperieur(10000)
        ->setValeur(700);
        $manager->persist($tarif4);
        $manager->flush();

        $tarif5= new Tarif();
        $tarif5->setBorneinferieur(10001)
        ->setBorneSuperieur(15000)
        ->setValeur(1100);
        $manager->persist($tarif5);
        $manager->flush();

        $tarif6= new Tarif();
        $tarif6->setBorneinferieur(15001)
        ->setBorneSuperieur(20000)
        ->setValeur(1300);
        $manager->persist($tarif6);
        $manager->flush();

        $tarif7= new Tarif();
        $tarif7->setBorneinferieur(20001)
        ->setBorneSuperieur(25000)
        ->setValeur(1500);
        $manager->persist($tarif7);
        $manager->flush();

        $tarif8= new Tarif();
        $tarif8->setBorneinferieur(250001)
        ->setBorneSuperieur(30000)
        ->setValeur(1700);
        $manager->persist($tarif8);
        $manager->flush();

        $tarif9= new Tarif();
        $tarif9->setBorneinferieur(30001)
        ->setBorneSuperieur(50000)
        ->setValeur(18000);
        $manager->persist($tarif9);
        $manager->flush();

        $tarif10= new Tarif();
        $tarif10->setBorneinferieur(50001)
        ->setBorneSuperieur(60000)
        ->setValeur(2300);
        $manager->persist($tarif10);
        $manager->flush();

        $tarif11= new Tarif();
        $tarif11->setBorneinferieur(60001)
        ->setBorneSuperieur(75000)
        ->setValeur(2700);
        $manager->persist($tarif11);
        $manager->flush();

        $tarif12= new Tarif();
        $tarif12->setBorneinferieur(75001)
        ->setBorneSuperieur(100000)
        ->setValeur(3200);
        $manager->persist($tarif12);
        $manager->flush();


        $tarif13= new Tarif();
        $tarif13->setBorneinferieur(100001)
        ->setBorneSuperieur(125000)
        ->setValeur(3600);
        $manager->persist($tarif13);
        $manager->flush();


        $tarif14= new Tarif();
        $tarif14->setBorneinferieur(125001)
        ->setBorneSuperieur(150000)
        ->setValeur(4000);
        $manager->persist($tarif14);
        $manager->flush();

        $tarif15= new Tarif();
        $tarif15->setBorneinferieur(150001)
        ->setBorneSuperieur(200000)
        ->setValeur(4800);
        $manager->persist($tarif15);
        $manager->flush();

        $tarif16= new Tarif();
        $tarif16->setBorneinferieur(200001)
        ->setBorneSuperieur(250000)
        ->setValeur(6350);
        $manager->persist($tarif16);
        $manager->flush();

        $tarif17= new Tarif();
        $tarif17->setBorneinferieur(250001)
        ->setBorneSuperieur(300000)
        ->setValeur(8050);
        $manager->persist($tarif1);
        $manager->flush();

        $tarif18= new Tarif();
        $tarif18->setBorneinferieur(300001)
        ->setBorneSuperieur(350000)
        ->setValeur(8450);
        $manager->persist($tarif18);
        $manager->flush();


        $tarif19= new Tarif();
        $tarif19->setBorneinferieur(350001)
        ->setBorneSuperieur(400000)
        ->setValeur(9750);
        $manager->persist($tarif19);
        $manager->flush();

        $tarif20= new Tarif();
        $tarif20->setBorneinferieur(400001)
        ->setBorneSuperieur(600000)
        ->setValeur(3200);
        $manager->persist($tarif20);
        $manager->flush();


        $tarif21= new Tarif();
        $tarif21->setBorneinferieur(600001)
        ->setBorneSuperieur(750000)
        ->setValeur(13550);
        $manager->persist($tarif21);
        $manager->flush();


      
        $tarif22= new Tarif();
        $tarif22->setBorneinferieur(750001)
        ->setBorneSuperieur(1000000)
        ->setValeur(21650);
        $manager->persist($tarif22);
        $manager->flush();


        $tarif23= new Tarif();
        $tarif23->setBorneinferieur(1000001)
        ->setBorneSuperieur(1250000)
        ->setValeur(24200);
        $manager->persist($tarif23);
        $manager->flush();


        $tarif24= new Tarif();
        $tarif24->setBorneinferieur(1250001)
        ->setBorneSuperieur(1500000)
        ->setValeur(31850);
        $manager->persist($tarif24);
        $manager->flush();


        $tarif25= new Tarif();
        $tarif25->setBorneinferieur(1500001)
        ->setBorneSuperieur(2000000)
        ->setValeur(35650);
        $manager->persist($tarif25);
        $manager->flush();
        
        }
        
}
