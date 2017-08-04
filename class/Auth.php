<?php

//include ('Cnt_db.php');

/**
 * Authentication of Information
 *
 * @author diego.ferreira
 */
class Auth
{
    private $rules;

    function __construct($rules)
    {
        $this->rules = $rules;
    }

    /**
     * VALIDATE FIELDS USING SOME RULES
     *
     * @author Diego Ferreira
     * @params $fields : ['field' => 'value']
     * @return true: Valid field, false: Invalid Field
     */
    public function validate($fields)
    {
        foreach ($fields as $key => $value) {
            foreach (explode('|', $this->rules[$key]) as $rule) {
                switch ($rule) {
                    case 'email':
                        if (!empty($value) and !filter_var($value,
                                FILTER_VALIDATE_EMAIL)
                        ) {
                            $_SESSION['error_msg'][]
                                = 'Insira um E-mail válido (example@example.com)';
                        }
                        break;
                    case 'not_empty':
                        if (empty($value)) {
                            if ($key == "name") {
                                $_SESSION['error_msg'][] = 'Insira um Nome';
                            } else {
                                if ($key == 'password') {
                                    $_SESSION['error_msg'][]
                                        = 'Insira uma Senha';
                                } else {
                                    if ($key == "password2") {
                                        $_SESSION['error_msg'][]
                                            = 'Re-insira a Senha escolhida';
                                    } else {
                                        if ($key == 'email') {
                                            $_SESSION['error_msg'][]
                                                = 'Insira um E-mail válido';
                                        }
                                    }
                                }
                            }

                        }
                        break;
                }
            }
        }
        if (isset ($_SESSION['error_msg'])) {
            return false;
        }
        return true;
    }

    /**
     * VALIDATE LOGIN, CHECK IF EMAIL AND PASSWORD MATCH
     *
     * @author Diego Ferreira
     * @params $email: email address, $passowrd: password
     * @return 0: Email and Password don't match, Result array: user info
     */
    public function validateLogin($email, $password)
    {
        global $db_conn;
        $sql
            = "SELECT id, name, email FROM users WHERE email = '{$email}' and password = '{$password}'";
        $result = $db_conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return '0';
        }
    }

    /**
     * CHECK IF TWO PASSWORDS MATCH
     *
     * @author Diego Ferreira
     * @params $password: first password, $passoword2: second password
     * @return True/False, if the match or not
     */
    public function validatePasswordMatch($password, $password2)
    {
        if ($password == $password2) {
            return true;
        }

        $_SESSION['error_msg'][] = 'certifique-se que as senhas são iguais';
        return false;
    }

    /**
     * CHECK IF EMAIL ALREADY EXISTS
     *
     * @author Diego Ferreira
     * @params $email: email address
     * @return True/False, if the match or not
     */
    public function emailExists($email)
    {
        global $db_conn;
        $sql = "SELECT id FROM users WHERE email = '{$email}'";
        $result = $db_conn->query($sql);

        if ($result->num_rows > 0) {
            $_SESSION['error_msg'][]
                = 'Escolha outro E-mail, este já encontra-se em uso.';
            return true;
        }

        return false;
    }
}
