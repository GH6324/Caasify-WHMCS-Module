<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbae73b5ab995cdb25e22c5500d8144e0
{
    public static $files = array (
        'b41be569c48b1947114fd50c1b47bf80' => __DIR__ . '/..' . '/persgeek/request/helpers.php',
        '08e60ab0c5c0d2474192303ebd36205d' => __DIR__ . '/../..' . '/config.php',
        '77c22f5ec4ece5b040661a860085613e' => __DIR__ . '/../..' . '/controller.php',
        '3a171750649aac87781d81f2eae35cfc' => __DIR__ . '/../..' . '/hooks.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PG\\Request\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PG\\Request\\' => 
        array (
            0 => __DIR__ . '/..' . '/persgeek/request/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbae73b5ab995cdb25e22c5500d8144e0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbae73b5ab995cdb25e22c5500d8144e0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbae73b5ab995cdb25e22c5500d8144e0::$classMap;

        }, null, ClassLoader::class);
    }
}
