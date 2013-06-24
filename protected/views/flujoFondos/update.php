<?php
$this->breadcrumbs=array(
	'Flujo de Fondos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listar Flujo de Fondos', 'url'=>array('admin')),
	array('label'=>'Nuevo Flujo de Fondos', 'url'=>array('create')),
);
?>

<h1>Modificar Flujo de Fondos <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>