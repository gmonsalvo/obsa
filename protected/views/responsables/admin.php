<?php
$this->breadcrumbs=array(
	'Responsables'=>array('index'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Listar Responsables', 'url'=>array('index')),
	array('label'=>'Nuevo Responsable', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('responsables-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Responsables</h1>

<?php echo CHtml::link(CHtml::encode('Búsqueda Avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'responsables-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		'email',
		'celular',
		'fijo',
		/*
		'userStamp',
		'timeStamp',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
