<?php
$this->breadcrumbs=array(
	'Financieras'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Financieras', 'url'=>array('index')),
	array('label'=>'Nueva Financiera', 'url'=>array('create')),
	array('label'=>'Actualizar Financiera', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Financiera', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>CHtml::encode('Está seguro de que desea eliminar este item?'))),
	array('label'=>'Administrar Financieras', 'url'=>array('admin')),
);
?>

<h1>Detalle Financiera #<?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'direccion',
		'telefono',
		'responsable',
		'celular',
		'email',
		'tasaPromedio',
		'diasClearing',
		'tasaPesificacion',
		//'userStamp',
		//'timeStamp',
	),
)); ?>
