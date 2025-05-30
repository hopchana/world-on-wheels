<?php

class Model
{
    protected $db;
    function __construct($db) {
        $this->db = $db;
    }

    protected function exist($table, $column, $data): bool
    {
        if (gettype($data) == "string") $data = "'" . $data . "'";
        if ($this->db->check($table, "$column = $data")) {
            return true;
        }
        return false;
    }

    function is_session_started(): bool
    {
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                return session_status() === PHP_SESSION_ACTIVE;
            } else {
                return !(session_id() === '');
            }
        }
        return FALSE;
    }

}