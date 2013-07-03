Class Loader Adapter
====================

Common interface to interact with a number of different class loaders.


Design
------

It is recommended to just have one class loader interface for your application,
and initialize and use it only once during your application's starting point.
It can, however, sometimes be handy to allow swapping the class loader while
still using the same API to interact with it. Class Loader Adapter aims to
provide that interface commonality between a bunch of different third-party
class loaders.


Interoperability
----------------

* [Symfony\Component\ClassLoader\ClassLoader](https://github.com/symfony/ClassLoader/blob/master/ClassLoader.php)
* [Symfony\Component\ClassLoader\MapClassLoader](https://github.com/symfony/ClassLoader/blob/master/MapClassLoader.php)
* [Symfony\Component\ClassLoader\UniversalClassLoader](https://github.com/symfony/ClassLoader/blob/master/UniversalClassLoader.php)
* [Composer\Autoload\ClassLoader](https://github.com/composer/composer/blob/master/src/Composer/Autoload/ClassLoader.php)


Usage
-----

Initialize with whichever class loader you want to use:

```php
// Initialize the loader with the Symfony UniversalClassLoader.
$loader = new RobLoach\ClassLoaderAdapter\Symfony\UniversalClassLoader();

// Initialize the loader with the Composer ClassLoader.
$loader = new RobLoach\ClassLoaderAdapter\Composer\ClassLoader();
```

Since all of the Class Loader Adapter loaders use the same
[ClassLoaderInterface](src/RobLoach/ClassLoaderAdapter/ClassLoaderInterface.php)
, you can interact with them all the same way.

```php
// Add a namespace prefix.
$loader->addPrefix('Foo', 'src/');

// Add a class map.
$map = array('Foo\Bar' => 'src/Foo/Bar.php');
$loader->addClassMap($map);

// Register the class loader so that the classes can be loaded accordingly.
$loader->register();
```

Although the interface is in place, class loader functionality and support
slightly differs from class loader to class loader. Take note of this when
switching between the class loaders.
