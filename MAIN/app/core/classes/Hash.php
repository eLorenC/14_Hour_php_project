<?php

    /**
     * Created by PhpStorm.
     * User: ericl_000
     * Date: 2/24/2016
     * Time: 11:48 PM
     */
    class Hash
    {
        public function hashIt($str)
        {
            return password_hash($str, PASSWORD_BCRYPT, ['cost' => 10]);
        }

        public function hashCheck($str, $hash)
        {
            //var_dump(password_verify($str, $hash));
            return password_verify($str, $hash);
        }
    }