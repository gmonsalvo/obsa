<?php
$this->breadcrumbs=array(
	'Ctactes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Ctacte', 'url'=>array('index')),
	array('label'=>'Manage Ctacte', 'url'=>array('admin')),
);
?>

<h1>Create Ctacte</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>