<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cheques-grid',
	'dataProvider'=>$dataProvider,
	'rowCssClassExpression'=>'$data->tipoCheque==3 ? "chequelevantar" : "odd"',
	'selectableRows' => -1,
	'selectionChanged'=>'MostrarCheque',
	'columns'=>array(
	    array(
			'header'=>'Cheques seleccionados',
            'class'=>'CCheckBoxColumn',            
        ),
		'numeroCheque',
		'fechaPago',
            
                array(
			'name'=>'montoOrigen',
			'header'=>'Monto Nominal',
			'value'=>'Utilities::MoneyFormat($data->montoOrigen)',
		),
                array(
			'name'=>'libradorId',
			'header'=>'Librador',
			'value'=>'$data->librador->denominacion',
		),
		array(
			'name'=>'operacionChequeId',
			'header'=>'Cliente Tomador',
			'value'=>'$data->operacionCheque->cliente->razonSocial',
		),
		array(
			'name'=>'tipoCheque',
			'header'=>'Tipo Cheque',
			'value'=>'$data->getTypeDescription("tipoCheque")',
		),
		array(
			'name'=>'estado',
			'header'=>'Estado',
			'value'=>'$data->getTypeDescription("estado")',
		),
		/*
		'libradorId',
		'bancoId',
		'fechaPago',
		'tipoCheque',
		'endosante',
		'montoNeto',
		'estado',
		'userStamp',
		'timeStamp',
		'sucursalId',
		*/
	),
)); ?>
