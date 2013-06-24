<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'detalle-pesificaciones-grid',
	'dataProvider'=>$model->searchById(),
	'columns'=>array(
		array(
			'name'=>'conceptoId',
			'header'=>'Concepto',
			'value'=>'$data->conceptoPesificaciones->nombre',
		),
		array(
				'name' => 'monto',
				'header' => 'Credito',
				'value' => 'Yii::app()->numberFormatter->format("#,##0.00",($data->tipoMov == 0) ? "$data->monto":"")',
				'htmlOptions'=>array('style'=>'text-align: right'),
		),
		array(
				'name' => 'monto',
				'header' => 'Debito',
				'value' => 'Yii::app()->numberFormatter->format("#,##0.00",($data->tipoMov == 1) ? "$data->monto":"")',
				'htmlOptions'=>array('style'=>'text-align: right'),
			),
		array(
			'class'=>'CButtonColumn',
			'header' => 'Acciones',
			'template'=>'{update} {delete}',
                    'buttons'=>array
                    (
                        'update' => array
                        (
                            'label'=>'Editar',
                            'visible'=>'$data->estado == DetallePesificaciones::ESTADO_PENDIENTE',
                            'url'=>'Yii::app()->createUrl("detallePesificaciones/update", array("id"=>$data->id,"asDialog"=>1))',
                            'options'=>array(
							    'ajax'=>array(
							            'type'=>'GET',
							                // ajax post will use 'url' specified above
							            'url'=>"js:$(this).attr('href')",
							            'update'=>'#form_detalle',
							            'success' => 'js: function(response){
							            	$("#form_detalle").empty().html(response);
							            	$( "#dialog-form" ).dialog("open");
							            }'
							           ),
							),
                        ),
                        'delete' => array
                        (
                            'label'=>'Eliminar',
                            'visible'=>'$data->estado == DetallePesificaciones::ESTADO_PENDIENTE',
                            'url'=>'Yii::app()->createUrl("detallePesificaciones/delete", array("id"=>$data->id))',
                            'options'=>array(
							    'ajax'=>array(
							            'type'=>'POST',
							                // ajax post will use 'url' specified above
							            'url'=>"js:$(this).attr('href')",
							            'update'=>'#form_detalle',
							            'success' => 'js: function(response){
							            	response=jQuery.parseJSON(response);
							            	$("#detallePesificacion").empty().html(response.detallePesificaciones);
							            }'
							           ),
							),
                        ),
                    ),
		),

	),
)); ?>
<div align="right">Saldo por acreditar: <span id="saldo"><?php echo Utilities::MoneyFormat(abs($model->saldo))?></span></div>
