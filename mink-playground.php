<?php

require __DIR__.'/vendor/autoload.php';

use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Session;
use Behat\Mink\Driver\Selenium2Driver;

//$driver = new GoutteDriver();
$driver = new Selenium2Driver;

$session = new Session($driver);

$session->start();

$session->visit('http://jurassicpark.wikia.com');

//echo "Status code: ". $session->getStatusCode() . "\n";
echo "Current URL: ". $session->getCurrentUrl() . "\n";

$page = $session->getPage();

echo "First 160 chars: ".substr($page->getText() , 0, 160) . "\n";

$element = $page->find('css', '.subnav-2 li a');

echo "The link text is: ". $element->getText() . "\n";

/*$selectorsHandler = $session->getSelectorsHandler();
$element = $page->find(
    'named',
    array(
        'link',
        $selectorsHandler->xpathLiteral('MinkExtension')
    )
);

echo sprintf(
    "The URL is '%s'\n",
    $element->getAttribute('href')
);*/

$session->stop();

?>