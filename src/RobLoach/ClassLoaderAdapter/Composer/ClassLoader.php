<?php

/*
 * This file is part of the Class Loader Adapter package.
 *
 * (c) Rob Loach (http://robloach.net)
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace RobLoach\ClassLoaderAdapter\Composer;

use RobLoach\ClassLoaderAdapter\ClassLoaderInterface;
use Composer\Autoload\ClassLoader as BaseClassLoader;

/**
 * Adaption layer for the Composer ClassLoader.
 *
 * @see Composer\Autoload\ClassLoader
 */
class ClassLoader extends BaseClassLoader implements ClassLoaderInterface
{
    /**
     * Registers a set of classes, merging with any others previously set.
     *
     * @param string       $prefix  The classes prefix
     * @param array|string $paths   The location(s) of the classes
     */
    public function addPrefix($prefix, $paths)
    {
        return $this->add($prefix, $paths);
    }

    /**
     * Adds prefixes.
     *
     * @param array $prefixes Prefixes to add
     */
    public function addPrefixes(array $prefixes) {
        foreach ($prefixes as $prefix => $path) {
            $this->addPrefix($prefix, $path);
        }
    }
}
