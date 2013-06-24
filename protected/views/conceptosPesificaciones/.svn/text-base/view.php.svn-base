<?php
$this->breadcrumbs=array(
	'Conceptos Pesificaciones'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ConceptosPesificaciones', 'url'=>array('index')),
	array('label'=>'Create ConceptosPesificaciones', 'url'=>array('create')),
	array('label'=>'Update ConceptosPesificaciones', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ConceptosPesificaciones', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ConceptosPesificaciones', 'url'=>array('admin')),
);
?>

<h1>View ConceptosPesificaciones #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'sucursalId',
		'userStamp',
		'timeStamp',
	),
)); ?>
