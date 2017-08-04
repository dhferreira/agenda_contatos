<?php

include('lib/session.php');
include('lib/check_user.php');

?>

<html>
<head>
    <title>Agenda de Contatos</title>
    <link href="plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="css/main.style.css" rel="stylesheet" type="text/css"/>
    <script src="plugin/jquery.js" type="text/javascript"></script>
    <script src="js/main.js" type="text/javascript"></script>
    <script src="plugin/bootstrap/js/bootstrap.min.js"
            type="text/javascript"></script>
    <script src="plugin/jQuery-Mask-Plugin-master/src/jquery.mask.js"
            type="text/javascript"></script>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed"
                    data-toggle="collapse" data-target="#navbar_main"
                    aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home.php">Agenda de Contatos</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar_main">
            <ul class="nav navbar-nav">
                <li><a href="home.php">Contatos </a></li>
                <li class="active"><a href="newContact.php">Novo Contato <span
                                class="sr-only">(current)</span></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                       role="button" aria-haspopup="true"
                       aria-expanded="false"><?php echo $_SESSION['user_name']; ?>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="doLogout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h4 style="text-align:center; font-weight: 600;">NOVO CONTATO</h4>
            <hr>
            <form class="form-horizontal" id="form-contact" method="POST"
                  action="saveContact.php">
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
                    <label for="nameInput"
                           class="col-sm-2 control-label">Nome</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nameInput"
                               name="name" placeholder="Nome"
                               value="<?php echo isset($_SESSION['input_name'])
                                   ? $_SESSION['input_name'] : null ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="emailInput"
                           class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="emailInput"
                               name="email" placeholder="example@example.com"
                               value="<?php echo isset($_SESSION['input_email'])
                                   ? $_SESSION['input_email'] : null ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="addressInput" class="col-sm-2 control-label">EndereÃ§o</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"
                               id="addressInput" name="address"
                               placeholder="EndereÃ§o"
                               value="<?php echo isset($_SESSION['input_address'])
                                   ? $_SESSION['input_address'] : null ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phoneDiv" class="col-sm-2 control-label">Telefone</label>
                    <div class="col-sm-10" id="phoneDiv">
                        <div class="col-md-12" id="phones">
                            <?php
                            $count = 0;

                            if (isset($_SESSION['input_phones'])) {
                                foreach ($_SESSION['input_phones'] as $phone) {
                                    if (empty($phone)) {
                                        continue;
                                    }
                                    $count++;
                                    ?>
                                    <div class="phone-<?= $count; ?> row">
                                        <div class="input-group">
                                            <input type="text"
                                                   class="form-control phone"
                                                   id="phone-<?= $count; ?>"
                                                   name="phone[]"
                                                   placeholder="(XX) XXXX-XXXX"
                                                   style="margin-bottom: 15px;"
                                                   value="<?= $phone ?>">
                                            <div class="input-group-btn">
                                                <button type="button"
                                                        class="btn btn-default fix"
                                                        aria-hidden="true"
                                                        onclick="removePhone('.phone-<?= $count; ?>');"
                                                        title="Remover NÃºmero">
                                                    <span class="glyphicon glyphicon-minus"/>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <input type="hidden" id="count" value="<?= $count; ?>">
                        <div>
                            <button type="button" class="btn btn-default"
                                    aria-hidden="true" onclick="addPhone();"
                                    style="height: 34px;" title="Novo NÃºmero">
                                <span class="glyphicon glyphicon-plus"/>
                            </button>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" style="text-align: center;">
                    <button class="btn btn-success" type="submit">
                        <span class="glyphicon glyphicon-plus"
                              aria-hidden="true"></span>
                        Gravar
                    </button>
                    <button class="btn btn-warning" type="button"
                            onclick="$('form#form-contact :input').each(function(){ $(this).val('');});">
                        <span class="glyphicon glyphicon-remove"
                              aria-hidden="true"></span>
                        Limpar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>


