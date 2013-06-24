<?php
$this->breadcrumbs=array(
	'Operaciones Cambios'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List OperacionesCambio', 'url'=>array('index')),
	array('label'=>'Create OperacionesCambio', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('operaciones-cambio-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Listado Operaciones Cambios</h1>

<p>
Ademas podes ingresas un operador de comparacion (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
o <b>=</b>) al comienzo de cada parametro de busqueda.
</p>


<?php echo CHtml::link('Busqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'operaciones-cambio-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'clienteId',
		'monedaId',
		'monto',
		'tipoOperacion',
		'userStamp',
		/*
		'timeStamp',
		'sucursalId',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
