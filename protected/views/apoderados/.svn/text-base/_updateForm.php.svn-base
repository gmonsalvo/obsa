<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'apoderados-form',
	'enableAjaxValidation'=>false,
)); ?>
<br>

<h1>Cliente <?php echo $model->cliente->razonSocial;?></h1>
<br>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

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
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Modificar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->