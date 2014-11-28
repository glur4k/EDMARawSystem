<?php

/**
 * Description of newPHPClass
 *
 * @author sandro
 */
class Projekt {

    private $_db,
            $_data,
            $_sessionName,
            $_isMaster,
            $_isLoggedIn;

    public function __construct($projekt = null) {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');

        if (!$projekt) {
            if (Session::exists($this->_sessionName)) {
                echo 'session exists!';
                $projekt = Session::get($this->_sessionName);

                if ($this->find($projekt)) {
                    $this->_isLoggedIn = true;
                }
            }
        } else {
            $this->find($projekt);
        }
    }

    private function find($projekt = null) {
        if ($projekt) {
            $field = (is_numeric($projekt)) ? 'id' : 'name';
            
            $data = $this->_db->get('projekte', array($field, '=', $projekt));

            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
    }

    public function canEdit() {
        
    }

    public function login($projekt = null, $password = null) {
        if (!$projekt && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->id);
        } else if ($projekt === 'new') {
            // Neues Projekt in der Datenbank anlegen
        } else {
            $projekt = $this->find($projekt);

            if ($projekt) {
                // TODO: Hash
                if (/* $this->data()->password */'master' === $password) {
                    Session::put($this->_sessionName, $this->data()->id);

                    return true;
                }
            }
        }
        return false;
    }

    public function exists() {
        return (!empty($this->data())) ? true : false;
    }

    public function logout() {
        Session::delete($this->_sessionName);
    }

    public function data() {
        return $this->_data;
    }

    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }
    
    public function isMaster() {
        return $this->_isMaster;
    }
}
