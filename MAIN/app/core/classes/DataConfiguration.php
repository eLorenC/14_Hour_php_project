<?php
    /**
     * Created by PhpStorm.
     * User: ericl_000
     * Date: 4/19/2016
     * Time: 2:57 PM
     */

    namespace AppData;


    class DataConfiguration
    {
        private static $config_array;

        public static function readConfig($name)
        {
            return self::$config_array[$name];
        }

        public static function writeConfig($name,$value)
        {
            self::$config_array[$name] = $value;
        }
    }
    DataConfiguration::writeConfig('db.host', 'localhost');
    DataConfiguration::writeConfig('db.base', 'php_final');
    DataConfiguration::writeConfig('db.user', 'cs_access_1');
    DataConfiguration::writeConfig('db.pass', 'Council0solutions09991!');

