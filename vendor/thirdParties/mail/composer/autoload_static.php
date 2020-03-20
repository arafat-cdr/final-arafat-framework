<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit24a102a70ef0fc4e9f6a541b82a6ad22
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit24a102a70ef0fc4e9f6a541b82a6ad22::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit24a102a70ef0fc4e9f6a541b82a6ad22::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
