<h1>Ranking de Libradores</h1>
<script>
function exportar(){
    window.open("/libradores/exportarRanking");
}
</script>
<input type="button" onclick="exportar()" value="Exportar">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $arrayDataProvider,
    'columns' => array(
        array(
            'name' => 'Librador',
            'type' => 'raw',
            'value' => 'CHtml::encode($data["librador"])'
        ),
        array(
            'name' => 'Total',
            'type' => 'raw',
            'value' => 'Utilities::MoneyFormat($data["total"])'
        ),
        array(
            'name' => '% en cartera',
            'type' => 'raw',
            'value' => 'Utilities::truncateFloat($data["porcentajeEnCartera"],2)'
        ),
    ),
));
?>

<div align="right">Total en Cartera: <?php echo Utilities::MoneyFormat($totalEnCartera);
?></div>
