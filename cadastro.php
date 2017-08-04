<?php

include('lib/session.php');

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro</title>
        <link href="plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
        <link href="css/main.style.css" rel="stylesheet" type="text/css"/>
        <script src="plugin/jquery.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="mainbox-login col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Cadastro de UsuÃ¡rio
                            <a href="index.php"
                               style="float: right; font-size: 12px; cursor: pointer;">Fazer
                                Login</a>
                        </div>

                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" id="form-signup"
                              action="doSignUp.php" method="POST">
                            <?php
                            if (isset($_SESSION['error_msg'])) {
                                echo '<div class="alert alert-danger"><ul>';
                                foreach ($_SESSION['error_msg'] as $error) {
                                    echo '<li>' . $error . '</li>';
                                }
                                echo '</ul></div>';
                                unset($_SESSION['error_msg']);
                            }
                            if (isset($_SESSION['success_msg'])) {
                                echo '<div class="alert alert-success"><ul>';
                                foreach ($_SESSION['success_msg'] as $msg) {
                                    echo '<li>' . $msg . '</li>';
                                }
                                echo '</ul></div>';
                                unset($_SESSION['success_msg']);
                            }
                            ?>

                            <div class="form-group row">
                                <label for="nameInput" class="col-sm-1 control-label">Nome</label>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control"
                                           id="nameInput" name="name" placeholder="Nome"
                                           value="<?php echo isset($_SESSION['input_name'])
                                               ? $_SESSION['input_name'] : null ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="emailInput" class="col-sm-1 control-label">Email</label>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control"
                                           id="emailInput" name="email"
                                           placeholder="example@example.com"
                                           value="<?php echo isset($_SESSION['input_email'])
                                               ? $_SESSION['input_email'] : null ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="passwordInput passwordInput2"
                                       class="col-sm-1 control-label">Senha</label>
                                <div class="col-sm-11">
                                    <input type="password" class="form-control"
                                           id="passwordInput" name="password"
                                           placeholder="Senha"
                                           style="margin-bottom: 15px;">
                                    <input type="password" class="form-control"
                                           id="passwordInput2" name="password2"
                                           placeholder="Entre novamente sua Senha">
                                </div>
                            </div>
                            <br>
                            <div class="row" style="text-align: center;">
                                <button class="btn btn-success" type="submit">
                                    <span class="glyphicon glyphicon-plus"
                                          aria-hidden="true"></span>
                                    Cadastrar
                                </button>
                                <button class="btn btn-warning" type="button"
                                        onclick="$('form#form-signup :input').each(function(){ $(this).val('');});">
                                    <span class="glyphicon glyphicon-remove"
                                          aria-hidden="true"></span>
                                    Limpar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

