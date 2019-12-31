<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractController
{
    
     public function register(Request $request, UserPasswordEncoderInterface $encoder)
        {
            $em = $this->getDoctrine()->getManager();
    
            $username = $request->request->get('username');
            $password = $request->request->get('password');
            $roles = $request->request->get('roles');
    
            if (!$roles) {
                $roles = json_encode([]);
            }
    
            $user = new User($username);
            $user->setPassword($encoder->encodePassword($user, $password));
            $user->setRoles(($roles));
            $em->persist($user);
            $em->flush();
    
            return new Response(sprintf('User %s successfully created', $user->getUsername()));
        }
}
