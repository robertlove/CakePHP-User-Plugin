<?php

class UserAppController extends AppController
{
    /**
     * Get Password
     *
     * @return string
     */
    public function getPassword()
    {
        $password = '';
        $possible = '2346789bcdfghjkmnpqrtwxyz';
        $i = 0;
        while ($i < 8) {
            $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            if (!strstr($password, $char)) {
                $password .= $char;
                $i++;
            }
        }
        return $password;
    }

    /**
     * Get Secret
     *
     * @return string
     */
    public function getSecret()
    {
        return sha1(Configure::read('Security.cipherSeed') . microtime());
    }
}