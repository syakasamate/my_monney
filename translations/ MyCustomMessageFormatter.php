
<?php

use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;

$translator = new Translator('fr_FR');
$translator->addLoader('array', new ArrayLoader());
$translator->addResource('array', [
    'Account is disabled.' => 'ce compte est desctiver !',
], 'fr_FR');

var_dump($translator->trans('Account is disabled.'));
   
?>