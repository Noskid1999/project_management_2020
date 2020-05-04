<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita436fc0b62077eb1dfe06c9238cdd447
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita436fc0b62077eb1dfe06c9238cdd447::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita436fc0b62077eb1dfe06c9238cdd447::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
