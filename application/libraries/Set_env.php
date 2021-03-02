<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Set_env
{
    function __construct()
    {
        $this->set_timezone('Asia/Bangkok');
    }

    private function set_timezone($zone)
    {
        date_default_timezone_set($zone);
    }

    public function get_system_status()
    {
        $file = 'assets/status/status.conf';
        if (is_readable($file)) {
            $fp = fopen($file, 'r');
            if ($fp) {
                $result = fread($fp, filesize($file));
            } else {
                $result = 'Unopenable';
            }
            fclose($fp);
        } else {
            $result = 'Unreadable';
        }
        return $result;
    }
}
