<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'perfiles-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'descrpcion'); ?>
		<?php echo $form->textField($model,'descrpcion',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'descrpcion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->