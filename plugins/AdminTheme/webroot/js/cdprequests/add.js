$(document).ready(function () {
    $(".select2").css({"width": "100%"});
    $("#values-id").number(true, 2);
    $.each(itemsdata, function (i, add_item) {
        addItemsTable(add_item);
    });



    $("#formItems").keypress(function (e) {
        if (e.which == 13) {
            return false;
        }
    });

    $("#modal_add").on("click", function (e) {
        e.preventDefault();
        $("#myModal").modal("show");
    });

    $(".addItems").on("click", function (e) {
        e.preventDefault();
        add_item = {
            itemstypes: {
                id: $("#itemstypes-id").val(),
                name: $("#itemstypes-id option:selected").text()
            },
            classifications: {
                id: $("#classifications-id").val(),
                name: $("#classifications-id option:selected").text()
            },
            items: {
                id: $("#items-id").val(),
                name: $("#items-id option:selected").text()
            },
            resources: {
                id: $("#resources-id").val(),
                name: $("#resources-id option:selected").text()
            },
            value: $("#values-id").val()

        }

        validateItemsTable(add_item);

    });



    $("#itemstypes-id").on("change", function () {
        item_type_id = $(this).val();
        $("#classifications-id").html($("<option>", {
            value: "",
            text: "(Elegir)"
        })).trigger("change.select2");

        $.ajax({
            type: "POST",
            url: base_url + "itemclassification/" + item_type_id + ".json",
            data: {"": $(this).val()},
            success: function (datos) {
                $.each(datos.output, function (key, value) {

                    $("#classifications-id").append($("<option>", {
                        value: key,
                        text: value
                    }));
                });
                $("#classifications-id").trigger("change.select2");
            }
        });
    });




    $("#classifications-id").on("change", function () {
        items_id = $(this).val();
        $("#items-id").html($("<option>", {
            value: "",
            text: "(Elegir)"
        })).trigger("change.select2");

        $.ajax({
            type: "POST",
            url: base_url + "items/" + items_id + ".json",
            data: {"": $(this).val()},
            success: function (datos) {
                $.each(datos.output, function (key, value) {

                    $("#items-id").append($("<option>", {
                        value: value.id,
                        text: value.item + " " + value.name
                    }));
                });
                $("#items-id").trigger("change.select2");
            }
        });




    });



    $(".table-items").on("click", "a.trash", function () {

        var r = confirm("Elimiar Rubro");
        if (r == true) {
            $(this).parent("td").parent("tr").hide("slow").remove();
            data = jQuery.parseJSON($(this).parent("td").find(".itemsdata").val());
            itemsTotal = itemsTotal - data.value;
            valores(itemsTotal);
        }


    });


    $("#myModal").on("shown.bs.modal", function () {
        limpiar_form();
        $("#output").html("").removeClass();
    })

    $.fn.modal.Constructor.prototype.enforceFocus = function () {};


});

function validateItemsTable(add_item) {

    error = [];
    $("#output").removeClass();
    $("#output").html("Validando...").addClass("alert alert-info alert-dismissible");

    if (!$.isNumeric(add_item.classifications.id)) {
        error.push("Selecciona Cuenta o Proyecto");
    }
    if (!$.isNumeric(add_item.items.id)) {
        error.push("Selecciona Rubro");
    }
    if (!$.isNumeric(add_item.itemstypes.id)) {
        error.push("Selecciona Clase de Gasto");
    }
    if (!$.isNumeric(add_item.resources.id)) {
        error.push("Selecciona Recurso");
    }
    if (!$.isNumeric(add_item.value)) {
        error.push("Ingersa Valor");
    }

    $("#output").removeClass();
    $("#output").html("");

    if (error.length == 0) {
        addItemsTable(add_item);
        $("#output").addClass("alert alert-success alert-dismissible");
        $("#output").append("Item Agregado");
        limpiar_form();
    } else {
        $("#output").addClass("alert alert-danger alert-dismissible");
        $.each(error, function (index, value) {
            $("#output").append(value + "<br>");
        });
    }


}

function addItemsTable(add_item) {

    itemsTotal = parseFloat(itemsTotal) + parseFloat(add_item.value);

    trash = '<a class="btn btn-danger trash"><i class="fa fa-fw fa-trash"></i></a>';
            data = "<input type='hidden' class='itemsdata' name='itemsdata[]' value='" + JSON.stringify(add_item) + "'>";
    $(".table-items tbody").append("<tr><td>" + add_item.itemstypes.name + "</td><td>" + add_item.classifications.name + "</td><td>" + add_item.items.item + " " + add_item.items.name + "</td><td>" + add_item.resources.name + "</td><td class='valueFormat'>" + add_item.value + "</td><td>" + trash + data + "</td></tr>");

    valores(itemsTotal);
}

function valores(itemsTotal) {
    $(".totalItemsLetters").html(NumeroALetras(itemsTotal));
    $(".totalItems").html(itemsTotal);
    $(".valueFormat").number(true, 2);
}
function limpiar_form() {
    $("#values-id").val("");
    $("#formItems select").val("").trigger("change.select2");
}