<?php
$this->breadcrumbs=array(
	'Ordenes Cambios'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrdenesCambio', 'url'=>array('index')),
	array('label'=>'Create OrdenesCambio', 'url'=>array('create')),
	array('label'=>'View OrdenesCambio', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrdenesCambio', 'url'=>array('admin')),
);
?>

<h1>Update OrdenesCambio <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>