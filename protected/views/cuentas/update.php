<?php
$this->breadcrumbs=array(
	'Cuentas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listar Cuentas', 'url'=>array('admin')),
	array('label'=>'Nueva Cuenta', 'url'=>array('create')),
);
?>

<h1>Modificar Cuenta Nro: <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>