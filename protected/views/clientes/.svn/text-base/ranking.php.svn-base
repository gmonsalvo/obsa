<h1>Ranking de Clientes</h1>


<script>
function exportar(obj){
    if(obj.value=="Exportar Todo")
        var paginacion = 0;
    else
        var paginacion = 1;
    window.open("/clientes/exportarRanking?paginacion="+paginacion);
}
</script>
<input type="button" onclick="exportar(this)" value="Exportar Vista">
<input type="button" onclick="exportar(this)" value="Exportar Todo">
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $arrayDataProvider,
    'columns' => array(
        array(
            'name' => 'Cliente',
            'type' => 'raw',
            'value' => 'CHtml::encode($data["razonSocial"])'
        ),
        array(
            'name' => 'Efectivo',
            'type' => 'raw',
            'value' => 'Utilities::MoneyFormat($data["saldo"])'
        ),
        array(
            'name' => 'Cheques',
            'type' => 'raw',
            'value' => 'Utilities::MoneyFormat($data["saldoColocaciones"])'
        ),
        array(
            'name' => 'Total',
            'type' => 'raw',
            'value' => 'Utilities::MoneyFormat($data["total"])'
        ),
        array(
            'name' => '%',
            'type' => 'raw',
            'value' => 'Utilities::truncateFloat($data["porcentaje"],2)'
        ),
    ),
));
?>
<div align="right">Total: <?php echo Utilities::MoneyFormat($sumaTotal); ?></div>