<?php
/*
$this->breadcrumbs = array(
    'Ordenes de Ingreso' => array('index'),
    'Manage',
);*/

$this->menu = array(
    array('label' => 'Nueva Orden de Ingreso', 'url' => array('create')),
);
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
<style>
    #grid{
        position:relative;
        overflow: auto;
    }
</style>


<script>


function MostrarDetalles(id){
    //si hay alguno seleccionado
    $("#ordenIngresoId").val($.fn.yiiGridView.getSelection(id));

	if($.fn.yiiGridView.getSelection(id)!=''){

                $('#botonPagar').removeAttr("disabled");
                $('#botonAnular').removeAttr("disabled");

    }
    else
    {
        $('#botonPagar').attr("disabled","disabled");
        $('#botonAnular').attr("disabled","disabled");
    }
}

</script>
<h1>Lista de Ordenes de Ingreso</h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'ordenes-ingreso-grid',
    'dataProvider' => $model->searchByEstado(OrdenIngreso::ESTADO_PENDIENTE),
    'selectableRows' => 1,
    'filter' => $model,
    'selectionChanged' => 'MostrarDetalles',
    'columns' => array(
        array(
            'header' => 'Orden de pago seleccionada',
            'class' => 'CCheckBoxColumn',
        ),
		'fecha',
        array(
            'name' => 'clienteId',
            'header' => 'Cliente',
            'value' => '$data->productoCtaCte->cliente->razonSocial',
        ),
		array(
            'name' => 'productoId',
            'header' => 'Producto',
            'value' => '$data->productoCtaCte->producto->nombre',
        ),
        array(
            'name' => 'productoCtaCte',
            'header' => 'productoCtaCte',
            'value' => '$data->productoCtaCte->id',
        ),
        array(
            'name' => 'monto',
            'header' => 'Monto a Pagar',
            'value' => 'Utilities::MoneyFormat($data->monto)',
        ),
        'descripcion',
    ),
));
?>

<?php echo CHtml::form(Yii::app()->createUrl("/ordenIngreso/updateOrden"));?>
<?php echo CHtml::hiddenField('ordenIngresoId', '', array('id' => 'ordenIngresoId')); ?>
<table>
    <tr>
        <td>
            <?php echo CHtml::submitButton("Acreditar Fondos",array("id"=>"botonPagar","name"=>"boton","disabled"=>"disabled"))?>
            <?php echo CHtml::submitButton("Anular",array("id"=>"botonAnular","name"=>"boton","disabled"=>"disabled"))?>
        </td>
    </tr>
</table>