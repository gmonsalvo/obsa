<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'libradores-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

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

    <div class="row">
		<?php echo $form->labelEx($model,'actividadId'); ?>
		<?php echo $form->dropDownList($model,'actividadId', CHtml::listData(Actividades::model()->findAll(), 'id', 'descripcion')); ?>
		<?php echo $form->error($model,'actividadId'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'montoMaximo'); ?>
		<?php echo $form->textField($model,'montoMaximo',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'montoMaximo'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->