<?php
function isMaster() {
    if (Session::exists('isMaster')) {
        return Session::get('isMaster');
    }
}

function isLoggedIn() {
    if (Session::exists($name));
}
