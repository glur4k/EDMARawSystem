<?php
require_once 'core/init.php';

if (Session::exists('home')) {
    echo Session::flash('home');
}

$projekt = new Projekt();
if ($projekt->isLoggedIn()) {
?>
    <p>Projekt: <?php echo escape($projekt->data()->name); ?></p> 
    
    <ul>
        <li><a href="logout.php">Ausloggen</a></li>
        <li><a href="update.php">Profildaten aktualisieren</a></li>
    </ul>
<?php
    if ($projekt->isMaster()) {
        echo 'Du bist ein Admin';
    }
} else {
    Session::flash('login', 'Bitte zu erst anmelden!');
    Redirect::to('login.php');
}