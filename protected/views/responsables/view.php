<?php
$this->breadcrumbs=array(
	'Responsables'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Responsables', 'url'=>array('index')),
	array('label'=>'Nuevo Responsable', 'url'=>array('create')),
	array('label'=>'Actualizar Responsable', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Responsable', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>CHtml::encode('¿Está seguro de que desea eliminar este registro?'))),
	array('label'=>'Administrar Responsables', 'url'=>array('admin')),
);
?>

<h1>Ver Responsable: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'email',
		'celular',
		'fijo',
		array(
	       'label'=>'Financieras',
	       'type'=>'raw',
	       'value'=>$this->dibujarCeldaLista($model),
        ),
	),
)); ?>
