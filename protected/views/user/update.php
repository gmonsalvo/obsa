<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Listar Usuarios', 'url'=>array('admin')),
	array('label'=>'Nuevo Usuario', 'url'=>array('create'))
);
?>

<h1>Moficando Usuario # <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>