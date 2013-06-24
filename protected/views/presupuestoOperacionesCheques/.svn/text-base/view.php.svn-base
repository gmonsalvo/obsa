<?php
$this->breadcrumbs=array(
	'Presupuesto Operaciones Cheques'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PresupuestoOperacionesCheques', 'url'=>array('index')),
	array('label'=>'Create PresupuestoOperacionesCheques', 'url'=>array('create')),
	array('label'=>'Update PresupuestoOperacionesCheques', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PresupuestoOperacionesCheques', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PresupuestoOperacionesCheques', 'url'=>array('admin')),
);
?>

<h1>View PresupuestoOperacionesCheques #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'operadorId',
		'clienteId',
		'montoNetoTotal',
		'estado',
		'fecha',
		'userStamp',
		'timeStamp',
		'sucursalId',
	),
)); ?>
