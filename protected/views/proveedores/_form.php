<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'proveedores-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los Campos con <span class="required">*</span> son Obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'documento'); ?>
		<?php echo $form->textField($model,'documento',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'documento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'denominacion'); ?>
		<?php echo $form->textField($model,'denominacion',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'denominacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'direccion'); ?>
		<?php echo $form->textField($model,'direccion',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'direccion'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'localidadId'); ?>
		<?php echo $form->dropDownList($model,'localidadId', CHtml::listData(Localidades::model()->findAll(), 'id', 'descripcion')); ?>
		<?php echo $form->error($model,'localidadId'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'provinciaId'); ?>
		<?php echo $form->dropDownList($model,'provinciaId', CHtml::listData(Provincias::model()->findAll(), 'id', 'descripcion')); ?>
		<?php echo $form->error($model,'provinciaId'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->