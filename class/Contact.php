<?php

/**
 * Class Contact
 *
 * @author diego.ferreira
 */
class Contact
{
    public $id;
    public $name;
    public $email;
    public $address;
    public $phones; //ARRAY OF PHONES OBJECTS
    public $user;

    function __construct($id = null)
    {
        global $db_conn;

        if (empty($id)) {
            $this->id = null;
            $this->name = "";
            $this->email = "";
            $this->address = "";
            $this->phones = array();
            $this->user = "";
        } else {
            $this->id = $id;
            $this->user = "";

            //GET CONTACT INFORMATION
            $sql = "SELECT * FROM contacts WHERE id = '{$this->id}'";
            $result = $db_conn->query($sql);
            $row = $result->fetch_assoc();

            $this->name = $row['name'];
            $this->email = $row['email'];
            $this->address = $row['address'];
            $this->phones = array();

            //GET PHONES
            $sql = "SELECT * FROM phones WHERE id_contact = '{$this->id}'";
            $result = $db_conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $this->phones[] = new Phone($row['id']);
            }
        }
    }

    /**
     * SAVE CONTACT INFORMATION INTO DATABASE
     */
    public function store()
    {
        global $db_conn;

        //IF OBJECT HASN'T ID, INSERT INTO TABLE
        if (empty($this->id)) {
            $sql
                = "INSERT INTO contacts(name, email, address) VALUES ('{$this->name}', '{$this->email}', '{$this->address}')";
            $result = $db_conn->query($sql);

            if (!$result) {
                die('Error: ' . $db_conn->error);
            }

            //GET ID OF CONTACT
            $sql
                = "SELECT id FROM contacts WHERE name = '{$this->name}' and email = '{$this->email}' and address = '{$this->address}'";
            $result = $db_conn->query($sql);
            $row = $result->fetch_assoc();

            $this->id = $row['id'];

            //STORE PHONE NUMBERS
            foreach ($this->phones as $phone) {
                if (!empty($phone)) {
                    $phone = str_replace([' ', '-', '(', ')'], '', $phone);
                    $p = new Phone();
                    $p->id_contact = $this->id;
                    $p->number = $phone;
                    $p->store();
                }
            }

            //LINK CONTACT TO A USER
            $sql
                = "INSERT INTO user_contacts(id_user, id_contact) VALUES ('{$this->user}', '{$this->id}')";
            $result = $db_conn->query($sql);

            if (!$result) {
                die('Error: ' . $db_conn->error);
            }

            return true;

        } //OBJECT HAS ID, UPDATE
        else {
            $sql
                = "UPDATE contacts SET name = '{$this->name}', email = '{$this->email}', address = '{$this->address}' WHERE id = '{$this->id}'";
            $result = $db_conn->query($sql);

            if (!$result) {
                die('Error: ' . $db_conn->error);
            }

            foreach ($this->phones as $phone) {
                $phone->store();
            }

        }
    }

    public function toJSON()
    {
        return json_encode($this);
    }

    /**
     * DELETE CONTACT INFORMATION FROM DATABASE
     */
    public function delete()
    {
        global $db_conn;
        //DELETE PHONES
        foreach ($this->phones as $phone) {
            $phone->delete();
        }

        //REMOVE CONTACT FROM DATABASE
        $sql = "DELETE FROM contacts WHERE id = '{$this->id}'";
        $result = $db_conn->query($sql);

        if (!$result) {
            die('Error: ' . $db_conn->error);
        }

        //REMOVE LINK CONTACT - USER
        $sql = "DELETE FROM user_contacts WHERE id_contact = '{$this->id}'";
        $result = $db_conn->query($sql);

        if (!$result) {
            die('Error: ' . $db_conn->error);
        }
        return true;
    }

}
