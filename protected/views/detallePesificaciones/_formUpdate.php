<?php //Yii::app()->getClientScript()->registerCoreScript('yiiactiveform');?>
<div class="form">

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div id="erroresUpdate">
	<?php echo CHtml::errorSummary($model); ?>
	</div>
	<div class="row">
		<?php echo CHtml::label("Concepto",'conceptoId'); ?>
		<?php echo CHtml::dropDownList('conceptoId',$model->conceptoId, CHtml::listData(ConceptosPesificaciones::model()->findAll("id!=1"), 'id', 'nombre'),array('prompt' => 'Seleccione un Concepto')); ?>
		<?php //echo CHtml::error($model,'conceptoId'); ?>
	</div>

	<div class="row">
		<?php echo CHtml::label("Monto",'monto'); ?>
		<?php echo CHtml::textField('monto',$model->monto,array("id"=>"monto")); ?>
		<?php //echo CHtml::error($model,'monto'); ?>
	</div>
	<?php echo CHtml::hiddenField("pesificacionId",$model->pesificacionId); ?>
	<?php echo CHtml::hiddenField("id",$model->id); ?>
	<div class="row buttons">
		<?php
        echo CHtml::ajaxButton($model->isNewRecord ? 'Agregar detalle' : 'Editar detalle', CHtml::normalizeUrl(array("/detallePesificaciones/update", "id" => $model->id)), array(
            'type' => 'GET',
            'data' => array(
            	'conceptoId' => 'js:$("#conceptoId").val()',
            	'pesificacionId' => 'js:$("#pesificacionId").val()',
            	'monto' => 'js:$("#monto").val()',
            	'id' => 'js:$("#id").val()',
             ),
             'dataType' => 'text',
            //
            //
            'success' => 'js:function(data){
					var datos=jQuery.parseJSON(data);
					if(datos.status=="success"){
						$("#detallePesificacion").empty().html(datos.detallePesificaciones);
						$("#form_detalle").empty();
						$( "#dialog-form" ).dialog( "close" );
					} else {
						$("#erroresUpdate").html(datos.errores);
					}
				}',
                ), array('id' => 'editarDetalle'));
        ?>
	</div>


</div><!-- form -->