<?php
$this->breadcrumbs=array(
	'Sucursales'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Listar Sucursales', 'url'=>array('admin')),
	array('label'=>'Nueva Sucursal', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sucursales-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Listado de Sucursales</h1>

<p>
Ademas podes ingresas un operador de comparacion (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
o <b>=</b>) al comienzo de cada parametro de busqueda.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sucursales-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		'direccion',
		'email',
		'comisionGeneral',
		'tasaDescuentoGeneral',
		/*
		'tasaInversores',
		'tasaPesificacion',
		'diasClearing',
		'userStamp',
		'timeStamp',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
