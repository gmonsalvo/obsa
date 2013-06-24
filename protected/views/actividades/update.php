<?php
$this->breadcrumbs=array(
	'Actividades'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listar Actividades', 'url'=>array('admin')),
	array('label'=>'Nueva Actividad', 'url'=>array('create')),
	
);
?>

<h1>Modificar Actividad Nro: <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>