<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'presupuesto-operaciones-cheques-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'operadorId'); ?>
		<?php echo $form->textField($model,'operadorId'); ?>
		<?php echo $form->error($model,'operadorId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clienteId'); ?>
		<?php echo $form->textField($model,'clienteId'); ?>
		<?php echo $form->error($model,'clienteId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'montoNetoTotal'); ?>
		<?php echo $form->textField($model,'montoNetoTotal',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'montoNetoTotal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha'); ?>
		<?php echo $form->textField($model,'fecha'); ?>
		<?php echo $form->error($model,'fecha'); ?>
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