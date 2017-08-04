<?php

include('lib/session.php');
include('lib/check_user.php');
include('class/User.php');
include('class/Phone.php');
include('class/Cnt_db.php');


$cnt_db = new Cnt_db();
$db_conn = $cnt_db->conn;


//LOGIN FAILED
if (!isset($_SESSION['user_name'])) {
    header("location: doLogout.php");
}

$user = unserialize($_SESSION['user_object']);


//PAGINATION
$total_contacts = $user->getNumberContacts();
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$per_page = 5;
$number_pages = ceil($user->getNumberContacts() / $per_page);

if ($current_page > $number_pages && $number_pages > 0) {
    header('location: home.php');
}

//GET CONTACTS OF THIS PAGE
$contacts = $user->getContacts(($current_page - 1) * $per_page, $per_page);

?>

<html>
<head>
    <title>Agenda de Contatos</title>
    <link href="plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="css/main.style.css" rel="stylesheet" type="text/css"/>
    <script src="plugin/jquery.js" type="text/javascript"></script>
    <script src="plugin/bootstrap/js/bootstrap.min.js"
            type="text/javascript"></script>
    <script src="js/main.js" type="text/javascript"></script>
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
                <li class="active"><a href="home.php">Contatos <span
                                class="sr-only">(current)</span></a></li>
                <li><a href="newContact.php">Novo Contato</a></li>
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
        <div class="col-md-10 col-md-offset-1">
            <?php
            if (empty($contacts)){
                echo '<span style="text-align:center;">OlÃ¡ <strong>'
                    . explode(" ", $user->name)[0]
                    . ',</strong> <br/>sua lista de contatos estÃ¡ vazia.</span>';
            }
            else{
            ?>
            <ul class="pagination" style="float:right;">
                <li>
                    <a href="<?php echo
                    ($current_page - 1 > 0) ? "home.php?page=" . ($current_page
                            - 1)
                        : "home.php?page=" . $current_page
                    ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php
                for ($i = 0; $i < $number_pages; $i++) {
                    if ($current_page == $i + 1) {
                        echo '<li class="active"><a href="home.php?page=' . ($i
                                + 1) . '">' . ($i + 1) . '</a></li>';
                    } else {
                        echo '<li><a href="home.php?page=' . ($i + 1) . '">'
                            . ($i + 1) . '</a></li>';
                    }
                }
                ?>
                <li>
                    <a href="<?php echo
                    ($current_page + 1 > $number_pages) ? "home.php?page="
                        . $current_page
                        : "home.php?page=" . ($current_page + 1)
                    ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <li>
                    <span>Total de Registros: <strong><?= $total_contacts ?></strong></span>
                </li>
            </ul>
            </nav>
            <table class="table">
                <tr>
                    <th colspan="2">Contato</th>

                </tr>
                <?php

                foreach ($contacts as $contact) {
                    ?>
                    <tr>
                        <td><strong>
                                <a onclick="$('#contactName').html('<strong><?= $contact->name; ?></strong>'); showContact('<?= $contact->id; ?>');"
                                   title="Exibir informaÃ§Ãµes"
                                   style="cursor:pointer;" data-toggle="modal"
                                   data-target="#contactModal">
                                    <?= $contact->name; ?>
                                </a></strong>
                        </td>
                        <td style='text-align:center;'>
                            <a onclick="$('#contactName').html('Editar InformaÃ§Ãµes'); editContact('<?= $contact->id; ?>');"
                               title="Editar InformaÃ§Ãµes" data-toggle="modal"
                               data-target="#contactModal"><span
                                        class="glyphicon glyphicon-pencil icon"
                                        aria-hidden="true"></span></a>
                            <a title="Deletar Contato"
                               onclick="deleteContact('<?= $contact->id; ?>');"><span
                                        class="glyphicon glyphicon-trash icon"
                                        aria-hidden="true"></span></a>
                        </td>
                    </tr>
                    <?php
                }
                }
                ?>
            </table>
        </div>
        <!-- MODAL FOR SHOWING CONTACT'S ACTIONS -->
        <div class="modal fade" id="contactModal" tabindex="-1" role="dialog"
             aria-labelledby="contactName">
            <div class="modal-dialog" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="contactName"></h4>
                    </div>
                    <div class="modal-body">
                        <div id="show-box"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
unset($cnt_db);
?>
</body>

</html>



