<?php
$this->breadcrumbs=array(
	'Monedases'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Nueva Moneda', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('monedas-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Listado de Monedas</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'monedas-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'denominacion',
		'tasaCambioCompra',
		'tasaCambioVenta',
		'userStamp',
		'timeStamp',
		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
