<?php
$this->breadcrumbs=array(
	'Bancos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Bancos', 'url'=>array('admin')),
	array('label'=>'Nuevo Banco', 'url'=>array('create')),
	array('label'=>'Modificar Banco', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Banco', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Esta seguro que desea eliminar este item?')),
);
?>

<h1>Detalle del Banco Nro: <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		array(
            'label' => 'Sucursal',
            'value' => $model->sucursal->nombre
        ),
	)
)); ?>
