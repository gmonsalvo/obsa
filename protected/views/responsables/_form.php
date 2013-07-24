<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'responsables-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los Campos Marcados con <span class="required">*</span> son Obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'celular'); ?>
		<?php echo $form->textField($model,'celular',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'celular'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fijo'); ?>
		<?php echo $form->textField($model,'fijo',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'fijo'); ?>
	</div>
	<!--
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
	-->
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->