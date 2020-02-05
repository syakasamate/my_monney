<?php
namespace App\Application\ApiPlatform\EventListener;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Disable ApiPlatform deserialize listener.
 */
class RemoveTagsOnOriginalDeserializeListener implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container
            ->findDefinition('api_platform.listener.request.deserialize')
            ->clearTags()
        ;
    }
}

?>