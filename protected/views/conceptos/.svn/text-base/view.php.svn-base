<?php
$this->breadcrumbs=array(
	'Conceptos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Conceptos', 'url'=>array('admin')),
	array('label'=>'Nuevo Concepto', 'url'=>array('create')),
	array('label'=>'Modificar Concepto', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Concepto', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Esta seguro que desea eliminar este item?')),
);
?>

<h1>Detalle del Concepto Nro: <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
            	array(
                    'name'=>'tipoConcepto',
                    'value'=>$model->getTypeDescription(),
		),
	),
)); ?>
