<?php
namespace Consolidation\AnnotationCommand;

class CommandFileDiscoveryTests extends \PHPUnit_Framework_TestCase
{
    function testCommandDiscovery()
    {
        $discovery = new CommandFileDiscovery();
        $discovery
          ->setSearchPattern('*CommandFile.php')
          ->setSearchLocations(['alpha']);

        chdir(__DIR__);
        $commandFiles = $discovery->discover('.', 'Consolidation\TestUtils');

        $commandFilePaths = array_keys($commandFiles);
        $commandFileNamespaces = array_values($commandFiles);

        // Ensure that the command files that we expected to
        // find were all found.
        $this->assertContains('./src/TestCommandFile.php', $commandFilePaths);
        $this->assertContains('./src/alpha/AlphaCommandFile.php', $commandFilePaths);
        $this->assertContains('./src/alpha/Include/IncludedCommandFile.php', $commandFilePaths);

        // Make sure that there are no additional items found.
        $this->assertEquals(3, count($commandFilePaths));

        // Ensure that the command file namespaces that we expected
        // to be generated all match.
        $this->assertContains('Consolidation\TestUtils\TestCommandFile', $commandFileNamespaces);
        $this->assertContains('Consolidation\TestUtils\alpha\AlphaCommandFile', $commandFileNamespaces);
        $this->assertContains('Consolidation\TestUtils\alpha\Include\IncludedCommandFile', $commandFileNamespaces);

        // We do not need to test for additional namespace items, because we
        // know that the length of the array_keys must be the same as the
        // length of the array_values.
    }
}
