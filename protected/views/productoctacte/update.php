<?php
$this->breadcrumbs=array(
	'Productoctactes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Productoctacte', 'url'=>array('index')),
	array('label'=>'Create Productoctacte', 'url'=>array('create')),
	array('label'=>'View Productoctacte', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Productoctacte', 'url'=>array('admin')),
);
?>

<h1>Update Productoctacte <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>