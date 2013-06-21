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
use Symfony\Component\ClassLoader\UniversalClassLoader as BaseClassLoader;

/**
 * Adaption layer for the Symfony UniversalClassLoader.
 *
 * @see Symfony\Component\ClassLoader\UniversalClassLoader
 */
class UniversalClassLoader extends BaseClassLoader implements ClassLoaderInterface
{
    /**
     * The Symfony UniversalClassLoader does not support class maps.
     */
    public function addClassMap(array $classMap)
    {
        throw new \RuntimeException('Symfony UniversalClassLoader does not support class maps.');
    }

    /**
     * The Symfony UniversalClassLoader does not support class maps.
     */
    public function getClassMap()
    {
        return array();
    }

    /**
     * Add a prefix to the ClassLoader.
     *
     * UniversalClassLoader differentiates between PEAR-like and PHP namespaces.
     * This will make it so that they act the same.
     */
    public function addPrefix($prefix, $paths)
    {
        $is_namespace = (strpos($prefix, '\\') !== FALSE) && (substr($prefix, -1) !== '_');
        if ($is_namespace) {
          $this->registerNamespace(rtrim($prefix, '\\'), $paths);
        }
        else {
          $this->registerPrefix($prefix, $paths);
        }
    }

    /**
     * Prefixes are not supported by MapClassLoader.
     */
    public function addPrefixes(array $prefixes)
    {
        foreach ($prefixes as $prefix => $path) {
            $this->addPrefix($prefix, $path);
        }
    }

    /**
     * Unregisters the MapClassLoader.
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }
}
