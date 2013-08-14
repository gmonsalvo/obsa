<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ctacte-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'tipoMov'); ?>
		<?php echo $form->textField($model,'tipoMov'); ?>
		<?php echo $form->error($model,'tipoMov'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'productoCtaCteId'); ?>
		<?php echo $form->textField($model,'productoCtaCteId',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'productoCtaCteId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'conceptoId'); ?>
		<?php echo $form->textField($model,'conceptoId'); ?>
		<?php echo $form->error($model,'conceptoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'saldoAcumulado'); ?>
		<?php echo $form->textField($model,'saldoAcumulado',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'saldoAcumulado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha'); ?>
		<?php echo $form->textField($model,'fecha'); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'userStamp'); ?>
		<?php echo $form->textField($model,'userStamp',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'userStamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timeStamp'); ?>
		<?php echo $form->textField($model,'timeStamp'); ?>
		<?php echo $form->error($model,'timeStamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sucursalId'); ?>
		<?php echo $form->textField($model,'sucursalId'); ?>
		<?php echo $form->error($model,'sucursalId'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->