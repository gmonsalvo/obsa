<?php
$this->breadcrumbs=array(
	'Clientes'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Clientes', 'url'=>array('admin')),
	array('label'=>'Nuevo Cliente', 'url'=>array('create')),
	array('label'=>'Modificar este Cliente', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar este Cliente', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Esta seguro que desea eliminar este cliente?'))
,
);
?>

<h1>Detalle del Cliente <?php echo $model->razonSocial; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'razonSocial',
		'fijo',
		'celular',
		'direccion',
		array(
			'name'=>'localidadId',
			'value'=>$model->localidad->descripcion,
		),
		array(
			'name'=>'ProvinciaId',
			'value'=>$model->provincia->descripcion,
		),
		'email',
		'documento',
		'tasaInversor',
		array(
			'name'=>'tipoCliente',
			'value'=>$model->getTypeDescription(),
		),
		array(
			'name'=>'operadorId',
			'value'=>$model->operador->apynom,
		),
		array(
			'name'=>'sucursal',
			'value'=>$model->sucursal->nombre,
		),
		'tasaTomador',
		'montoMaximoTomador',
                'montoPermitidoDescubierto',
		array(
	       'label'=>'Productos',
	       'type'=>'raw',
	       'value'=>$this->dibujarCeldaProductosLista($model),
        ),
	),
)); ?>

<?php
if($model->tipoCliente==0 || $model->tipoCliente==2) //tomador o tomador/inversor
{

$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'',
			));
			 echo "<b>APODERADOS</b>";
		    $this->endWidget();
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'apoderados-grid',
	'dataProvider'=>$apoderados->searchByClienteId($model->id),
	'filter'=>$apoderados,
	'columns'=>array(
		'id',
		'documento',
		'apellidoNombre',

		array(
			'class'=>'CButtonColumn',
			'viewButtonUrl'=>'Yii::app()->createUrl("/apoderados/view", array("id" => $data->id))',
			'deleteButtonUrl'=>'Yii::app()->createUrl("/apoderados/delete", array("id" => $data->id))',
			'updateButtonUrl'=>'Yii::app()->createUrl("/apoderados/update", array("id" => $data->id))',
		),
	),
));
echo CHtml::button('Nuevo Apoderado',array("submit"=>array('apoderados/create', 'clienteId'=>$model->id, 'razonSocial'=>$model->razonSocial), 'csrf'=>true));  
}
if($model->tipoCliente==1 || $model->tipoCliente==2)
{
$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'',
			));
			 echo "<b>BENEFICIARIOS</b>";
		    $this->endWidget();

?>
<?php
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'beneficiarios-grid',
	'dataProvider'=>$beneficiarios->searchByClienteId($model->id),
	'filter'=>$beneficiarios,
	'columns'=>array(
		'id',
		'documento',
		'apellidoNombre',
		array(
			'class'=>'CButtonColumn',
			'viewButtonUrl'=>'Yii::app()->createUrl("/beneficiarios/view", array("id" => $data->id))',
			'deleteButtonUrl'=>'Yii::app()->createUrl("/beneficiarios/delete", array("id" => $data->id))',
			'updateButtonUrl'=>'Yii::app()->createUrl("/beneficiarios/update", array("id" => $data->id))',
		),
	),
));
echo CHtml::button('Nuevo Beneficiario',array("submit"=>array('beneficiarios/create', 'clienteId'=>$model->id, 'razonSocial'=>$model->razonSocial), 'csrf'=>true)); ?>
<?php 
}

