<?php 
$tr_items='';
$tr_items_total=0;
$comentary='';
foreach($timeline as $t){
$comentary.='<p>
<strong> '.$t['created_by']['name'].'</strong> 
Cambio el Estado del CDP a '.$t['cdpsstate']['name'].'
Hace '.$t['created'].'
<br>'. $t['commentary'].'</p>';
}





foreach($items as $item){
$tr_items.=
  '<tr>
    <td>'.$item['itemstypes']['name'].'</td>
    <td>'.$item['classifications']['name'].'</td>
    <td>'.$item['items']['name'].'</td>
    <td>'.$item['resources']['name'].'</td>
    <td>'.$item['value'].'</td>
  </tr>';
$tr_items_total+=$item['value'];
}
?>


<!DOCTYPE html>
<html>
<head>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
</style>
</head>
<body>

<h2><b>Apreciado Usuario,</b></h2>
<p>La solicitud de CDP <?= $cdp ?> cambio a estado <?= $estado ?> <?= $complemento ?>.:</p>
<p><strong>Solicitante:</strong></p>
<p><?= $solicitante ?></p>
<p><strong>Creado Por:</strong></p>
<p><?= $creado_por ?></p>
<p><strong>Tipo de Movimiento:</strong></p>
<p><?= $tipo_movimiento ?></p>
<p><strong>Objeto:</strong></p>
<p><?= $objecto ?></p>
<p><strong>Justificación:</strong></p>
<p><?= $justificacion ?></p>
<p><strong>Items:</strong></p>
<table>
<thead>
  <tr>
    <th>Clase de Gasto</th>
	<th>Rubro Agregado</th>
	<th>Rubro Desagregado</th>
    <th>Recurso</th>
    <th>Valor</th>
  </tr>
</thead>
<tbody>
 <?= $tr_items ?>
</tbody>
 <tfoot>  
    <tr>
        <td colspan="4"></td>
            <td class="valueFormat totalItems"><?= $tr_items_total ?></td>
    </tr>
 </tfoot>
</table>
<p><strong>Timeline:</strong></p>
<?= $comentary ?>
</body>
</html>