<?php
include('lib/session.php');
include('class/Auth.php');
include('class/Cnt_db.php');
include('class/Contact.php');
include('class/Phone.php');


$cnt_db = new Cnt_db();
$db_conn = $cnt_db->conn;


//CREATE OBJECT CONTACT
$contact = new Contact($_POST['id_contact']);

//UPDATE INFO
$contact->name = $_POST['name'];
$contact->email = $_POST['email'];
$contact->address = $_POST['address'];

//UPDATE PHONES
foreach ($contact->phones as $phone) {
    $phone->delete();
}
$contact->phones = array();

if (isset($_POST['phone'])) {
    foreach ($_POST['phone'] as $phone) {
        $p = new Phone();
        $p->id_contact = $contact->id;
        $p->number = str_replace([' ', '-', '(', ')'], '', $phone);
        $contact->phones[] = $p;
    }
}

$contact->store();

header('location: home.php');