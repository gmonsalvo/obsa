<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'forma-pago-orden-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ordenPagoId'); ?>
		<?php echo $form->textField($model,'ordenPagoId'); ?>
		<?php echo $form->error($model,'ordenPagoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipoFormaPago'); ?>
		<?php echo $form->textField($model,'tipoFormaPago'); ?>
		<?php echo $form->error($model,'tipoFormaPago'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'formaPagoId'); ?>
		<?php echo $form->textField($model,'formaPagoId'); ?>
		<?php echo $form->error($model,'formaPagoId'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->