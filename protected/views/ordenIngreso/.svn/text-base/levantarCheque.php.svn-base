<script>

function calcularMonto(){
	var montoPorcentaje = parseFloat($("#porcentajeReconocimiento").val())*parseFloat($("#montoOrigen").val())/100;
	var montoAbonar = parseFloat($("#montoOrigen").val()) - parseFloat(montoPorcentaje);
	$("#montoAbonar").val(montoAbonar.toFixed(2));

}

</script>

<?php
$this->breadcrumbs=array(
	'Ordenes Ingreso'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Ordenes Ingreso', 'url'=>array('admin')),
);
?>

<h1>Acreditar Cheque</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ordenes-ingreso-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

<?php echo $this->renderPartial("/cheques/ver",array("model"=>$cheque)); ?>

	<div class="row">
<?php
    $this->widget('zii.widgets.jui.CJuiDatePicker',
    	array
    	(
	        // you must specify name or model/attribute
	        'model' => $model,
	        'attribute' => 'fecha',
	        'language' => 'es',
	        'options' => array(
	            'dateFormat' => 'dd/mm/yy',
	            //'defaultDate'=>Date('d-m-Y'),
	            'changeMonth' => 'true',
	            'changeYear' => 'true',
	            'showButtonPanel' => 'true',
	            'constrainInput' => 'false',
	            'duration' => 'fast',
	            'showAnim' => 'fold',
	        ),
	        'htmlOptions' => array(
	            'value' => date("d/m/Y"),
	            'readonly' => "readonly",
	            'style' => 'height:20px;',
	            // 'onChange' => 'js:$("#OperacionesCheques_fecha").focus(); $("#fecha").val($("#OperacionesCheques_fecha").val())',
	        )
        )
    );
    ?>
	</div>

	<div class="row">
		<?php echo CHtml::label("Porcentaje Reconocimiento",'porcentajeReconocimiento'); ?>
		<?php echo CHtml::textField("porcentajeReconocimiento",0,array("id"=>"porcentajeReconocimiento","onblur"=>"calcularMonto()")); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array("value"=>$cheque->montoOrigen,'id'=>"montoAbonar",'size'=>25,'maxlength'=>25, "readonly"=>"readonly")); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>
	<?php echo $form->hiddenField($model,'tipo',array("value"=>OrdenIngreso::TIPO_PESIFICACION_INDIVIDUAL)); ?>
	<?php echo $form->hiddenField($model,"identificadorOrigen",array("value" => $cheque->id)); ?>
	<?php echo $form->hiddenField($model,"origen",array("value" => "Cheques")); ?>
	<?php echo CHtml::hiddenField("montoOrigen",$cheque->montoOrigen,array("montoOrigen")); ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton("Guardar"); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->