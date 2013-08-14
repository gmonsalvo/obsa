<?php
$this->breadcrumbs=array(
	'Productoctactes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Productoctacte', 'url'=>array('index')),
	array('label'=>'Manage Productoctacte', 'url'=>array('admin')),
);
?>

<h1>Create Productoctacte</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>