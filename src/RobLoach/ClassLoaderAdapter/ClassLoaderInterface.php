<?php

/*
 * This file is part of the Class Loader Adapter package.
 *
 * (c) Rob Loach (http://robloach.net)
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace RobLoach\ClassLoaderAdapter;

/**
 * Interface to allow switching between different third-party class loaders.
 *
 * @author Rob Loach (http://robloach.net)
 */
interface ClassLoaderInterface
{
    /**
     * Registers a set of classes, merging with any others previously set.
     *
     * @param string       $prefix  The classes prefix
     * @param array|string $paths   The location(s) of the classes
     */
    public function add($prefix, $paths);

    /**
     * Add multiple sets of classes.
     *
     * @param array $prefixes Prefixes to add.
     */
    public function addMultiple(array $prefixes);

    /**
     * Retrieves the array of Prefixes that have been registered.
     *
     * @return array An array of namespace prefixes.
     */
    public function getPrefixes();

    /**
     * Add a class map to the class loader.
     *
     * This will not work on class loaders that do not support it.
     */
    public function addClassMap(array $classMap);

    /**
     * Retrieve the class map for the loader, if available.
     */
    public function getClassMap();

    /**
     * Registers this instance as an autoloader.
     *
     * @param bool $prepend Whether to prepend the autoloader or not.
     */
    public function register($prepend = false);

    /**
     * Unregisters this instance as an autoloader.
     */
    public function unregister();

    /**
     * Loads the given class or interface.
     *
     * @param  string    $class The name of the class
     * @return bool|null True if loaded, null otherwise
     */
    public function loadClass($class);

    /**
     * Finds the path to the file where the class is defined.
     *
     * @param string $class The name of the class.
     *
     * @return string|false The path if found, false otherwise.
     */
    public function findFile($class);
}
