<?php
$this->breadcrumbs=array(
	'Financieras'=>array('index'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Listar Financieras', 'url'=>array('index')),
	array('label'=>'Nueva Financiera', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('financieras-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Financieras</h1>


<?php echo CHtml::link(CHtml::encode('Búsqueda Avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'financieras-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		'direccion',
		'telefono',
		'tasaPromedio',
		'diasClearing',
		'tasaPesificacion',
		array(
			'header'=>'Responsables',
			'name'=>'responsablesBusqueda',
			'type'=>'raw',
			'value'=>array($this, 'dibujarCeldaResponsablesGrilla'),
		),
		array(
			'header'=>'Productos',
			'name'=>'productosBusqueda',
			'type'=>'raw',
			'value'=>array($this, 'dibujarCeldaProductosGrilla'),
		),
		/*
		'userStamp',
		'timeStamp',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
