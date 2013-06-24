<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ctacte-clientes-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

<?php echo $form->errorSummary($model); ?>
	
<div class="row">
    <?php echo $form->labelEx($model,'fecha'); ?>
	<?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'language'=>'es',
			'name'=>'CtacteClientes[fecha]',
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
    <?php echo $form->labelEx($model,'clienteId'); ?>
	<?php echo CHtml::activeDropDownList($model,'clienteId', 
        CHtml::listData(Clientes::model()->findAllByAttributes(array('tipoCliente'=>array(1,2))),
		'id', 'razonSocial'),array('empty'=>'')); ?>
    <?php echo $form->error($model,'clienteId'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'productoId'); ?>
	<?php echo $form->dropDownList($model,'productoId',
        CHtml::listData(Productos::model()->findAll(), 'id', 'nombre'),array('empty'=>'')); ?>
    <?php echo $form->error($model,'productoId'); ?>
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

<?php $this->endWidget(); ?>

</div><!-- form -->