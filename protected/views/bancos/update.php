<?php
$this->breadcrumbs=array(
	'Bancos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listar Bancos', 'url'=>array('admin')),
	array('label'=>'Nuevo Banco', 'url'=>array('create')),
);
?>

<h1>Modificar Banco Nro: <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>