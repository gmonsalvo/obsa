<?php
$this->breadcrumbs=array(
	'Conceptos'=>array('index'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Nuevo Concepto', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('conceptos-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Listado de Conceptos</h1>

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

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'conceptos-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
                'id',
		'nombre',
		array(
                    'name'=>'tipoConcepto',
                    'header'=>'Tipo Concepto',
                    'value'=>'$data->getTypeDescription()',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
