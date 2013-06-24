<script>
    function DetallePresupuesto(id)
    {
        if(id!=""){
            $.ajax({
                type: 'POST',
                url: "<?php echo CController::createUrl('presupuestoOperacionesCheques/getDetallePresupuesto') ?>",
                data:{'presupuestoOperacionesChequesId':$.fn.yiiGridView.getSelection("presupuesto-operaciones-cheques-grid")},
                dataType: 'Text',
                success:function(data){
                    $("#detallePresupuesto").html(data);
                    $("#id").val($.fn.yiiGridView.getSelection("presupuesto-operaciones-cheques-grid"));
                }
            });
        }else
            $("#detallePresupuesto").html("");
    }
</script>

<?php
$this->breadcrumbs = array(
    'Presupuesto Operaciones Cheques' => array('index'),
    'Manage',
);

$this->menu = array(
     array('label' => 'Nuevo Presupuesto', 'url' => array('nuevaOperacion')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('presupuesto-operaciones-cheques-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Lista de Presupuestos</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'presupuesto-operaciones-cheques-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'selectionChanged' => 'DetallePresupuesto',
    'selectableRows' => 1,
    'columns' => array(
        array(
            'header' => 'Presupuesto seleccionado',
            'class' => 'CCheckBoxColumn',
        ),
        array(
            'name' => 'clienteId',
            'header' => 'Cliente',
            'value' => '$data->cliente->razonSocial',
        ),
        array(
            'name' => 'montoNetoTotal',
            'header' => 'Monto',
            'value' => 'Utilities::MoneyFormat($data->montoNetoTotal)',
        ),
        array(
            'name' => 'fecha',
            'header' => 'Fecha',
            'value' => 'Utilities::ViewDateFormat($data->fecha)',
        ),
    ),
));
?>
<div id="detallePresupuesto"></div>
