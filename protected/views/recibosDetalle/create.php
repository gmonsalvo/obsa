<?php
$this->breadcrumbs=array(
	'Recibos Detalles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RecibosDetalle', 'url'=>array('index')),
	array('label'=>'Manage RecibosDetalle', 'url'=>array('admin')),
);
?>

<h1>Create RecibosDetalle</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>