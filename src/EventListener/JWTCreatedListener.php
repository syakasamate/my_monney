<?php
namespace App\EventListener;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Exception\DisabledException;

class JWTCreatedListener
{

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */

    public function onJWTCreated(JWTCreatedEvent $event)
    {
        /** @var $user \AppBundle\Entity\User */
        $user = $event->getUser();
        $user1=$user->getPartenaire();
         $id1=$user1->getId();
         $id2=$user->getPartenaire()->getId();

       if(($id1==$id2) && (!$user1->getUsers()[0]->getIsActive())){
       if(!$user->getIsActive()  ||$user->getIsActive() ){
        throw new  DisabledException('Users account is ');
         }
        }
       


        if(!$user->getIsActive()){
            throw new  DisabledException('Users account is ');
        }
        // merge with existing event data
        $payload = array_merge(
            $event->getData(),
            [
                'password' => $user->getPassword()
            ]
        );

        $event->setData($payload);
    }
}
?>