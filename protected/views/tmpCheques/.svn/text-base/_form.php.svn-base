<?php
if(isset($_GET['operadorId']) && isset($_GET['clienteId']) && isset($_GET['fecha'])){
	$operadorId=$_GET['operadorId'];
	$clienteId=$_GET['clienteId'];
	$fecha=$_GET['fecha'];
}
else{
	$operadorId='';
	$clienteId='';
	$fecha=Date('d/m/Y');
}
?>
<?php
Yii::app()->clientScript->registerScript('focusOnNumeroCheque', "
$('#TmpCheques_numeroCheque').focus();
");
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tmp-cheques-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<table border=1 class="formulario">
<tr>
<td><?php echo $form->labelEx($model,'fechaPago'); ?></td>
<td>		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker',
			array(
				// you must specify name or model/attribute
				'model'=>$model,
				'attribute'=>'fechaPago',
				'value' => $model->fechaPago,
				'language' => 'es',
				'options' => array(
					// how to change the input format? see http://docs.jquery.com/UI/Datepicker/formatDate
					'dateFormat'=>'dd/mm/yy',
					'defaultDate'=>$model->fechaPago,
					'monthNames' => array('Enero,Febrero,Marzo,Abril,Mayo,Junio,Julio,Agosto,Septiembre,Octubre,Noviembre,Diciembre'),
					'monthNamesShort' => array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"),
					'dayNames' => array('Domingo,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado'),
					'dayNamesMin' => array('Do','Lu','Ma','Mi','Ju','Vi','Sa'),
					// user will be able to change month and year
					'changeMonth' => 'true',
					'changeYear' => 'true',

					// shows the button panel under the calendar (buttons like "today" and "done")
					'showButtonPanel' => 'true',

					// this is useful to allow only valid chars in the input field, according to dateFormat
					'constrainInput' => 'false',

					// speed at which the datepicker appears, time in ms or "slow", "normal" or "fast"
					'duration'=>'fast',
					// animation effect, see http://docs.jquery.com/UI/Effects
					'showAnim' =>'fold',
				),
				// optional: html options will affect the input element, not the datepicker widget itself
				'htmlOptions'=>array(
				'readonly'=>"readonly",
				'style'=>'height:20px;'
				)
			)
		);?></td>
<td><?php echo $form->labelEx($model,'tasaDescuento'); ?></td>
<td>		<?php
		$this->widget('CMaskedTextField',array(
			'model'=>$model,
			'attribute'=>'tasaDescuento',
			'name'=>'TmpCheques_tasaDescuento',
			'mask'=>'9.99',
			'htmlOptions'=>array(
				'style'=>'width:80px;',
				'value'=>Yii::app()->user->model->sucursal->tasaDescuentoGeneral,
			),
		));
		?></td>
</tr>
<tr>
<td></td><td><?php echo $form->error($model,'fechaPago'); ?></td><td></td><td><?php echo $form->error($model,'tasaDescuento'); ?></td>
</tr>
<tr>
<td>		<?php echo $form->labelEx($model,'clearing'); ?></td>
<td><?php echo $form->textField($model,'clearing',array('value'=>Yii::app()->user->model->sucursal->diasClearing)); ?></td>
<td><?php echo $form->labelEx($model,'pesificacion'); ?></td>
<td>		<?php
		$this->widget('CMaskedTextField',array(
			'model'=>$model,
			'attribute'=>'pesificacion',
			'name'=>'TmpCheques_pesificacion',
			'mask'=>'9.99',
			'htmlOptions'=>array(
				'style'=>'width:80px;',
				'value'=>Yii::app()->user->model->sucursal->tasaPesificacion,
			),
		));
		?></td>
