<?php
$this->breadcrumbs=array(
	'Recibos Orden Pagos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RecibosOrdenPago', 'url'=>array('index')),
	array('label'=>'Create RecibosOrdenPago', 'url'=>array('create')),
	array('label'=>'Update RecibosOrdenPago', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RecibosOrdenPago', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RecibosOrdenPago', 'url'=>array('admin')),
);
?>

<h1>View RecibosOrdenPago #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ordenPagoId',
		'fecha',
		'montoTotal',
		'userStamp',
		'timeStamp',
	),
)); ?>
