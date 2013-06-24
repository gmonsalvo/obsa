<?php
$this->breadcrumbs=array(
	'Operadores'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Nuevo Operador', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('operadores-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Listado de Operadores</h1>

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
	'id'=>'operadores-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'apynom',
		'direccion',
		'celular',
		'fijo',
		'documento',
		'email',
		'comision',
		array(
			'name'=>'usuarioId',
			'header'=>'Usuario',
			'value'=>'$data->getUser()',
		),
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