</tr>
<tr>
<td></td><td><?php echo $form->error($model,'clearing'); ?></td><td></td><td><?php echo $form->error($model,'pesificacion'); ?></td>
</tr>
<tr>
<td><?php echo $form->labelEx($model,'numeroCheque'); ?></td>
<td><?php echo $form->textField($model,'numeroCheque',array('size'=>35,'maxlength'=>45)); ?></td>
<td>		<?php echo $form->labelEx($model,'libradorId'); ?></td>
<td><?php echo $form->dropDownList($model,'libradorId', CHtml::listData(Libradores::model()->findAll(), 'id', 'denominacion')); ?></td>
</tr>
<tr>
<td></td><td><?php echo $form->error($model,'numeroCheque'); ?></td><td></td><td><?php echo $form->error($model,'libradorId'); ?></td>
</tr>
<tr>
<td><?php echo $form->labelEx($model,'bancoId'); ?></td>
<td><?php echo $form->dropDownList($model,'bancoId', CHtml::listData(Bancos::model()->findAll(), 'id', 'nombre')); ?></td>
<td>		<?php echo $form->labelEx($model,'montoOrigen'); ?></td>
<td><?php echo $form->textField($model,'montoOrigen',array('size'=>17,'maxlength'=>17)); ?></td>
</tr>
<tr>
<td></td><td><?php echo $form->error($model,'bancoId'); ?></td><td></td><td align="left"><?php echo $form->error($model,'montoOrigen'); ?></td>
</tr>
<tr>
<td><?php echo $form->labelEx($model,'tipoCheque'); ?></td>
<td><?php echo $form->dropDownList($model,'tipoCheque', $model->getTypeOptions('tipoCheque')); ?></td>
<td>		<?php echo $form->labelEx($model,'endosante'); ?></td>
<td><?php echo $form->textField($model,'endosante',array('size'=>35,'maxlength'=>100)); ?></td>
</tr>
<tr>
<td></td><td><?php echo $form->error($model,'tipoCheque'); ?></td><td></td><td><?php echo $form->error($model,'endosante'); ?></td>
</tr>
<tr class="resultado">
<td><?php echo CHtml::ajaxButton('Calcular Monto Neto', 
			CHtml::normalizeUrl(array('tmpCheques/calcularMontoNeto','render'=>false)),
			array(
			    'type'=>'POST',
				'data'=>array('tasaDescuento'=>'js:$("#TmpCheques_tasaDescuento").val()',
				'clearing'=>'js:$("#TmpCheques_clearing").val()',
				'pesificacion'=>'js:$("#TmpCheques_pesificacion").val()',
				'montoOrigen'=>'js:$("#TmpCheques_montoOrigen").val()',
				'fechaPago'=>'js:$("#TmpCheques_fechaPago").val()',
				'fechaOperacion'=>$_GET['fecha'],
				),
				'dataType'=>'text',
				'beforeSend' => 'js:function(){
					if($("#TmpCheques_tasaDescuento").val()=="" || $("#TmpCheques_clearing").val()=="" || $("#TmpCheques_montoOrigen").val()=="" || $("#TmpCheques_fechaPago").val()==""){
						alert("Algunos de los valores requeridos para calcular el monto neto no fueron ingresados. Por favor ingreselos");
						return false;
					}
					return true;
				}',
				'success' => 'js:function(data){
					var datos=data.split(";");
					$("#TmpCheques_montoNeto").val(datos[0]);
					var tdtabla=$(".formulario").find(".resultado").find(".tablaresultado");
					tdtabla.html("<table border=1 class=\"ui-widget ui-widget-content\"><thead class=\"ui-widget-header \"><tr><th>Monto Neto</th><th>Gastos por Tasa Descuento</th><th>Gastos por Pesificacion</th></tr></thead><tbody><tr><td>$"+datos[0]+"<td>$"+datos[1]+"</td><td>$"+datos[2]+"</td></tr></tbody></table>");
					}',
				))?></td>
<td class='tablaresultado' colspan=3><?php echo $form->error($model,'montoNeto'); ?></td>
</tr>
</table>
		
	<?php echo CHtml::hiddenField('operadorId',$operadorId);
	echo CHtml::hiddenField('clienteId',$clienteId);
	echo CHtml::hiddenField('fecha',$fecha);
	echo $form->hiddenField($model,'montoNeto',array('size'=>20,'maxlength'=>17,'readonly'=>"readonly"));
	?>
	<div class="row buttons">						
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Modificar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->