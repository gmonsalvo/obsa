<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'operacionChequeId'); ?>
		<?php echo $form->textField($model,'operacionChequeId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tasaDescuento'); ?>
		<?php echo $form->textField($model,'tasaDescuento',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'clearing'); ?>
		<?php echo $form->textField($model,'clearing'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pesificacion'); ?>
		<?php echo $form->textField($model,'pesificacion',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'numeroCheque'); ?>
		<?php echo $form->textField($model,'numeroCheque',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'libradorId'); ?>
		<?php echo $form->textField($model,'libradorId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bancoId'); ?>
		<?php echo $form->textField($model,'bancoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'montoOrigen'); ?>
		<?php echo $form->textField($model,'montoOrigen',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fechaPago'); ?>
		<?php echo $form->textField($model,'fechaPago'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipoCheque'); ?>
		<?php echo $form->textField($model,'tipoCheque'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'endosante'); ?>
		<?php echo $form->textField($model,'endosante',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'montoNeto'); ?>
		<?php echo $form->textField($model,'montoNeto',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'userStamp'); ?>
		<?php echo $form->textField($model,'userStamp',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'timeStamp'); ?>
		<?php echo $form->textField($model,'timeStamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sucursalId'); ?>
		<?php echo $form->textField($model,'sucursalId'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->