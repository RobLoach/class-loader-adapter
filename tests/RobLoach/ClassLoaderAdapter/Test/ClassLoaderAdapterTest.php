<?php

/*
 * This file is part of the Class Loader Adapter package.
 *
 * (c) Rob Loach (http://robloach.net)
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace RobLoach\ClassLoaderAdapter\Test;

use Composer\Autoload\ClassLoader\ClassLoader;

/**
 * Tests all adapter classes that Class Loader Adapter implements.
 */
class ClassLoaderAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerClassLoaderGetPrefixesClasses
     */
    public function testAddPrefix($class)
    {
        // Attempt adding the prefix to the loader.
        $loader = new $class();
        $loader->add('Foo', __DIR__.DIRECTORY_SEPARATOR.'Fixtures');
        $loader->add('Bar', __DIR__.DIRECTORY_SEPARATOR.'Fixtures');
        $loader->add('Bas', __DIR__.DIRECTORY_SEPARATOR.'Fixtures');

        // Retrieve the prefixes and see if the namespaces are available.
        $prefixes = $loader->getPrefixes();
        $this->assertArrayHasKey('Foo', $prefixes);
        $this->assertArrayNotHasKey('Foo1', $prefixes);
        $this->assertArrayHasKey('Bar', $prefixes);
        $this->assertArrayHasKey('Bas', $prefixes);
    }

    /**
     * @dataProvider providerClassLoaderGetPrefixesClasses
     */
    public function testAddPrefixes($class)
    {
        // Attempt adding the multiple prefixes to the loader.
        $loader = new $class();
        $prefixes = array(
          'Foo' => __DIR__.DIRECTORY_SEPARATOR.'Fixtures',
          'Bar' => __DIR__.DIRECTORY_SEPARATOR.'Fixtures',
          'Bas' => __DIR__.DIRECTORY_SEPARATOR.'Fixtures',
        );
        $loader->addMultiple($prefixes);

        // Retrieve the prefixes and see if the namespaces are available.
        $prefixes = $loader->getPrefixes();
        $this->assertArrayHasKey('Foo', $prefixes);
        $this->assertArrayNotHasKey('Foo1', $prefixes);
        $this->assertArrayHasKey('Bar', $prefixes);
        $this->assertArrayHasKey('Bas', $prefixes);
    }

    /**
     * @dataProvider providerClassLoaderPrefixClasses
     */
    public function testLoadClass($class, $index = 1)
    {
        // Add each prefix to the class loader.
        $loader = new $class();
        $loader->add("Foo{$index}\\", __DIR__.DIRECTORY_SEPARATOR.'Fixtures');
        $loader->add("Pearlike{$index}_", __DIR__.DIRECTORY_SEPARATOR.'Fixtures');

        // Put together an array of classes to attempt loading from.
        $attempts = array(
            "Foo{$index}\\Bar",
            "Pearlike{$index}_Foobar",
        );

        // Attempt loading the classes.
        foreach ($attempts as $attempt) {
            $loader->loadClass($attempt);
            $this->assertTrue(class_exists($attempt), sprintf('Failed to load the class %s using %s.', $attempt, $class));
        }
    }

    /**
     * @dataProvider providerClassLoaderPrefixClasses
     */
    public function testFindFile($class, $index = 1)
    {
        // Add each prefix to the class loader.
        $loader = new $class();
        $loader->addMultiple(array(
            "Foo{$index}\\" => __DIR__.DIRECTORY_SEPARATOR.'Fixtures',
            "Pearlike{$index}_" => __DIR__.DIRECTORY_SEPARATOR.'Fixtures',
        ));

        // Put together an array of classes to attempt loading from.
        $attempts = array(
            "Foo{$index}\\Bar",
            "Pearlike{$index}_Foobar",
        );

        // Attempt loading the classes.
        foreach ($attempts as $attempt) {
            $file = $loader->findFile($attempt);
            $this->assertContains('.php', $file, sprintf('Failed to find the file for class %s using %s.', $attempt, $class));
        }
    }

    /**
     * @dataProvider providerClassLoaderClassMapClasses
     */
    public function testAddClassMap($class, $index = 1)
    {
        // Add each prefix to the class loader.
        $loader = new $class();

        $map = array(
            "Foo{$index}\\Bar" => __DIR__."/Fixtures/Foo{$index}/Bar.php",
            "Pearlike{$index}_Foobar" => __DIR__."/Fixtures/Pearlike{$index}/Foobar.php",
        );
        $loader->addClassMap($map);

        // Put together an array of classes to attempt loading from.
        $attempts = array(
            "Foo{$index}\\Bar",
            "Pearlike{$index}_Foobar",
        );

        // Attempt loading the classes.
        foreach ($attempts as $attempt) {
            $file = $loader->findFile($attempt);
            $this->assertContains('.php', $file, sprintf('Failed to find the file for class %s using %s.', $attempt, $class));
        }
    }

    /**
     * Data provider to return class loaders that support prefixes,
     * and that support getPrefixes().
     */
    public function providerClassLoaderGetPrefixesClasses() {
        // Provide each test with a index number so it can change accordingly.
        $index = 1;

        // Give each test the class that needs testing.
        $tests[] = array('RobLoach\\ClassLoaderAdapter\\Composer\\ClassLoader', $index++);
        $tests[] = array('RobLoach\\ClassLoaderAdapter\\Symfony\\ClassLoader', $index++);
        $tests[] = array('RobLoach\\ClassLoaderAdapter\\Symfony\\UniversalClassLoader', $index++);

        return $tests;
    }

    /**
     * Data provider to return class loaders that support prefixes.
     */
    public function providerClassLoaderPrefixClasses() {
        // Provide each test with a index number so it can change accordingly.
        $index = 1;

        // Give each test the class that needs testing.
        $tests[] = array('RobLoach\\ClassLoaderAdapter\\Composer\\ClassLoader', $index++);
        $tests[] = array('RobLoach\\ClassLoaderAdapter\\Symfony\\ClassLoader', $index++);
        $tests[] = array('RobLoach\\ClassLoaderAdapter\\Symfony\\UniversalClassLoader', $index++);
        $tests[] = array('RobLoach\\ClassLoaderAdapter\\Krautoload\\PluggableClassLoader', $index++);
        $tests[] = array('RobLoach\\ClassLoaderAdapter\\Krautoload\\PluggableNamespaceInspector', $index++);

        return $tests;
    }

    /**
     * Data provider to return class loaders that support class maps.
     */
    public function providerClassLoaderClassMapClasses() {
        // Provide each test with a index number so it can change accordingly.
        $index = 1;

        // Give each test the class that needs testing.
        $tests[] = array('RobLoach\\ClassLoaderAdapter\\Composer\\ClassLoader', $index++);
        $tests[] = array('RobLoach\\ClassLoaderAdapter\\Symfony\\MapClassLoader', $index++);
        $tests[] = array('RobLoach\\ClassLoaderAdapter\\Krautoload\\PluggableClassLoader', $index++);
        $tests[] = array('RobLoach\\ClassLoaderAdapter\\Krautoload\\PluggableNamespaceInspector', $index++);

        return $tests;
    }
}
