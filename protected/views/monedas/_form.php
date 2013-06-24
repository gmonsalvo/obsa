<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'monedas-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los Campos con <span class="required">*</span> son Obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'denominacion'); ?>
		<?php echo $form->textField($model,'denominacion',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'denominacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tasaCambioCompra'); ?>
		<?php 
		$this->widget('CMaskedTextField', array(
                    'model' => $model,
                    'attribute' => 'tasaCambioCompra',
                    'name' => 'tasaCambioCompra',
                    'mask' => '9.9?9',
                    'htmlOptions' => array(
                        'onblur' => 'js:VerificarMascara(this);',
                        'style' => 'width:80px;',
                    ),
                ));
		?>
		<?php echo $form->error($model,'tasaCambioCompra'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tasaCambioVenta'); ?>
		<?php 
		$this->widget('CMaskedTextField', array(
                    'model' => $model,
                    'attribute' => 'tasaCambioVenta',
                    'name' => 'tasaCambioVenta',
                    'mask' => '9.9?9',
                    'htmlOptions' => array(
                        'onblur' => 'js:VerificarMascara(this);',
                        'style' => 'width:80px;',
                    ),
                ));
		?>
		<?php echo $form->error($model,'tasaCambioVenta'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->