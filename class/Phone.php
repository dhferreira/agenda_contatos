<?php

/**
 * CLASS PHONE
 *
 * @author diego.ferreira
 */
class Phone
{
    public $id;
    public $number;
    public $id_contact;

    function __construct($id = null)
    {
        global $db_conn;

        if (empty($id)) {
            $this->id = null;
            $this->number = "";
            $this->id_contact = "";
        } else {
            $this->id = $id;
            $sql = "SELECT * FROM phones WHERE id='{$this->id}'";

            $result = $db_conn->query($sql);

            if (!$result) {
                die("Error: " . $db_conn->error);
            }

            $row = $result->fetch_assoc();
            $this->number = $row['number'];
            $this->id_contact = $row['id_contact'];
        }
    }

    /**
     * SAVE PHONE INFORMATION INTO DATABASE
     */
    public function store()
    {
        global $db_conn;
        //INSERT
        if (empty($this->id)) {
            $sql
                = "INSERT INTO phones (number, id_contact) VALUES ('{$this->number}', '{$this->id_contact}') ";
            if ($db_conn->query($sql)) {
                return true;
            } else {
                die("Error: " . $db_conn->error);
            }
        } //UPDATE
        else {
            $sql
                = "UPDATE phones SET number = '{$this->number}', id_contact = '{$this->id_contact}' WHERE id = '{$this->id}' ";
            if ($db_conn->query($sql)) {
                return true;
            } else {
                die("Error: " . $db_conn->error);
            }
        }
    }

    /**
     * DELETE FONE INFORMATION INTO DATABASE
     */
    public function delete()
    {
        global $db_conn;

        $sql = "DELETE FROM phones WHERE id = '{$this->id}'";
        $result = $db_conn->query($sql);

        if (!$result) {
            die('Error: ' . $db_conn->error);
        }
    }
}
