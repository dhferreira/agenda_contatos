<?php

include('Contact.php');

/**
 * CLASS USER
 *
 * @author diego.ferreira
 */
class User
{
    public $id;
    public $name;
    public $email;

    function __construct($id = null)
    {

        $this->id = $id;
    }

    /**
     * RETURN LIST OF CONTACTS AND PAGINATION
     */
    public function getContacts($page, $limit_page)
    {
        global $db_conn;

        $this->contacts = array();
        $sql
            = "SELECT user_contacts.id_contact
                FROM user_contacts
                INNER JOIN contacts ON contacts.id = user_contacts.id_contact
                WHERE user_contacts.id_user = '{$this->id}'
                ORDER by contacts.name LIMIT $page, $limit_page";
        if ($result = $db_conn->query($sql)) {
            $contacts = array();
            while ($row = $result->fetch_assoc()) {
                $contacts[] = new Contact($row['id_contact']);
            }
            return $contacts;
        } else {
            die("Error: " . $db_conn->error);
        }
    }

    /**
     * GET TOTAL NUMBER OF CONTACTS
     */
    public function getNumberContacts()
    {
        global $db_conn;

        $this->contacts = array();
        $sql
            = "SELECT COUNT(*) as number
                FROM user_contacts
                WHERE id_user = '{$this->id}'";
        if ($result = $db_conn->query($sql)) {
            $row = $result->fetch_assoc();
            return $row['number'];
        } else {
            die("Error: " . $db_conn->error);
        }
    }

}
