<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'flujo-fondos-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
		<?php echo $form->labelEx($model,'cuentaId'); ?>
		<?php echo $form->dropDownList($model,'cuentaId', CHtml::listData(Cuentas::model()->findAll(), 'id', 'nombre')); ?>
		<?php echo $form->error($model,'cuentaId'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'conceptoId'); ?>
		<?php echo $form->dropDownList($model,'conceptoId', CHtml::listData(Conceptos::model()->findAll(), 'id', 'nombre')); ?>
		<?php echo $form->error($model,'conceptoId'); ?>
	</div>
	
    <div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'tipoFlujoFondos'); ?>
		<?php echo $form->dropDownList($model,'tipoFlujoFondos', $model->getTypeOptions()); ?>
		<?php echo $form->error($model,'tipoFlujoFondos'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha'); ?>
                <!-- <?php echo $form->textField($model,'fecha',array('size'=>15,'maxlength'=>15)); ?> -->
                <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'language'=>'es',
                        'name'=>'FlujoFondos[fecha]',
                        'model'=>$model,
                        'attribute'=>'fecha',
                        'options'=>array(
                            'showAnim'=>'fold',
                            'showButtonPanel'=>true,
                            'dateFormat'=>'dd/mm/yy',
                        ),
                        'htmlOptions'=>array(
                            'readonly'=>"readonly"
                        ),
                    ));                             
                ?>
                <?php echo $form->error($model,'fecha'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'origen'); ?>
		<?php echo $form->textField($model,'origen',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'origen'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'identificadorOrigen'); ?>
		<?php echo $form->textField($model,'identificadorOrigen',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'identificadorOrigen'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->