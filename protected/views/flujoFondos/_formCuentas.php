<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'cuentas-form',
			'action'=>Yii::app()->createUrl("/flujoFondos/createMov"),
            'enableAjaxValidation'=>false,
        ));
    ?>

<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>
<?php echo $form->errorSummary($model);
?>

	<div class="row">
		<?php echo $form->labelEx($model,'Cuenta Origen'); ?>
		<?php echo $form->dropDownList($model,'cuentaOrigen', CHtml::listData(Cuentas::model()->findAll(), 'id', 'nombre')); ?>
		<?php echo $form->error($model,'cuentaOrigen'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Cuenta Destino'); ?>
		<?php echo $form->dropDownList($model,'cuentaDestino', CHtml::listData(Cuentas::model()->findAll(), 'id', 'nombre')); ?>
		<?php echo $form->error($model,'cuentaDestino'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Efectuar Movimiento'); ?>
		
	</div>

<?php $this->endWidget();
?>

</div><!-- form -->
