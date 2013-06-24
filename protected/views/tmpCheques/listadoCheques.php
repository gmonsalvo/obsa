<?php $operacionesCheques = new OperacionesCheques();
$operacionesCheques->init();
?>
<script>$("#OperacionesCheques_montoNetoTotal").val("<?php echo $operacionesCheques->montoNetoTotal?>");</script>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tmp-cheques-grid', {
		data: $(this).serialize()
	});
	return false;
});
");


$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'',
			));
			 echo "<b>Cheques de la Operacion</b>";
		    $this->endWidget();
?>


<?php //echo var_dump($tmpcheque->getErrors());?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tmp-cheques-grid',
	'dataProvider'=>$tmpcheque->searchByUserName(),
	'filter'=>$tmpcheque,
	'columns'=>array(
		'numeroCheque',
		array(
			'name'=>'libradorId',
			'header'=>'Librador',
			'value'=>'$data->librador->denominacion',
		),
		array(
			'name'=>'fechaPago',
			'header'=>'Vencim.',
			'value'=>'$data->fechaPago',
		),
		array(
			'name'=>'montoOrigen',
			'header'=>'Importe',
			'value'=>'$data->montoOrigen',
		),
		array(
			'name'=>'descuentoTasa',
			'header'=>'Desc. Valor',
			'value'=>'$data->descuentoTasa',
		),
		array(
			'name'=>'tasaDescuento',
			'header'=>'Desc. Tasa',
			'value'=>'$data->tasaDescuento',
		),
		array(
			'name'=>'descuentoPesific',
			'header'=>'Pesific. Valor',
			'value'=>'$data->descuentoPesific',
		),
		array(
			'name'=>'pesificacion',
			'header'=>'Pesific. tasa',
			'value'=>'$data->pesificacion',
		),
		array(
			'name'=>'montoNeto',
			'header'=>'Valor Final',
			'value'=>'$data->montoNeto',
		),
		array(
			'class'=>'CButtonColumn',
			'header'=>'Opciones',
            'template'=>'{Eliminar}',
			'buttons'=>array(
			 'Eliminar'=>array(
				'label'=>'Eliminar',
				'url'=>'Yii::app()->createUrl("/tmpCheques/deleteCheque", array("id" => $data->id))',
				'options'=>array(  // this is the 'html' array but we specify the 'ajax' element
					'class'=>'cssGridButton',
				),
				'click' => 'js:function() {EliminarCheque( $(this).attr("href") ); return false;}'
			)),
			/*'afterDelete'=>'function(link,success,data){ if(success){
			alert("HOLAAAA");
			$("#chequestemporales").html(data); }}',
			'viewButtonUrl'=>'Yii::app()->createUrl("/tmpCheques/view", array("id" => $data->id))',
			'deleteButtonUrl'=>'Yii::app()->createUrl("/tmpCheques/deleteCheque", array("id" => $data->id))',
			'updateButtonUrl'=>'Yii::app()->createUrl("/tmpCheques/update", array("id" => $data->id))',*/
		),
	)
));
?>

<br>
