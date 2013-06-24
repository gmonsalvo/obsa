<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'operadores-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'apynom'); ?>
		<?php echo $form->textField($model,'apynom',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'apynom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'direccion'); ?>
		<?php echo $form->textField($model,'direccion',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'direccion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'celular'); ?>
		<?php echo $form->textField($model,'celular',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'celular'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fijo'); ?>
		<?php echo $form->textField($model,'fijo',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'fijo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'documento'); ?>
		<?php echo $form->textField($model,'documento',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'documento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comision'); ?>
		<?php echo $form->textField($model,'comision',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'comision'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usuarioId'); ?>
		<?php echo $form->dropDownList($model,'usuarioId', CHtml::listData(User::model()->findAll(), 'id', 'username')); ?>
		<?php echo $form->error($model,'usuarioId'); ?>
	</div>
        
       <div class="row">
		<?php echo $form->labelEx($model,'clienteId'); ?>
		<?php echo $form->dropDownList($model,'clienteId', CHtml::listData(Clientes::model()->findAll(), 'id', 'razonSocial')); ?>
		<?php echo $form->error($model,'clienteId'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
