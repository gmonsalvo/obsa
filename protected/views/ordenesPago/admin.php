<?php


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ordenes-pago-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

?>
<?php
Yii::app()->clientScript->registerScript('validarScript', "
$('#form_ordenPago').submit(function() {
    var montoPagar = parseFloat($('#montoPagar').val());
    var saldoEfectivo = parseFloat(Unformat($('#saldoEfectivo').val()));
    if(montoPagar>saldoEfectivo){
        alert('El monto a pagar en efectivo no puede ser superior al saldo');
        return false;
    }
    if(montoPagar<=0){
        alert('El monto a pagar no puede ser cero');
        return false;
    }
});
");
?>
<style>
    #grid{
        position:relative;
        overflow: auto;
    }
</style>


<script>

    function Unformat(nStr)
    {
        nStr += '';
        x = nStr.split('$ ');
        y = x[1];
        //return y;
        //alert(y);
        y = y.split('.');
        var z='';
        for(var i=0;i<y.length;i++)
            z=z+y[i];
        x = z.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        return x1 + x2;

    }

function MostrarDetalles(id){
    //si hay alguno seleccionado
    $("#ordenPagoId").val($.fn.yiiGridView.getSelection(id));
    if($.fn.yiiGridView.getSelection(id)!=''){
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('ordenesPago/getDetalles') ?>",
            data:{'id':$.fn.yiiGridView.getSelection(id)},
            dataType: 'Text',
            success:function(data){
                $('#grid').html(data).show();
                $('#botonPagar').removeAttr("disabled");
                $('#botonAnular').removeAttr("disabled");
            }
        });
    }
    else
    {
        $('#grid').hide();
        $('#botonPagar').attr("disabled","disabled");
        $('#botonAnular').attr("disabled","disabled");
    }
}

</script>
<h1>Lista de Ordenes de Pagos</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'ordenes-pago-grid',
    'dataProvider' => $model->searchByEstado(OrdenesPago::ESTADO_PENDIENTE),
    'selectableRows' => 1,
    'filter' => $model,
    'selectionChanged' => 'MostrarDetalles',
    'columns' => array(
        array(
            'header' => 'Orden de pago seleccionada',
            'class' => 'CCheckBoxColumn',
        ),
        array(
            'name' => 'clienteId',
            'header' => 'Cliente',
            'value' => '$data->cliente->razonSocial',
        ),
        'fecha',
        array(
            'name' => 'saldo',
            'header' => 'Saldo',
            'value' => 'Utilities::MoneyFormat($data->saldo)',
        ),
        array(
            'name' => 'monto',
            'header' => 'Total',
            'value' => 'Utilities::MoneyFormat($data->monto)',
        ),
        'descripcion',
    ),
));
?>

<?php echo CHtml::form(Yii::app()->createUrl("/ordenesPago/updateOrden"),"post",array("id"=>"form_ordenPago"));?>
<div id='grid' style="display:none">
<?php
    $formaPagoOrden =  new FormaPagoOrden;
    $formaPagoOrden->tipoFormaPago = FormaPagoOrden::TIPO_CHEQUES;
    $dataProvider = $formaPagoOrden->search(); //tipo de cheque en cartera colocado
    $dataProvider->setPagination(false);

    $render = $this->renderPartial('/ordenesPago/detalleOrdenesPago', array('ordenesPago' => new OrdenesPago, 'formaPagoOrden' => $formaPagoOrden,'montoEfectivo' => 0, 'montoCheques' => Utilities::MoneyFormat(0),"dataProvider" => $dataProvider, "processOutput"=>false
            ), true, false);

    echo $render;
?>
</div>

<?php echo CHtml::hiddenField('ordenPagoId', '', array('id' => 'ordenPagoId')); ?>
<table>
    <tr>
        <td>
            <?php echo CHtml::submitButton("Pagar",array("id"=>"botonPagar","name"=>"boton","disabled"=>"disabled"))?>
            <?php echo CHtml::submitButton("Anular",array("id"=>"botonAnular","name"=>"boton","disabled"=>"disabled"))?>
        </td>
    </tr>
</table>




