<?php

include('lib/session.php');
include('class/Auth.php');
include('class/Cnt_db.php');
include('class/Contact.php');
include('class/Phone.php');

$cnt_db = new Cnt_db();
$db_conn = $cnt_db->conn;

//CREATE OBJECT CONTACT
$contact = new Contact();

$contact->name = $_POST['name'];
$contact->email = $_POST['email'];
$contact->address = $_POST['address'];
$contact->phones = isset($_POST['phone']) ? $_POST['phone'] : null;
$contact->user = $_SESSION['user_id'];


//SAVE INFO INTO SESSION
$_SESSION['input_name'] = $contact->name;
$_SESSION['input_email'] = $contact->email;
$_SESSION['input_address'] = $contact->address;
$_SESSION['input_phones'] = $contact->phones;

//FORM VALIDATION
$rules = ['name' => 'not_empty', 'email' => 'email'];
$auth = new Auth($rules);

$fields = ['name' => $contact->name, 'email' => $contact->email];

if (!$auth->validate($fields)) {
    unset($contact);
    unset($auth);
    unset($cnt_db);
    header("location: newContact.php");
} else {
    //INSERT CONTACT INTO TABLE
    $contact->store();

    $_SESSION['success_msg'][] = "Contato gravado com sucesso";

    unset($_SESSION['input_name']);
    unset($_SESSION['input_address']);
    unset($_SESSION['input_email']);
    unset($_SESSION['input_phones']);

    unset($contact);
    unset($auth);
    unset($cnt_db);
    header("location: newContact.php");
}
