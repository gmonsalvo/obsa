<?php
$this->breadcrumbs=array(
	'Recibos Detalles'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RecibosDetalle', 'url'=>array('index')),
	array('label'=>'Create RecibosDetalle', 'url'=>array('create')),
	array('label'=>'View RecibosDetalle', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RecibosDetalle', 'url'=>array('admin')),
);
?>

<h1>Update RecibosDetalle <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>