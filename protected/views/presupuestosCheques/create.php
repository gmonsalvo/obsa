<?php
$this->breadcrumbs=array(
	'Presupuestos Cheques'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PresupuestosCheques', 'url'=>array('index')),
	array('label'=>'Manage PresupuestosCheques', 'url'=>array('admin')),
);
?>

<h1>Create PresupuestosCheques</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>