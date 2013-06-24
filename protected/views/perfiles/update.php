<?php
$this->breadcrumbs=array(
	'Perfiles'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Listar Perfiles', 'url'=>array('index')),
	array('label'=>'Nuevo Perfil', 'url'=>array('create')),
	
);
?>

<h1>Actualizar Perfil #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>