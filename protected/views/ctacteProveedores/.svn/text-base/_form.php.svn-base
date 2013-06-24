<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ctacte-proveedores-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <?php echo $form->labelEx($model,'fecha'); ?>
	<?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'language'=>'es',
			'name'=>'CtacteProveedores[fecha]',
			'model'=>$model,
			'attribute'=>'fecha',
            'options'=>array(
				'showAnim'=>'fold',
                'showButtonPanel'=>true,
				'dateFormat'=>'dd/mm/yy',				),
            'htmlOptions'=>array(
                'value'=>Date('d/m/Y'),
				'readonly'=>"readonly"
            ),
        ));
    ?>
	<?php echo $form->error($model,'fecha'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'proveedorId'); ?>
	<?php echo CHtml::activeDropDownList($model,'proveedorId', 
        CHtml::listData(Proveedores::model()->findAll(), 'id', 'denominacion'),array('empty'=>'')); ?>
    <?php echo $form->error($model,'proveedorId'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'descripcion'); ?>
	<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>200)); ?>
	<?php echo $form->error($model,'descripcion'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'monto'); ?>
	<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
	<?php echo $form->error($model,'monto'); ?>
</div>

<div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
</div>
<?php echo $form->hiddenField($model,'tipoMov',array('value'=>  CtacteProveedores::TYPE_DEBITO)); ?>
<?php $this->endWidget(); ?>

</div><!-- form -->