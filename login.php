<?php
require_once 'core/init.php';
Session::delete('isMaster');
Session::delete('projekt');

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'password' => array('required' => true)
        ));
        
        if ($validation->passed()) {
            $login = false;
            if (Input::get('password') === 'master') {
                Session::put('isMaster', true);
                $login = true;
            }
            if ($login) {
                if (Input::get('projekt') === 'add') {
                    Session::put('projekt', 'neues_projekt');
                    Redirect::to('projekt.php');
                } else {
                    Redirect::to('index.php');
                }
            } else {
                echo 'login failed';
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $error . "<br>";
            }
        }
    }
}

?>

<form action="" method="post">
    <div class="field">
        <label for="projekt">Projekt auswählen</label><br>
        <select name=""projekt>
            <option value="add">Projekt hinzufügen</option>
            <option value="1">Projekt 1</option>
        </select>
    </div>
    <br>
    
    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" autocomplete="off">
    </div>
    
    <input type="hidden" NAME="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Einloggen">
</form>

