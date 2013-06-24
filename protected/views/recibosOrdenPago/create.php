<?php
$this->breadcrumbs=array(
	'Recibos Orden Pagos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RecibosOrdenPago', 'url'=>array('index')),
	array('label'=>'Manage RecibosOrdenPago', 'url'=>array('admin')),
);
?>

<h1>Create RecibosOrdenPago</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>