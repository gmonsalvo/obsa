<?php
$this->breadcrumbs=array(
	'Cheques'=>array('adminCheques'),
	'Administrar',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cheques-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<script>

function AccionGridCheques(id){
    $('#inversores').html("");
    $('#botonera').html("");
    if($.fn.yiiGridView.getSelection(id)!=''){
        MostrarInversores(id);
        MostrarBotonera(id);
    }else{
        DeshabilitarBotonera();
    }


}

function DeshabilitarBotonera(){
    $("#botonCambiarDestino").attr('disabled','disabled');
    $("#botonReemplazar").attr('disabled','disabled');
    $("#botonEntregaCliente").attr('disabled','disabled');
    $("#botonDevolucionCliente").attr('disabled','disabled');
    $("#botonAltaRechazado").attr('disabled','disabled');
    $("#botonBajaRechazado").attr('disabled','disabled');
    $("#botonHistorial").attr('disabled','disabled');
    $("#botonLevantar").attr('disabled','disabled');
}

function MostrarInversores(id){
    //si hay alguno seleccionado
    $("#chequeId").val($.fn.yiiGridView.getSelection(id));
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('clientes/getInversoresDeCheque') ?>",
            data:{'chequeId':$.fn.yiiGridView.getSelection(id)},
            dataType: 'Text',
            success:function(data){
                $('#inversores').html(data);
            }
    });
}

function MostrarBotonera(id){
    //si hay alguno seleccionado
    $("#chequeId").val($.fn.yiiGridView.getSelection(id));
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('cheques/getBotonera') ?>",
            data:{'id':$.fn.yiiGridView.getSelection(id)},
            dataType: 'Text',
            success:function(data){
                eval(data);
            }
        });

}

</script>


<h2><b>Listado de Cheques</b></h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cheques-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectionChanged' => 'AccionGridCheques',
	'columns'=>array(
		array(
            'header' => '',
            'class' => 'CCheckBoxColumn',
        ),
		array(
			'name'=>'numeroCheque',
			'header'=>'Numero Cheque',
			'value'=>'$data->numeroCheque',
			'htmlOptions'=>array('style'=>'text-align: right'),
		),
		array(
			'name'=>'bancoId',
			'header'=>'Banco',
			'value'=>'$data->banco->nombre',
		),
//		array(
//			'name'=>'libradorId',
//			'header'=>'Librador',
//			'value'=>'$data->librador->denominacion',
//		),
                array(
                    'name' => 'librador_denominacion',
                    'header' => 'Librador',
                    'value' => '$data->librador->denominacion',
                ),
		array(
			'name'=>'montoOrigen',
			'header'=>'Monto',
			'value'=>'Yii::app()->numberFormatter->format("#,##0.00",$data->montoOrigen)',
			'htmlOptions'=>array('style'=>'text-align: right'),
		),
		array(
			'name'=>'fechaPago',
			'header'=>'Fecha Pago',
			'value'=>'date("d/m/Y", strToTime($data->fechaPago))',
			'htmlOptions'=>array('style'=>'text-align: right'),
		),
		array(
			'name'=>'tipoCheque',
			'header'=>'Destino',
			'value'=>'$data->getTypeDescription("tipoCheque")',
		),
            	array(
			'name'=>'operacionCheque',
			'header'=>'Endosante',
			'value'=>'$data->operacionCheque->cliente->razonSocial',
		),
		array(
			'name'=>'endosante',
			'header'=>'2do Endoso',
			'value'=>'$data->endosante',
		),
		array(
			'name'=>'estado',
			'header'=>'Estado',
			'value'=>'$data->getTypeDescription("estado")',
			'filter'=> Cheques::model()->getTypeOptions("estado"),  
		),
	),
));
?>
<div id="inversores"></div>
<?php
$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'',
			));
			 echo "<b>Acciones Habilitadas para este Cheque</b>";
$this->endWidget();


?>
<?php echo CHtml::form(Yii::app()->createUrl("/cheques/updateCampos"));?>
<?php echo CHtml::hiddenField('chequeId', '', array('id' => 'chequeId')); ?>
<table>
    <tr>
        <td>
<?php echo CHtml::submitButton("Cambiar Destino",array("id"=>"botonCambiarDestino","name"=>"boton","disabled"=>"disabled"))?>
<?php echo CHtml::submitButton("Reemplazar",array("id"=>"botonReemplazar","name"=>"boton","disabled"=>"disabled"))?>
<?php echo CHtml::submitButton("Entregar al Cliente",array("id"=>"botonEntregaCliente","name"=>"boton","disabled"=>"disabled"))?>
<?php echo CHtml::submitButton("Devolucion del Cliente",array("id"=>"botonDevolucionCliente","name"=>"boton","disabled"=>"disabled"))?>
<?php echo CHtml::submitButton("Alta como Rechazado",array("id"=>"botonAltaRechazado","name"=>"boton","disabled"=>"disabled"))?>
<?php echo CHtml::submitButton("Baja como Rechazado",array("id"=>"botonBajaRechazado","name"=>"boton","disabled"=>"disabled"))?>
<?php echo CHtml::submitButton("Historial",array("id"=>"botonHistorial","name"=>"boton","disabled"=>"disabled"))?>
<?php echo CHtml::submitButton("Acreditar",array("id"=>"botonLevantar","name"=>"boton","disabled"=>"disabled"))?>
        </td>
    </tr>
</table>

