<?php
require_once 'core/init.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'fieldname' => 'Username',
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => true
            ),
            'password' => array(
                'fieldname' => 'Passwort',
                'required' => true,
                'min' => 6
            ),
            'password_again' => array(
                'fieldname' => 'Passwort Wiederholung',
                'required' => true,
                'matches' => 'password'
            ),
            'name' => array(
                'fieldname' => 'Vollständiger Name',
                'required' => true,
                'min' => 2,
                'max' => 50
            )
        ));

        if ($validation->passed()) {
            $user = new User();
            
            $salt = Hash::salt(32);
            
            try {
                $user->create(array(
                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'name' => Input::get('name'),
                    'joined' => date('Y-m-d H:i:s'),
                    'group' => 1
                ));
                
                Session::flash('home', 'Erfolgreich registriert!');
                Redirect::to('index.php');
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $error . '<br>';
            }
        }
    }
}

?>

<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo escape(Input::get('username')) ?>" autocomplete="off">
    </div>
    
    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password">
    </div>
    
    <div class="field">
        <label for="password_again">Password Wiederholung</label>
        <input type="password" name="password_again">
    </div>
    
    <div class="field">
        <label for="name">Vollständiger Name</label>
        <input type="text" value="<?php echo escape(Input::get('name')) ?>" name="name">
    </div> 
    
    <input type="hidden" name="token" value="<?php echo Token::generate()?>">
    <input type="submit" value="Register">
</form>
