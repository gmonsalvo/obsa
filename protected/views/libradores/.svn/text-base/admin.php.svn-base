<?php
$this->breadcrumbs=array(
	'Libradores'=>array('index'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Listar Libradores', 'url'=>array('admin')),
	array('label'=>'Nuevo Librador', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('libradores-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Listado de Libradores</h1>

<p>
Ademas puede ingresar un operador de comparacion (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
o <b>=</b>) al comienzo de cada parametro de busqueda.
</p>

<?php echo CHtml::link('Busqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<style>
.grid-view table.items tr.clase {
    background: none repeat scroll 0 0 #AAA1F4;
}
</style>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'libradores-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'rowCssClassExpression'=>'$data->localidadId==1 ? "clase" : "even"',
	'columns'=>array(
		'id',
		'documento',
		'denominacion',
		'direccion',
		array(
		      'name'=>'localidadId',
		      'header'=>'Localidad',
		      'value'=>'$data->localidad->descripcion',
		),
		array(
			'name'=>'provinciaId',
			'header'=>'Provincia',
			'value'=>'$data->provincia->descripcion',
		),
		array(
			'name'=>'actividadId',
			'header'=>'Actividad',
			'value'=>'$data->actividad->descripcion',
		),
		'montoMaximo',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
