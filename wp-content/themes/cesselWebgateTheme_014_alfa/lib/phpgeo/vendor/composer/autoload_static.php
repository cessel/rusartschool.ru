<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita77d48a815ef25ac9ec9d2dd2e3ddcbd
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Location\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Location\\' => 
        array (
            0 => __DIR__ . '/..' . '/mjaschen/phpgeo/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita77d48a815ef25ac9ec9d2dd2e3ddcbd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita77d48a815ef25ac9ec9d2dd2e3ddcbd::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita77d48a815ef25ac9ec9d2dd2e3ddcbd::$classMap;

        }, null, ClassLoader::class);
    }
}