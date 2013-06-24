<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cheques-form',
	'enableAjaxValidation'=>false,
)); ?>

<div class="row">
<?php echo $form->hiddenField($model,'estado',array('type'=>"hidden",'size'=>2,'maxlength'=>2,'value'=>2)); ?>
</div>

<div class="row buttons">
	<?php 
		echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Confirmar Entrega');
	?>
</div>

<?php $this->endWidget(); ?>
</div>
