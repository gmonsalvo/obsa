<?php
$this->breadcrumbs=array(
	'Presupuestos Cheques'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PresupuestosCheques', 'url'=>array('index')),
	array('label'=>'Create PresupuestosCheques', 'url'=>array('create')),
	array('label'=>'Update PresupuestosCheques', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PresupuestosCheques', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PresupuestosCheques', 'url'=>array('admin')),
);
?>

<h1>View PresupuestosCheques #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'operacionChequeId',
		'tasaDescuento',
		'clearing',
		'pesificacion',
		'numeroCheque',
		'libradorId',
		'bancoId',
		'montoOrigen',
		'fechaPago',
		'tipoCheque',
		'endosante',
		'montoNeto',
		'estado',
		'userStamp',
		'timeStamp',
		'sucursalId',
		'montoGastos',
		'tieneNota',
		'comisionado',
	),
)); ?>
