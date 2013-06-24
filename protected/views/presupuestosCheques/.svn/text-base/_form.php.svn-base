<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'presupuestos-cheques-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'operacionChequeId'); ?>
		<?php echo $form->textField($model,'operacionChequeId'); ?>
		<?php echo $form->error($model,'operacionChequeId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tasaDescuento'); ?>
		<?php echo $form->textField($model,'tasaDescuento',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'tasaDescuento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clearing'); ?>
		<?php echo $form->textField($model,'clearing'); ?>
		<?php echo $form->error($model,'clearing'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pesificacion'); ?>
		<?php echo $form->textField($model,'pesificacion',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'pesificacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'numeroCheque'); ?>
		<?php echo $form->textField($model,'numeroCheque',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'numeroCheque'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'libradorId'); ?>
		<?php echo $form->textField($model,'libradorId'); ?>
		<?php echo $form->error($model,'libradorId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bancoId'); ?>
		<?php echo $form->textField($model,'bancoId'); ?>
		<?php echo $form->error($model,'bancoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'montoOrigen'); ?>
		<?php echo $form->textField($model,'montoOrigen',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'montoOrigen'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fechaPago'); ?>
		<?php echo $form->textField($model,'fechaPago'); ?>
		<?php echo $form->error($model,'fechaPago'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipoCheque'); ?>
		<?php echo $form->textField($model,'tipoCheque'); ?>
		<?php echo $form->error($model,'tipoCheque'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'endosante'); ?>
		<?php echo $form->textField($model,'endosante',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'endosante'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'montoNeto'); ?>
		<?php echo $form->textField($model,'montoNeto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'montoNeto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'userStamp'); ?>
		<?php echo $form->textField($model,'userStamp',array('size'=>50,'maxlength'=>50)); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'montoGastos'); ?>
		<?php echo $form->textField($model,'montoGastos',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'montoGastos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tieneNota'); ?>
		<?php echo $form->textField($model,'tieneNota'); ?>
		<?php echo $form->error($model,'tieneNota'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comisionado'); ?>
		<?php echo $form->textField($model,'comisionado'); ?>
		<?php echo $form->error($model,'comisionado'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->