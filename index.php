<?php
include('lib/session.php');
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="css/main.style.css" rel="stylesheet" type="text/css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"
            type="text/javascript"></script>
</head>
<body>
<?php
//CHECK IF USER IS LOGGED IN
if (isset($_SESSION['user_id'])) {
    //USER IS LOGGED IN, REDIRECT DO HOME
    echo '<script>window.location.replace("home.php")</script>';
}
?>
<!-- USER IS NOT LOGGED ID, SHOW LOGIN PAGE -->
<div class="container">
    <div class="mainbox-login col-md-6 col-md-offset-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Login</div>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="form-login"
                      action="doLogin.php" method="POST">
                    <?php
                    if (isset($_SESSION['error_msg'])) {
                        echo '<div class="alert alert-danger"><ul>';
                        foreach ($_SESSION['error_msg'] as $error) {
                            echo '<li>' . $error . '</li>';
                        }
                        echo '</ul></div>';
                        unset($_SESSION['error_msg']);
                    }
                    ?>

                    <div class="input-group" style="margin-bottom:20px;">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-user"
                                  aria-hidden="true"></span>
                        </div>
                        <input type="text" class="form-control" id="email"
                               name="email" placeholder="E-mail">
                    </div>
                    <div class="input-group" style="margin-bottom:20px;">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-lock"
                                  aria-hidden="true"></span>
                        </div>
                        <input type="password" class="form-control"
                               id="password" name="password"
                               placeholder="Senha">
                    </div>
                    <button class="btn btn-success" type="submit">Acessar
                    </button>
                    <hr>
                    <span>Não tem uma conta? </span><a href="cadastro.php"
                                                       style="cursor:pointer;">Cadastre-se!</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
