<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'detalle-colocaciones-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'colocacionId'); ?>
		<?php echo $form->textField($model,'colocacionId'); ?>
		<?php echo $form->error($model,'colocacionId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clienteId'); ?>
		<?php echo $form->textField($model,'clienteId'); ?>
		<?php echo $form->error($model,'clienteId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tasa'); ?>
		<?php echo $form->textField($model,'tasa',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'tasa'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->