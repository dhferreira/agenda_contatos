<?php

include('lib/session.php');

if (isset($_SESSION['user_id'])) {
    session_destroy();
}

echo '<script>window.location.replace("index.php");</script>';
