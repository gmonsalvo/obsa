<?php
$this->breadcrumbs=array(
	'Pesificadores'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Nuevo Pesificador', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('pesificadores-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Listado de Pesificadores</h1>

<p>
Ademas podes ingresas un operador de comparacion (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) al comienzo de cada parametro de busqueda.
</p>

<?php echo CHtml::link('Busqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pesificadores-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'denominacion',
		'tasaDescuento',
		'direccion',
		'personaContacto',
		'telefono',
		array(
			'name'=>'sucursalId',
			'header'=>'Sucursal',
			'value'=>'$data->sucursal->nombre',
		),
		'userStamp',
		'timeStamp',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
