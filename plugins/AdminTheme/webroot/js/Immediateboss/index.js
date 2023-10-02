/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$(document).ready(function () {
    $("select").select2({language: "es"}).on("change", function (e) {
        $("select").select2().prop("disabled", true);
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: base_url + $(this).attr("id") + ".json",
            data: {"immediate_boss_id": $(this).val()},
            success: function (datos) {
                $("select").select2().prop("disabled", false);
                $("#id_" + datos.output.id).css({"display": "none"});
            },
            error: function () {
                alert("Unable to contact server");
            }
        });
    });
});