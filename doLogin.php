<?php

include('lib/session.php');
include('class/Auth.php');
include('class/Cnt_db.php');
include('class/User.php');
include('class/Phone.php');

$db_cnt = new Cnt_db();
$db_conn = $db_cnt->conn;

$email = $_POST['email'];
$password = $_POST['password'];

//VALIDATION RULES
$rules = ['email' => 'email|not_empty', 'password' => 'not_empty'];
$auth = new Auth($rules);

//FIRST VALIDATION: Email and Password fields
$fields = ['email' => $email, 'password' => $password];
if (!$auth->validate($fields)) {
    header("Location: index.php");
}

$result = $auth->validateLogin($email, md5($password));

//EMAIL AND PASSWORD DON'T MATCH
if ($result == '0') {
    $_SESSION['error_msg'][] = "UsuÃ¡rio e/ou senha nÃ£o conferem";
    header("Location: index.php");
} //EMAIL AND PASSWORD MATCH, SAVE INFO INTO SESSION
else {
    $_SESSION['user_id'] = $result['id'];
    $_SESSION['user_name'] = $result['name'];
    $_SESSION['user_email'] = $result['email'];

    $user = new User($result['id']);
    $user->email = $result['email'];
    $user->name = $result['name'];

    $_SESSION['user_object'] = serialize($user);

    header("Location: home.php");
}