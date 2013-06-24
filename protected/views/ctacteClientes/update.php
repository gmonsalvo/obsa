<?php
$this->breadcrumbs=array(
	'Ctacte Clientes'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listar Movimientos', 'url'=>array('admin')),
	array('label'=>'Nuevo Movimiento', 'url'=>array('create')),
);
?>

<h1>Modificar Movimiento Nro: <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>