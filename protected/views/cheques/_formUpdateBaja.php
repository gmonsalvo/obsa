 <!-- Pagina en uso para Egreso de Fondos (Julio Diaz) -->
<?php
$this->breadcrumbs=array(
	'Cheques'=>array('adminCheques'),
);
?>

<h2><b>Baja de Cheque Rechazado</b></h2>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tasaDescuento',
		'clearing',
		'pesificacion',
		'numeroCheque',
		array(
			'name'=>'libradorId',
			'value'=>$model->librador->denominacion
		),
		array(
			'name'=>'banco',
			'value'=>$model->banco->nombre
		),
		array(
			'name'=>'montoOrigen',
			'value'=>Yii::app()->numberFormatter->format("#,##0.00", $model->montoOrigen),
		),			
		'fechaPago',
		array(
			'name'=>'tipoCheque',
			'value'=>$model->getTypeDescription('tipoCheque')
		),
		'endosante',
		'montoNeto',
		array(
			'name'=>'estado',
			'value'=>$model->getTypeDescription('estado')
		),
		array(
			'name'=>'montoGastos',
			'value'=>Yii::app()->numberFormatter->format("#,##0.00", $model->montoGastos),
		)
	),
)); ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cheques-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->labelEx($model,'montoGastos');?>
	<?php echo $form->textField($model,'montoGastos'); ?>
	<?php echo $form->error($model,'montoGastos'); ?>
</div>
<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
</div>

<?php $this->endWidget(); ?>
</div>
