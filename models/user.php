<?php
class User extends Db {

    function get_all(){

        $sql = "SELECT * FROM `users`";

        $users = $this->select($sql);

        return $users;

    }

    function get_by_id($id){

        $id = (int)$id;

        $sql = "SELECT * FROM users WHERE id = '$id'";

        $user = $this->select($sql)[0];

        return $user;

    }

        function add(){

        $username = trim($this->data['username']);
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        $email = trim($this->data['email']);


        $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";

        $new_user_id = $this->execute_return_id($sql);

        return $new_user_id;

    }

    function exists(){

        $username = $this->data['username'];

        $sql = "SELECT * FROM users WHERE username = '$username'";

        $user = $this->select($sql);

        return $user;

    }

    function login(){

        $_SESSION = array(); // Empty session to start fresh.

        // Get the user's details from the db and store it in a variable
        $username = $this->data['username'];
        $sql = "SELECT * FROM users WHERE username = '$username'";

        $user = $this->select($sql)[0];

        // Check if the password from the form matches password from db
        if( password_verify($_POST['password'], $user['password']) ){

            $_SESSION['user_logged_in'] = $user['id'];

        }else{ // Login attempt failed.
            $_SESSION['login_attempt_msg'] = '<p class="text-danger">* Incorrect username and/or password</p>';
            header('Location: /users/login-page.php');
            exit();
        }


    }

    function edit(){

    $id = (int)$_SESSION['user_logged_in'];
    $username = trim($this->data['username']);
    $password = password_hash(trim($this->data['password']), PASSWORD_DEFAULT);
    $email = trim($this->data['email']);


    if( !empty(trim($_POST['password'])) ){ // New password entered

        $sql = "UPDATE users SET password='$password', email='$email' WHERE id='$id'";

    }else{ // No new password entered
        $sql = "UPDATE users SET email='$email' WHERE id='$id'";
    }


    $this->execute($sql);

}

}
