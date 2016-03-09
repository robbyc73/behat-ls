<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkAwareInterface;
use Behat\Mink\Mink;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Context\Step\Given;
use Behat\Behat\Context\Step\When;
use Behat\Behat\Context\Step\Then;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface; // need to implement this to access container
//use Behat\Symfony2Extension\Driver\KernelDriver;


//
// Require 3rd-party libraries here:
//
   require_once '/var/www/html/behat-ls/vendor/autoload.php';
   require_once '/var/www/html/behat-ls/vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    private $output;
    protected $kernel;
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }


  /*  public function getSymfonyProfile()
    {
        $driver = $this->getSession()->getDriver();

        if (!$driver instanceof KernelDriver) {
            throw new UnsupportedDriverActionException(
                'You need to tag the scenario with '.
                '"@mink:symfony2". Using the profiler is not '.
                'supported by %s', $driver
            );
        }

        $profile = $driver->getClient()->getProfile();
        if (false === $profile) {
            throw new \RuntimeException(
                'The profiler is disabled. Activate it by setting '.
                'framework.profiler.only_exceptions to false in '.
                'your config'
            );
        }

        return $profile;
    }*/

    /**
     * @Given /^I have a file named "([^"]*)"$/
     */
    public function iHaveAFileNamed($file)
    {
      //  $this->getSession()->getPage();
        touch($file);
    }

    /**
     * @Given /^a directory named "([^"]*)"$/
     */
    public function aDirectoryNamed($directory)
    {
        mkdir($directory);
    }


    /**
     * @When /^I run "([^"]*)"$/
     */
    public function iRun($command)
    {
        exec($command, $this->output);
    }


    /**
     * @Given /^I should see "([^"]*)" in the output$/
     */
    public function iShouldSeeInTheOutput($string)
    {
       /* if (array_search($string, $this->output) === false) {
            throw new \Exception(sprintf('Did not see "%s" in the output', $string));
        }*/
        assertContains(
            $string,
            $this->output,
            sprintf('Did not see "%s" in the output', $string)
        );
    }

    /**
     * @BeforeScenario
     */
    public function moveIntoTestDir()
    {
        mkdir('test');
        chdir('test');
    }

    /**
     * @AfterScenario
     */
    public function moveOutOfTestDir()
    {
        chdir('..');
        if (is_dir('test')) {
            system('rm -r '.realpath('test'));
        }
    }

    /**
     * Sets Mink instance.
     *
     * @param \Behat\Mink\Mink $mink Mink session manager
     */
   /* public function setMink(Mink $mink)
    {
       $this->mink = $mink;
    }*/

    /**
     * Sets parameters provided for Mink.
     *
     * @param array $parameters
     */
   /* public function setMinkParameters(array $parameters)
    {
        // TODO: Implement setMinkParameters() method.
    }*/


    /**
     * @When /^I fill in search box with "([^"]*)"$/
     */
    public function iFillInTheSearchBoxWith($searchTerm)
    {
       // $profile = $this->getSymfonyProfile();
        //$container = $this->kernel->getContainer();
        return new When(sprintf(
            'I fill in "search" with "%s"',
            $searchTerm
        ));
    }

    /**
     * @When /^I fill in the search box with "([^"]*)"$/
     */
    public function iFillInTheSearchBoxWith2($searchTerm)
    {
        return new When(sprintf(
            'I fill in "search" with "%s"',
            $searchTerm
        ));
    }

    /**
     * @Given /^I press the search button$/
     */
    public function iPressTheSearchButton()
    {
        return new When('I press "searchButton"');
    }

    /**
     * @Given /^I wait for the suggestions box to appear$/
     */
    public function iWaitForTheSuggestionsBoxToAppear()
    {
        $this->getSession()->wait(
            5000,
            "$('.suggestions-results').children().length > 0"
        );
    }

    /**
     * @return \Behat\Mink\Element\DocumentElement
     */
    protected function getPage()
    {
        return $this->getSession()->getPage();
    }

    /**
     * Helps to use doctrine and entity manager.
     *
     * @param KernelInterface $kernelInterface Interface for getting Kernel.
     */
    /*public function setKernel(KernelInterface $kernelInterface)
    {
        $this->kernel = $kernelInterface;
    }*/


}
