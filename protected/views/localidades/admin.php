<?php
$this->breadcrumbs=array(
	'Localidades'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Nueva Localidad', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('localidades-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Listado de Localidades</h1>

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
	'id'=>'localidades-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'descripcion',
		'userStamp',
		'timeStamp',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
