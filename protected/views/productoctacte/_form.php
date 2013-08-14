<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'productoctacte-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombreModelo'); ?>
		<?php echo $form->textField($model,'nombreModelo',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nombreModelo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pkModeloRelacionado'); ?>
		<?php echo $form->textField($model,'pkModeloRelacionado',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'pkModeloRelacionado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'productoId'); ?>
		<?php echo $form->textField($model,'productoId'); ?>
		<?php echo $form->error($model,'productoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'userStamp'); ?>
		<?php echo $form->textField($model,'userStamp',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'userStamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timeStamp'); ?>
		<?php echo $form->textField($model,'timeStamp'); ?>
		<?php echo $form->error($model,'timeStamp'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->