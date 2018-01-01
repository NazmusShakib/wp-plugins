<?php

namespace Inc;


final class Init
{
    /**
     * Store all the classes inside and array
     * @return array Full List of classes
     */
    public static function get_services()
    {
        return [
            Pages\Admin::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class
        ];
    }

    /**
     * Loop through the classes, initialize them,
     * and call the register() method if it exists
     */

    public static function register_services()
    {
        foreach (self::get_services() as $class) {
            $service = self::instantiate($class);
            if (method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    /**
     * Initialize the class
     * @param $class Class from the services array
     * @return mixed class instance new instances of the class
     */
    private static function instantiate($class)
    {
        $service = new $class();
        return $service;
    }

}