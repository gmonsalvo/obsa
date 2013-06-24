<?php
$this->breadcrumbs=array(
	'Forma Pago Orden Proveedores'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List FormaPagoOrdenProveedores', 'url'=>array('index')),
	array('label'=>'Create FormaPagoOrdenProveedores', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('forma-pago-orden-proveedores-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Forma Pago Orden Proveedores</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'forma-pago-orden-proveedores-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'ordenPagoId',
		'monto',
		'tipoFormaPago',
		'formaPagoId',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
