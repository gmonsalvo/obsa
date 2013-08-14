<?php
$this->breadcrumbs=array(
	'Ctactes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Ctacte', 'url'=>array('index')),
	array('label'=>'Create Ctacte', 'url'=>array('create')),
	array('label'=>'View Ctacte', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Ctacte', 'url'=>array('admin')),
);
?>

<h1>Update Ctacte <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>