<?php 
$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'',
			));
			 echo "<b>Inversores colocados en el Cheque seleccionado</b>";
$this->endWidget();

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'clientes-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'id',
		'razonSocial',
		'fijo',
		'celular',
		'direccion',
		'email',
		'documento',
		'tasaInversor',
		array(
			'name'=>'tipoCliente',
			'header'=>'Tipo Cliente',
			'value'=>'$data->getTypeDescription()',
		),
		array(
			'name'=>'operadorId',
			'header'=>'Operador',
			'value'=>'$data->operador->apynom',
		),
	),
)); ?>

