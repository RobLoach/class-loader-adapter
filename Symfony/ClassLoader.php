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
use Symfony\Component\ClassLoader\ClassLoader as BaseClassLoader;

/**
 * Adaption layer for the Symfony ClassLoader.
 *
 * @see Symfony\Component\ClassLoader\ClassLoader
 */
class ClassLoader extends BaseClassLoader implements ClassLoaderInterface
{
    /**
     * The Symfony ClassLoader does not support class maps.
     */
    public function addClassMap(array $classMap)
    {
        throw new \RuntimeException('The Symfony ClassLoader does not support class maps.');
    }

    /**
     * The Symfony ClassLoader does not support class maps.
     */
    public function getClassMap()
    {
        return array();
    }
}
