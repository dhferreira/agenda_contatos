<?php

error_reporting(E_ALL | E_WARNING | ~E_NOTICE | ~E_DEPRECATED);

/**
 * DATABASE CONEXION
 *
 * @author diego.ferreira
 */
class Cnt_db
{
    public $conn = "";
    public $db_host = "localhost";
    public $db_user = "39dbf783f33b";
    public $db_name = "agenda";
    public $bd_password = "a456273c8e4394a6";

    function __construct()
    {
        $this->conn = new mysqli($this->db_host, $this->db_user,
            $this->bd_password, $this->db_name);

        if ($this->conn->connect_error) {
            $_SESSION['alert'] = "<h4>Erro de banco de dados: "
                . $this->conn->connect_error . "</h4>\n";
        }

        mysqli_set_charset($this->conn, "utf8");
    }
}
