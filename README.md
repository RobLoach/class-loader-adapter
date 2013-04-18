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
