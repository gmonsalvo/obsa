<?php
$this->breadcrumbs=array(
	'Tmp Cheques'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TmpCheques', 'url'=>array('index')),
	array('label'=>'Create TmpCheques', 'url'=>array('create')),
	array('label'=>'Update TmpCheques', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TmpCheques', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TmpCheques', 'url'=>array('admin')),
);
?>

<h1>View TmpCheques #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
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
	),
)); ?>
