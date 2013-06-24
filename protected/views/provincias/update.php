<?php
$this->breadcrumbs=array(
	'Provinciases'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Listar Provincias', 'url'=>array('index')),
	array('label'=>'Nueva Provincias', 'url'=>array('create')),
);
?>

<h1>Modificando Provincia <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>