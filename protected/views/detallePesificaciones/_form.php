<div class="form">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'detalle-pesificaciones-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div id="erroresCreate">
		<?php echo $form->errorSummary($model); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'conceptoId'); ?>
		<?php echo $form->dropDownList($model,'conceptoId', CHtml::listData(ConceptosPesificaciones::model()->findAll("id!=1"), 'id', 'nombre'),array('prompt' => 'Seleccione un Concepto')); ?>
		<?php echo $form->error($model,'conceptoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto'); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>
	<?php echo $form->hiddenField($model,"pesificacionId",array("value"=>isset($model->pesificacionId) ? $model->pesificacionId : $pesificacionId)); ?>
	<?php echo $form->hiddenField($model,"id",array("value"=>isset($_GET["id"]) ? $_GET["id"] : 0)); ?>
	<div class="row buttons">
		<?php
        echo CHtml::ajaxSubmitButton($model->isNewRecord ? 'Agregar detalle' : 'Editar detalle', CHtml::normalizeUrl(array('detallePesificaciones/create', 'render' => false)), array(
            'success' => 'js:function(data){
					var datos=jQuery.parseJSON(data);
					if(datos.status=="success"){
						$("#detallePesificacion").empty().html(datos.detallePesificaciones);
						$("#form_detalle").empty();
						$( "#dialog-form" ).dialog( "close" );
					} else {
						$("#erroresCreate").html(datos.errores);
					}
				}',
                ), array('id' => 'agregarDetalle'));
        ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->