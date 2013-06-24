<?php
$this->breadcrumbs=array(
	'Forma Pago Ordens'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FormaPagoOrden', 'url'=>array('index')),
	array('label'=>'Create FormaPagoOrden', 'url'=>array('create')),
	array('label'=>'View FormaPagoOrden', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage FormaPagoOrden', 'url'=>array('admin')),
);
?>

<h1>Update FormaPagoOrden <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>