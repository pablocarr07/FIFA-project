/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    modalcreate();
    $(".timelinecdprequests").on("click", function (e) {
        e.preventDefault();
        $('#view-modal').modal('show');// hide loader  
        $('#dynamic-content').html('Cargando...'); 
        $.ajax({
            type: "GET",
            url: $(this).attr("href")
        }).done(function (data) {
            $('#dynamic-content').html(''); // blank before load.
            $('#dynamic-content').html(data); // load here
           })
                .fail(function () {
                    $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                    $('#modal-loader').hide();
                });
        ;
    })
});

function modalcreate(){
    html = '<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+
  '<div class="modal-dialog modal-lg"> '+
     '<div class="modal-content">'+
        '<div class="modal-header">'+ 
           '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'+
           '<h4 class="modal-title">'+
           '<i class="glyphicon glyphicon-clock"></i> Timeline'+
           '</h4> '+
        '</div> '+            
        '<div class="modal-body">'+
           '<div id="dynamic-content"></div>'+
        '</div>'+
        '<div class="modal-footer">'+
        '</div>'+   
    '</div>'+
 '</div>'+
'</div>';
$("body").append(html);
}