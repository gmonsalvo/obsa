<?php
$this->breadcrumbs=array(
	'Ordenes Cambios'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OrdenesCambio', 'url'=>array('index')),
	array('label'=>'Manage OrdenesCambio', 'url'=>array('admin')),
);
?>

<h1>Create OrdenesCambio</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>