<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cheques-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<script>
function MostrarCheque(){
alert($.fn.yiiGridView.getSelection("cheques-grid"));
/*$("#montoPorColocar").removeAttr('disabled');
$.ajax({
	type: 'POST',
	url: "<?php echo CController::createUrl('cheques/viewCheque')?>",
	data:{'id':$.fn.yiiGridView.getSelection("cheques-grid")},
	dataType: 'Text',
	success:function(data){
		var datos=data.split(";");
		$('#viewCheque').html(datos[0]);
		$("#montoPorColocar").val(datos[1]);
	}
});*/
}
</script>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cheques-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'selectableRows' => -1,
	'selectionChanged'=>'MostrarCheque',
	'columns'=>array(
	    array(
			'header'=>'Cheques seleccionados',
            'class'=>'CCheckBoxColumn',            
        ),
		'id',
		'operacionChequeId',
		'tasaDescuento',
		'fechaPago',
		'pesificacion',
		'numeroCheque',
		/*
		'libradorId',
		'bancoId',
		'montoOrigen',
		'fechaPago',
		'tipoCheque',
		'endosante',
		'montoNeto',
		'estado',
		'userStamp',
		'timeStamp',
		'sucursalId',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
