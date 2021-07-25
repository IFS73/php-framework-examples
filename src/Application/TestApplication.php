<?php

namespace Cda0521Framework\Application;

use Error;
use Exception;
use Cda0521Framework\Testing\Interfaces\TestCase;
use Cda0521Framework\Exception\AssertionFailedException;

/**
 * Handles running of unit tests
 */
class TestApplication
{
    /**
     * List of all test classes to execute
     * @var string[]
     */
    private array $testClasses;

    /**
     * Load config file and sets up services accordingly
     *
     * @param string $configFileName The path to the config file
     * @return void
     */
    public function setup(string $configFileName = null): void
    {
        // Active l'accès à la session pour pouvoir la réutiliser dans les contrôleurs ($_SESSION)
        session_start();

        $json = \file_get_contents('test.json');
        foreach (\json_decode($json, true) as $testClass) {
            $testClass = 'App\\Test\\' . $testClass;
            if (!class_exists($testClass)) {
                throw new Error('Class ' . $testClass . ' does not exist.');
            }
            // Si la classe de test n'implémente pas l'interface TestCase, il n'y a aucune garantie que la structure
            // attendue est respectée
            // Envoie une erreur invitant le client à implémenter l'interface TestCase dans sa classe
            if (!in_array(TestCase::class, class_implements($testClass))) {
                throw new Exception('Class ' . $testClass . ' must implement the TestCase interface.');
            }
            $this->testClasses []= $testClass;
        }
    }

    /**
     * Run the actual application
     *
     * @return void
     */
    public function run(): void
    {
        $failedTestCount = 0;

        // Exécute chaque cas de test
        foreach ($this->testClasses as $className) {
            $test = new $className();
            echo ('Testing ' . $test->getDescription() . '...');

            // Tente d'exécuter le test
            try {        
                $test->execute();
                // Si le test ne s'est jamais arrêté, c'est donc que toutes les assertions ont été vraies
                echo ' Passed.' . PHP_EOL;
            }
            // Si le test a rencontré une erreur, indique que le test a échoué et affiche le message d'erreur
            // puis passe au test suivant
            catch (AssertionFailedException $exception) {
                echo ' Failed.' . PHP_EOL;
                echo $exception . PHP_EOL . PHP_EOL;
                $failedTestCount += 1;
            }
        }

        // Affiche un résumé avec le nombre de tests réussis et le nombre de tests échoués
        echo 'Executed ' . count($this->testClasses) . ' tests.' . PHP_EOL;
        echo count($this->testClasses) - $failedTestCount . ' tests passed.' . PHP_EOL;
        echo $failedTestCount . ' tests failed.' . PHP_EOL;
    }
}
