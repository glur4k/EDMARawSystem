<?php
require_once 'core/init.php';

if (!Session::exists($name)) {
    if (!Session::get('isMaster')) {
        Redirect::to('login.php');
    }
}
?>

Das ist die Projekt-Seite