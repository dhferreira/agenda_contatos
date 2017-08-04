<?php

include('../class/Contact.php');
include('../class/Phone.php');
include('../class/Cnt_db.php');
include('../lib/util.php');

$cnt_db = new Cnt_db();
$db_conn = $cnt_db->conn;

switch ($_POST['action']) {

    //SHOW CONTACT INFORMATION
    case 'showContact':
        $id_contact = $_POST['id_contact'];
        $contact = new Contact($id_contact);

        echo '<div class="container-fluid">';
        echo empty($contact->email) ? null
            : "<strong>Email: </strong>" . $contact->email . "<br>";
        echo empty($contact->address) ? null
            : "<strong>Endereço: </strong>" . $contact->address . "<br>";
        $count = 1;

        foreach ($contact->phones as $phone) {
            echo "<strong>Telefone " . $count . ": </strong>";
            echo format_phone($phone->number);
            echo '<br/>';
            $count++;
        }
        echo '</div>';

        break;

    //DELETE CONTACT
    case 'deleteContact':
        $id_contact = $_POST['id_contact'];
        $contact = new Contact($id_contact);

        //DELETE PHONES
        if ($contact->delete()) {
            echo '1';
        } else {
            echo '0';
        }

        break;

    //SHOW FORM WITH CONTACT'S INFORMATION
    case 'editContact':
        $id_contact = $_POST['id_contact'];
        $contact = new Contact($id_contact);

        echo '<div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="form-horizontal" id="contact_form" method="POST" action="updateContact.php">
                            <input type="hidden" name="id_contact" value="'
            . $contact->id . '">
                            <div class="form-group row">
                                <label for="nameInput" class="col-sm-2 control-label">Nome</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="nameInput" name="name" placeholder="Nome" value="'
            . $contact->name . '" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="emailInput" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="emailInput" name="email" placeholder="example@example.com" value="'
            . $contact->email . '">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="addressInput" class="col-sm-2 control-label">Endereço</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="addressInput" name="address" placeholder="Endereço" value="'
            . $contact->address . '">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phoneDiv" class="col-sm-2 control-label">Telefone</label>
                                <div class="col-sm-10" id="phoneDiv">
                                    <div class="col-md-12" id="phones">';
        $count = 0;

        foreach ($contact->phones as $phone) {
            $count++;

            echo '                      <div class="phone-' . $count . ' row">
                                            <div class="input-group">
                                                <input type="text" class="form-control phone" id="phone-'
                . $count
                . '" name="phone[]" placeholder="(XX) XXXX-XXXX" style="margin-bottom: 15px;" value="'
                . $phone->number . '">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default fix" aria-hidden="true" onclick="removePhone(\'.phone-'
                . $count . '\');" title="Remover Número">
                                                        <span class="glyphicon glyphicon-minus" />
                                                    </button>
                                                </div>
                                            </div>
                                        </div>';
        }

        echo '
                                    </div>
                                    <input type="hidden" id="count" value="'
            . $count . '">
                                    <div>
                                        <button type="button" class="btn btn-default" aria-hidden="true" onclick="addPhone();" style="height: 34px;" title="Novo Número"><span class="glyphicon glyphicon-plus" /></button>
                                    </div>
                                </div>
                            </div><br/>
                            <div class="row" style="text-align: center;">
                                <button class="btn btn-success" type="submit">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    Gravar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
              </div>';

}
