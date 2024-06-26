<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7ede7f12409be0a9e320ff8fcf77b273
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Ages\\WP\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ages\\WP\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Ages\\WP\\Admin\\Settings' => __DIR__ . '/../..' . '/includes/Admin/Settings.php',
        'Ages\\WP\\Constant' => __DIR__ . '/../..' . '/includes/Constant.php',
        'Ages\\WP\\Script' => __DIR__ . '/../..' . '/includes/Script.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7ede7f12409be0a9e320ff8fcf77b273::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7ede7f12409be0a9e320ff8fcf77b273::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7ede7f12409be0a9e320ff8fcf77b273::$classMap;

        }, null, ClassLoader::class);
    }
}
