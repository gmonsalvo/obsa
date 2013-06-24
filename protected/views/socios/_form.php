<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'socios-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

    <?php
		if ($model->libradorId == null)
		{
			$model->libradorId = $_GET['libradorId'];
			echo $form->hiddenField($model,'libradorId');
		}
	?>

	<div class="row">
		<?php echo $form->labelEx($model,'documento'); ?>
		<?php echo $form->textField($model,'documento',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'documento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'apellidoNombre'); ?>
		<?php echo $form->textField($model,'apellidoNombre',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'apellidoNombre'); ?>
	</div>
        
        <div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->