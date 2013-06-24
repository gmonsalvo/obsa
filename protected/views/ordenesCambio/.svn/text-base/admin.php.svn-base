<?php
$this->breadcrumbs = array(
    'Ordenes de Cambio' => array('index'),
    'Manage',
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ordenes-cambio-grid', {
		data: $(this).serialize()
	});
	return false;
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


function MostrarDetalles(id){
    //si hay alguno seleccionado
    $("#ordenCambioId").val($.fn.yiiGridView.getSelection(id));
    if($.fn.yiiGridView.getSelection(id)!=''){
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('ordenesCambio/getDetalles') ?>",
            data:{'id':$.fn.yiiGridView.getSelection(id)},
            dataType: 'Text',
            success:function(data){
                $('#grid').html(data);
                $('#botonPagar').removeAttr("disabled");
                $('#botonAnular').removeAttr("disabled");
            }
        });
    }
    else
    {
        $('#grid').html("");
        $('#botonPagar').attr("disabled","disabled");
        $('#botonAnular').attr("disabled","disabled");
    }
}

</script>
<h1>Lista de Ordenes de Cambio</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'ordenes-pago-grid',
    'dataProvider' => $model->searchByEstado(OrdenesCambio::ESTADO_PENDIENTE),
    'selectableRows' => 1,
    'filter' => $model,
    'selectionChanged' => 'MostrarDetalles',
    'columns' => array(
        array(
            'header' => 'Orden de pago seleccionada',
            'class' => 'CCheckBoxColumn',
        ),
        array(
            'name' => 'operacionCambioId',
            'header' => 'Cliente',
            'value' => '$data->operacionCambio->cliente->razonSocial',
        ),
        'fecha',
        array(
            'name' => 'monto',
            'header' => 'Monto a Pagar',
            'value' => 'Utilities::MoneyFormat($data->monto)',
        ),
        'descripcion',
    ),
));
?>


<div id='grid'><?php
//$dataProvider = $formaPagoOrden->search(); //tipo de cheque en cartera colocado
//$dataProvider->setPagination(false);
//$this->renderPartial('/formaPagoOrden/formaPagoOrdenPendientes', array('formaPagoOrden' => $formaPagoOrden,
//    'dataProvider' => $dataProvider,
//));
?>
</div>

<?php echo CHtml::form(Yii::app()->createUrl("/ordenesCambio/updateOrden"));?>
<?php echo CHtml::hiddenField('ordenCambioId', '', array('id' => 'ordenCambioId')); ?>
<table>
    <tr>
        <td>
            <?php echo CHtml::submitButton("Pagar",array("id"=>"botonPagar","name"=>"boton","disabled"=>"disabled"))?>
            <?php echo CHtml::submitButton("Anular",array("id"=>"botonAnular","name"=>"boton","disabled"=>"disabled"))?>
        </td>
    </tr>
</table>




