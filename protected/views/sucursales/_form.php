<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sucursales-form',
	'enableAjaxValidation'=>false,
));

?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'direccion'); ?>
		<?php echo $form->textField($model,'direccion',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'direccion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comisionGeneral'); ?>
		<?php $this->widget('CMaskedTextField', array(
						'model' => $model,
						'attribute' => 'comisionGeneral',
						'mask' => '99,9',
						'htmlOptions' => array('size' => 3,'maxlength'=>4)
					)); ?>
		<?php echo $form->error($model,'comisionGeneral'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tasaDescuentoGeneral'); ?>
		<?php echo $form->textField($model,'tasaDescuentoGeneral',array('size'=>3,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'tasaDescuentoGeneral'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tasaInversores'); ?>
		<?php echo $form->textField($model,'tasaInversores',array('size'=>3,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'tasaInversores'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tasaPesificacion'); ?>
		<?php echo $form->textField($model,'tasaPesificacion',array('size'=>3,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'tasaPesificacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tasaPromedioPesificacion'); ?>
		<?php echo $form->textField($model,'tasaPromedioPesificacion',array('size'=>3,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'tasaPromedioPesificacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'diasClearing'); ?>
		<?php echo $form->textField($model,'diasClearing'); ?>
		<?php echo $form->error($model,'diasClearing'); ?>
	</div>
     <!--
	<div class="row">
		<?php echo $form->labelEx($model,'userStamp'); ?>
		<?php echo $form->textField($model,'userStamp'); ?>
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