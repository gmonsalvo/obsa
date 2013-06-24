<div class='form'>
<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'cheques-form',
		'enableAjaxValidation'=>false,
	));
?>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->labelEx($model,'montoGastos');?>
	<?php echo $form->textField($model,'montoGastos'); ?>
	<?php echo $form->error($model,'montoGastos'); ?>
</div>
<div class='row buttons'>
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
</div>

<?php $this->endWidget(); ?>
</div>