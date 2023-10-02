$(document).ready(function () {
    $("#reportdetallado,#reportgeneral,#filtro,#descargar").hide();
    $("select").select2({language: "es"}).on("change", function (e) {
        if (this.id == "dependency") {
            //groups(this.value);
            groups($(this,":selected").val());
        } else if (this.id == "group") {
            subgroup(this.value);
        }
    });

    $("#formasivasugasto").on("submit", function (e) {
        e.preventDefault();
        $("#progress-bar").show();
        $("#reportdetallado tbody,#reportgeneral tbody").html("");
        $.ajax({
            type: "POST",
            url: base_url + "getReports.json",
            data: $(this).serialize(),
            success: function (datos) {
                if ($("#typereport").val() == "general") {
                    $("#reportgeneral").show();
                    $("#reportdetallado").hide();
                    console.log(datos)
                    $.each(datos.output, function (i, v) {
                        $("#reportgeneral tbody").append("<tr><td>" + i + "</td><td class='valueFormat'>" + v.totalRp + "</td><td class='valueFormat'>" + v.totalPagado + "</td></tr>");
                    });
					export_excel.data = '<table>'+$("#reportgeneral").html()+'</table>';

                } else if ($("#typereport").val() == "detallado") {
                    $("#reportgeneral").hide();
                    $("#reportdetallado").show();
                    $.each(datos.output, function (i, v) {
                        $("#reportdetallado tbody").append("<tr><td>" + v.documento_soporte + "</td><td>" + v.numero_documento + "</td><td>" + v.tercero + "</td><td>" + v.fecha + "</td><td>" + v.rubro_descripcion + "</td><td class='valueFormat'>" + v.valorRp + "</td><td class='valueFormat'>" + v.valorPagado + "</td><td>" + v.concepto + "</td></tr>");
                    });
					export_excel.data = '<table>'+$("#reportdetallado").html()+'</table>';
                }
                $("#progress-bar").hide();
                $("#formasivasugasto").hide("slow");
                $("#filtro").show("slow");
                $(".valueFormat").number(true, 2);
				$("#descargar").show("slow");
            }
        });
    });

    $("#filtro").on("click", function () {
        $("#formasivasugasto").show("slow");
        $("#filtro").hide("slow");
    });

});
function groups(dependencyId) {
    $("#group").html($("<option>", {
        value: "",
        text: "(choose group)"
    })).trigger("change.select2");

    if (dependencyId.length > 0) {
        $.ajax({
            type: "POST",
            url: base_url + "getGroups/",
            data: {id: dependencyId},
            success: function (datos) {
                $.each(datos.groups, function (key, value) {

                    $("#group").append($("<option>", {
                        value: value.id,
                        text: value.name
                    }));
                });
                $("#group").trigger("change.select2");
            }
        });
    }
}
;

function subgroup(groupId) {
    $("#subgroup").html($("<option>", {
        value: "",
        text: "(choose group)"
    })).trigger("change.select2");
    ;
    if (groupId.length > 0) {
        $.ajax({
            type: "POST",
            //url: "'.$this->name.'/getSubGroups/",
            url: base_url + "getSubGroups/",
            data: {id: groupId},
            success: function (datos) {
                $.each(datos.groups, function (key, value) {
                    $("#subgroup").append($("<option>", {
                        value: value.id,
                        text: value.name
                    }));
                });
                $("#subgroup").trigger("change.select2");
            }
        });
    }
}