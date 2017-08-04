<?php
/**
 * CHECK IF USER IS LOGGED IN, OTHERWISE ASK FOR LOGGIN
 */
if (!isset($_SESSION['user_id'])) {
    die('<h3>VocÃª nÃ£o estÃ¡ logado. <a href="index.php"> Clique aqui para logar-se!</a></h3>');
}