<?php

include('lib/session.php');
include('class/Auth.php');
include('class/Cnt_db.php');

$db_cnt = new Cnt_db();
$db_conn = $db_cnt->conn;

//PUT INPUT'S VALUE INTO SESSION
$_SESSION['input_email'] = $_POST['email'];
$_SESSION['input_name'] = $_POST['name'];

$email = $_POST['email'];
$name = $_POST['name'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

//FIRST CHECK IF INPUTS ARE VALID
$rules = ['name'      => 'not_empty',
          'email'     => 'email',
          'password'  => 'not_empty',
          'password2' => 'not_empty'
];
$auth = new Auth($rules);

$fields = ['name'      => $name,
           'email'     => $email,
           'password'  => $password,
           'password2' => $password2
];
if (!$auth->validate($fields)) {
    //die('<script>window.location.replace("cadastro.php");</script>');
    returnPage();
}

//CHECK IF TWO PASSWORD MATCH
if (!$auth->validatePasswordMatch($password, $password2)) {
    //die('<script>window.location.replace("cadastro.php");</script>');
    returnPage();
}

//CHECK IF EMAIL ALREADY EXITS
if ($auth->emailExists($email)) {
    returnPage();
}

//INSERT DATA INTO DB
$sql = "INSERT INTO users(name,email,password) VALUES('{$name}','{$email}','"
    . md5($password) . "')";

if ($db_conn->query($sql) === true) {
    $_SESSION['success_msg'][] = 'UsuÃ¡rio criado com sucesso!';
    unset($_SESSION['input_email']);
    unset($_SESSION['input_name']);
} else {
    $_SESSION['error_msg'][] = "Error: " . $db_conn->error;
}

returnPage();

function returnPage()
{
    unset($auth);
    unset($db_cnt);

    header("Location: cadastro.php");
    die();
}

