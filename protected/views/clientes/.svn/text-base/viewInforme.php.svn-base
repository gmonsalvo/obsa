<br>
<h1>Detalles</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'grid',
    'dataProvider' => $arrayDataProvider,
    'columns' => array(
        array(
            'name' => 'Numero Cheque',
            'type' => 'raw',
            'value' => 'CHtml::encode($data["numeroCheque"])'
        ),
        array(
            'name' => 'Banco',
            'type' => 'raw',
            'value' => '$data["banco"]'
        ),
        array(
            'name' => 'Librador',
            'type' => 'raw',
            'value' => '$data["librador"]'
        ),
        array(
            'name' => 'Fecha Inicio',
            'type' => 'raw',
            'value' => '$data["fechaInicio"]'
        ),
        array(
            'name' => 'Fecha Vto.',
            'type' => 'raw',
            'value' => '$data["fechaPago"]'
        ),
        array(
            'name' => 'Dias',
            'type' => 'raw',
            'value' => '$data["dias"]'
        ),
        array(
            'name' => '% Tenencia',
            'type' => 'raw',
            'value' => 'Utilities::truncateFloat($data["porcentajeTenencia"],2)'
        ),
        array(
            'name' => 'Capital',
            'type' => 'raw',
            'value' => 'Utilities::moneyFormat($data["capital"])'
        ),
        array(
            'name' => 'Intereses',
            'type' => 'raw',
            'value' => 'Utilities::moneyFormat($data["intereses"])'
        ),
        array(
            'name' => 'Monto',
            'type' => 'raw',
            'value' => 'Utilities::moneyFormat($data["valorNominal"])'
        ),
        array(
            'name' => 'Valor Actual',
            'type' => 'raw',
            'value' => 'Utilities::moneyFormat($data["valorActual"])'
        ),
    ),
));
?>
<div align="right">Total valor actual: <?php echo Utilities::MoneyFormat($valorActualTotal); ?></div>
<div align="right">Efectivo: <?php echo Utilities::MoneyFormat($saldo); ?></div>
<div align="right">Total: <?php echo Utilities::MoneyFormat($saldo + $valorActualTotal); ?></div>
<br>
<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => 'Resumen',
));
echo $resumen;
$this->endWidget();
?>
