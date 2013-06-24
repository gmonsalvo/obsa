<?php
$this->breadcrumbs=array(
	'Socios'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Volver a la hoja del librador', 'url'=>array('/libradores/view','id'=>$model->libradorId)),
);
?>

<h1>Detalle del Socio Nro: <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'label'=>'libradorId',
			'value'=>$model->librador->denominacion,
		),
		//'libradorId',
		'documento',
		'apellidoNombre',
	),
)); ?>
