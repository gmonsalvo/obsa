<?php
$this->breadcrumbs=array(
	'Ordenes Pagos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrdenesPago', 'url'=>array('index')),
	array('label'=>'Create OrdenesPago', 'url'=>array('create')),
	array('label'=>'View OrdenesPago', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrdenesPago', 'url'=>array('admin')),
);
?>

<h1>Update OrdenesPago <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>