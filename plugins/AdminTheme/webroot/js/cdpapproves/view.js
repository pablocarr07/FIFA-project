
acciones = {
    "aprobar": {
        "label": "Aprobar",
        "accion": "approve.json"
    },
    "cancelar": {
        "label": "Cancelar",
        "accion": "cancel.json"
    },
    "modificar": {
        "label": "Solicitar Modifición",
        "accion": "update.json"
    }
}

var itemsTotal = 0;


id_accion = "";
$(document).ready(function () {

    $.each(itemsdata, function (i, add_item) {
        addItemsTable(add_item);
    });

    $("select").select2("enable", true);

    $(".accion").on("click", function (e) {
        e.preventDefault();
        id_accion = $(this).attr("id");
        $("#accion_label").html(acciones[id_accion].label);
        $("#form").attr({"action": base_url + acciones[id_accion].accion});
        $("#myModal").modal("show");
    });
    $("#form").on("submit", function (e) {
        $(".alert").removeClass("alert-info alert-success alert-danger");
        $(".alert").addClass("alert-info").html("Enviando...");
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (datos) {
                $(".alert").removeClass("alert-info alert-success alert-danger");
                if (datos.output.success) {
                    $(".alert").addClass("alert-success").html(datos.output.message);
                } else {
                    $(".alert").addClass("alert-danger").html(datos.output.message);
                }
            }
        });
    });


    $("#myModal").on("hide.bs.modal", function (e) {
        location.reload();
    });

});



function addItemsTable(add_item) {

    itemsTotal = parseFloat(itemsTotal) + parseFloat(add_item.value);
    //data = \'<input type="hidden" class="itemsdata" name="itemsdata[]" value="\'+JSON.stringify(add_item)+\'">\';
    data = "<input type=\'hidden\' class=\'itemsdata\' name=\'itemsdata[]\' value=\'" + JSON.stringify(add_item) + "\'>";
    $(".table-items tbody").append("<tr><td>" + add_item.itemstypes.name + "</td><td>" + add_item.classifications.name + "</td><td>" + add_item.items.item + " " + add_item.items.name + "</td><td>" + add_item.resources.name + "</td><td class=\'valueFormat\'>" + add_item.value + "</td></tr>");

    valores(itemsTotal);
}

function valores(itemsTotal) {
    $(".totalItemsLetters").html(NumeroALetras(itemsTotal));
    $(".totalItems").html(itemsTotal);
    $(".valueFormat").number(true, 2);
}