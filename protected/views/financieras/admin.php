<?php
$this->breadcrumbs=array(
	'Financieras'=>array('index'),
	'Administrar',
);

$this->menu=array(
	//array('label'=>'Listar Financieras', 'url'=>array('index')),
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
<!--
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
-->
<!--<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>-->
<br>
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
		'responsable',
		'celular',
		/*
		'email',
		'tasaPromedio',
		'diasClearing',
		'tasaPesificacion',
		'userStamp',
		'timeStamp',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
