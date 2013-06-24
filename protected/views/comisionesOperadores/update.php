<?php
$this->breadcrumbs=array(
	'Comisiones Operadores'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ComisionesOperadores', 'url'=>array('index')),
	array('label'=>'Create ComisionesOperadores', 'url'=>array('create')),
	array('label'=>'View ComisionesOperadores', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ComisionesOperadores', 'url'=>array('admin')),
);
?>

<h1>Update ComisionesOperadores <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>