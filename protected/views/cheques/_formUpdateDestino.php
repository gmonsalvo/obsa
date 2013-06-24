<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cheques-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
	<?php echo $form->labelEx($model,'tipoCheque'); ?>
	<?php echo $form->dropDownList($model,'tipoCheque', $model->getTypeOptions('tipoCheque')); ?>
	<?php echo $form->error($model,'tipoCheque'); ?>
</div>

<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
</div>

<?php $this->endWidget(); ?>
</div>
