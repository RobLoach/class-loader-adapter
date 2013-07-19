<?php

/*
 * This file is part of the Class Loader Adapter package.
 *
 * (c) Rob Loach (http://robloach.net)
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace RobLoach\ClassLoaderAdapter\Krautoload;

use RobLoach\ClassLoaderAdapter\ClassLoaderInterface;
use Krautoload\Adapter_ClassLoader_Interface;
use Krautoload\Adapter_ClassLoader_Pluggable;
use Krautoload\ClassLoader_Interface;
use Krautoload\ClassLoader_Pluggable;

/**
 * Adaption layer for the Krautoload\ClassLoader_Pluggable,
 * based on Krautoload's own adapter layer.
 *
 * @see Krautoload\Adapter_ClassLoader_Pluggable
 */
class PluggableClassLoader implements ClassLoaderInterface
{
    /**
     * @var ClassLoader_Interface
     */
    protected $loader;

    /**
     * @var Adapter_ClassLoader_Interface
     */
    protected $adapter;

    /**
     * class map array to mimick getClassMap().
     *
     * @var array
     */
    protected $classMap = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->loader = new ClassLoader_Pluggable();
        $this->adapter = new Adapter_ClassLoader_Pluggable($this->loader);
    }

    /**
     * @inheritdoc
     */
    public function add($prefix, $paths)
    {
        $this->adapter->addPrefixPSR0($prefix, $paths);
    }

    /**
     * @inheritdoc
     */
    public function addMultiple(array $prefixes)
    {
        $this->adapter->addPrefixesPSR0($prefixes);
    }

    /**
     * Krautoload does not support getters.
     * We can either mimick them, or throw an exception.
     */
    public function getPrefixes()
    {
        throw new \RuntimeException('getPrefixes() is not supported by Krautoload.');
    }

    /**
     * @inheritdoc
     */
    public function addClassMap(array $classMap)
    {
        // Krautoload does not support getters, so we mimick them.
        if ($this->classMap) {
            $this->classMap = array_merge($this->classMap, $classMap);
        } else {
            $this->classMap = $classMap;
        }
        $this->loader->addClassMap($classMap);
    }

    /**
     * @inheritdoc
     */
    public function getClassMap()
    {
        return $this->classMap;
    }

    /**
     * @inheritdoc
     */
    public function register($prepend = FALSE)
    {
        $this->loader->register($prepend);
    }

    /**
     * @inheritdoc
     */
    public function unregister()
    {
        $this->loader->unregister();
    }

    /**
     * @inheritdoc
     */
    public function loadClass($class)
    {
        return $this->loader->loadClass($class);
    }

    /**
     * @inheritdoc
     */
    public function findFile($class)
    {
        $api = new \Krautoload\InjectedAPI_ClassFinder_FirstExistingFile($class);
        return $this->loader->apiFindFile($api, $class) ? $api->getFile() : FALSE;
    }
}
