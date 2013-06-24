<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pesificadores-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'denominacion'); ?>
		<?php echo $form->textField($model,'denominacion',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'denominacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tasaDescuento'); ?>
		<?php echo $form->textField($model,'tasaDescuento',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'tasaDescuento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'direccion'); ?>
		<?php echo $form->textField($model,'direccion',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'direccion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'personaContacto'); ?>
		<?php echo $form->textField($model,'personaContacto',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'personaContacto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telefono'); ?>
		<?php echo $form->textField($model,'telefono',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'telefono'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
