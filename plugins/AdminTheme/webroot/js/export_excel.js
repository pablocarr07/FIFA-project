$(document).ready(function () {
		form_export ='<form action="http://serviciodeempleo.gov.co/fifa/home/export_excel/" method="post" target="_blank" id="FormularioExportacion"><input type="hidden" id="data" name="data" /><input type="hidden" id="filename" name="filename" /></form>';
		$('body').append(form_export);
	$(".export_excel").on('click',function(e){
		e.preventDefault();
		$('#data').val(export_excel.data);
		$('#filename').val(export_excel.filename);
		$('#FormularioExportacion').submit();
	});
});