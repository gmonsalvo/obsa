<?php
$this->breadcrumbs=array(
	'Responsables'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Listar Responsables', 'url'=>array('index')),
	array('label'=>'Nuevo Responsable', 'url'=>array('create')),
	array('label'=>'Ver Responsable', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Responsables', 'url'=>array('admin')),
);
?>

<h1>Actualizar Responsable <?php echo $model->nombre; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>