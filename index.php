<?php
require_once 'core/init.php';

if (Session::exists('home')) {
    echo Session::flash('home');
}

$user = new User();
if ($user->isLoggedIn()) {
?>
    <p>Hi <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a></p> 
    
    <ul>
        <li><a href="logout.php">Ausloggen</a></li>
        <li><a href="update.php">Profildaten aktualisieren</a></li>
        <li><a href="changepassword.php">Passwort ändern</a></li>
    </ul>
<?php
    if ($user->hasPermission('admin')) {
        echo 'Du bist ein Admin';
    }
} else {
?>
    <p>Bitte anmelden! <a href="login.php">zum Login</a></p>
<?php
}