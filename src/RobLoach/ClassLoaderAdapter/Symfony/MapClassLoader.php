<?php

/*
 * This file is part of the Class Loader Adapter package.
 *
 * (c) Rob Loach (http://robloach.net)
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace RobLoach\ClassLoaderAdapter\Symfony;

use RobLoach\ClassLoaderAdapter\ClassLoaderInterface;
use Symfony\Component\ClassLoader\MapClassLoader as BaseClassLoader;

/**
 * Adaption layer for the Symfony MapClassLoader.
 *
 * @see Symfony\Component\ClassLoader\MapClassLoader
 */
class MapClassLoader extends BaseClassLoader implements ClassLoaderInterface
{
    /**
     * Since $this->map is set as a private variable, adopt around its use.
     */
    protected $classMap = array();

    /**
     * Constructor.
     *
     * Override the MapClassLoader base constructor so that $map isn't used.
     */
    public function __construct()
    {
        parent::__construct($this->classMap);
    }

    /**
     * The Symfony ClassLoader does not support class maps.
     */
    public function addClassMap(array $classMap)
    {
        if ($this->classMap) {
            $this->classMap = array_merge($this->classMap, $classMap);
        } else {
            $this->classMap = $classMap;
        }

        // Set the parent's $map variable.
        parent::__construct($this->classMap);
    }

    /**
     * Retrieve the class map associated with the MapClassLoader.
     */
    public function getClassMap()
    {
        return $this->classMap;
    }

    /**
     * Prefixes are not supported by MapClassLoader.
     */
    public function addPrefix($prefix, $paths)
    {
        throw new \RuntimeException('Symfony MapClassLoader does not support prefixes.');
    }

    /**
     * Prefixes are not supported by MapClassLoader.
     */
    public function addPrefixes(array $prefixes)
    {
        throw new \RuntimeException('Symfony MapClassLoader does not support prefixes.');
    }

    /**
     * Prefixes are not supported by MapClassLoader.
     */
    public function getPrefixes()
    {
        return array();
    }

    /**
     * Unregisters the MapClassLoader.
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }
}
