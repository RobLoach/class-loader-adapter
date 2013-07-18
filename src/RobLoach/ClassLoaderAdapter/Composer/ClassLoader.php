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
     * {@inheritDoc}
     */
    public function addMultiple(array $prefixes) {
        foreach ($prefixes as $prefix => $path) {
            $this->add($prefix, $path);
        }
    }
}
