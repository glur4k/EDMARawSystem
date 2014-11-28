<?php
require_once 'core/init.php';
Session::delete('isMaster');
Session::delete('projekt');

if (Session::exists('login')) {
    echo Session::flash('login');
}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'password' => array('required' => true)
        ));

        if ($validation->passed()) {
            $projekt = new Projekt(Input::get('projekt'));

            $login = $projekt->login(Input::get('projekt'), Input::get('password'));

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
        <select name="projekt">
            <option value="new">Projekt hinzufügen</option>
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

