/**
 * AJAX CALL FOR SHOWING CONTACT INFORMATION
 */
function showContact(id_contact) {
    $.ajax
    ({
        cache: false,
        type: "POST",
        url: "ajax/main.ajax.php",
        data: {
            id_contact: id_contact,
            action: "showContact"
        },
        success: function (data) {
            $("#show-box").html(data);
            $("#show-box").show();
        }
    });
}

/**
 * AJAX CALL FOR DELETING CONTACT
 */
function deleteContact(id_contact) {
    if (confirm("VocÃª deseja excluir este contato?")) {
        $.ajax
        ({
            cache: false,
            type: "POST",
            url: "ajax/main.ajax.php",
            data:
                {
                    id_contact: id_contact,
                    action: "deleteContact"
                },
            success: function (data) {
                if (data == '1') {
                    alert('Contato excluido com sucesso');
                    location.reload();
                }
                else {
                    alert('NÃ£o foi possÃ­vel excluir o contato');
                }
            }
        });
    }
}

/**
 * AJAX CALL FOR EDITING CONTACT INFORMATION
 */
function editContact(id_contact) {
    $.ajax
    ({
        cache: false,
        type: "POST",
        url: "ajax/main.ajax.php",
        data: {
            id_contact: id_contact,
            action: "editContact"
        },
        success: function (data) {
            $("#show-box").html(data);
            $("#show-box").show();
        }
    });
}

$(document).ready(function () {
    var count = $('#count').val();

    /**
     * FORMATING PHONE NUMBER
     */
    var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

    $('.phone').mask(SPMaskBehavior, spOptions);
});

/**
 * CREATE A NEW INPUT FOR PHONE NUMBER INTO FORMS
 */
function addPhone() {
    var count = $('#count').val();
    count++;

    var element = ' <div class="phone-' + count + ' row">' +
        '<div class="input-group">' +
        '<input type="text" class="form-control phone" id="phone-' + count + '" name="phone[]" placeholder="(XX) XXXX-XXXX" style="margin-bottom: 15px;">' +
        '<div class="input-group-btn">' +
        '<button type="button" class="btn btn-default fix" aria-hidden="true" onclick="removePhone(\'.phone-' + count + '\');" title="Remover NÃºmero">' +
        '<span class="glyphicon glyphicon-minus" />' +
        '</button>' +
        '</div>' +
        '</div>' +
        '</div>';
    $('#phones').append(element);
    $('#count').val(count);
}

/**
 * REMOVE A INPUT PHONE NUMBER FROM FORMS
 */
function removePhone(element) {
    $(element).remove();
}
