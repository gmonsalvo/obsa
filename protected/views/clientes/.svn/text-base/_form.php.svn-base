<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clientes-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'razonSocial'); ?>
		<?php echo $form->textField($model,'razonSocial',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'razonSocial'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'documento'); ?>
		<?php echo $form->textField($model,'documento',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'documento'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'fijo'); ?>
		<?php echo $form->textField($model,'fijo',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'fijo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'celular'); ?>
		<?php echo $form->textField($model,'celular',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'celular'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'direccion'); ?>
		<?php echo $form->textField($model,'direccion',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'direccion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'localidadId'); ?>
		<?php echo $form->dropDownList($model,'localidadId', CHtml::listData(Localidades::model()->findAll(), 'id', 'descripcion')); ?>
		<?php echo $form->error($model,'localidadId'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'provinciaId'); ?>
		<?php echo $form->dropDownList($model,'provinciaId', CHtml::listData(Provincias::model()->findAll(), 'id', 'descripcion')); ?>
		<?php echo $form->error($model,'provinciaId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	

	<div class="row">
		<?php echo $form->labelEx($model,'tipoCliente'); ?>
		<?php echo $form->dropDownList($model,'tipoCliente', $model->getTypeOptions()); ?>
		<?php /*echo CHtml::dropDownList('tipoCliente','', $model->getTypeOptions(),array(
            'ajax' => array( 'type'=>'POST', //request type
                    'url'=>CController::createUrl('clientes/updatefield'), //url to call.
                    //Style: CController::createUrl('currentController/methodToCall')
                    'update'=>'#prueba', //selector to update
                    //'data'=>'js:javascript statement'
                    //leave out the data key to pass all form values through
                ))); */?>
		<?php echo $form->error($model,'tipoCliente'); ?>
	</div>

	<div class="row" id='prueba'>
		<?php echo $form->labelEx($model,'tasaTomador'); ?>
		<?php echo $form->textField($model,'tasaTomador',array('size'=>5,'maxlength'=>5, 'value'=>Yii::app()->user->model->sucursal->tasaDescuentoGeneral)); ?>
		<?php echo $form->error($model,'tasaTomador'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'montoMaximoTomador'); ?>
		<?php echo $form->textField($model,'montoMaximoTomador',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'montoMaximoTomador'); ?>
	</div>	
	
	<div class="row">
		<?php echo $form->labelEx($model,'tasaInversor'); ?>
		<?php echo $form->textField($model,'tasaInversor',array('size'=>5,'maxlength'=>5, 'value'=>Yii::app()->user->model->sucursal->tasaInversores)); ?>
		<?php echo $form->error($model,'tasaInversor'); ?>

	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'montoPermitidoDescubierto'); ?>
		<?php echo $form->textField($model,'montoPermitidoDescubierto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'montoPermitidoDescubierto'); ?>

	</div>
	
	
	<div class="row">
		<?php echo $form->labelEx($model,'operadorId'); ?>
		<?php echo $form->dropDownList($model,'operadorId', CHtml::listData(Operadores::model()->findAll(), 'id', 'apynom')); ?>
		<?php echo $form->error($model,'operadorId'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->