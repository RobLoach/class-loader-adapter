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
use Krautoload\Adapter_NamespaceInspector_Pluggable;
use Krautoload\NamespaceInspector_Pluggable;

/**
 * Adaption layer for the Krautoload\NamespaceInspector_Pluggable,
 * based on Krautoload's own adapter layer.
 *
 * A "NamespaceInspector" is a more powerful version of a class loader, with
 * added discovery capabilities.
 *
 * Since Adapter_NamespaceInspector_* extends Adapter_ClassLoader_*, and PHP
 * does not support multiple inheritance, we have to copy the adapter methods
 * from PluggableClassLoader.php, and cannot reuse it. Traits would be nice.
 *
 * @see Krautoload\Adapter_NamespaceInspector_Pluggable
 */
class PluggableNamespaceInspector extends PluggableClassLoader
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->loader = new NamespaceInspector_Pluggable();
        $this->adapter = new Adapter_NamespaceInspector_Pluggable($this->loader);
    }
}
