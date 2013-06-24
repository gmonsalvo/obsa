<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => 'Detalles de la Orden de Pago',
));

?>
<div class="row">
    <strong><?php echo CHtml::label("Fecha", "fechaOrden") ?></strong>
    <?php echo CHtml::textField("fechaOrden", Utilities::ViewDateFormat($ordenesPago->fecha), array("id" => "fechaOrden", "readonly" => "readonly")); ?>
</div>

<div class="row">
    <strong><?php echo CHtml::label("Monto Cheques", "montoCheques") ?></strong>
    <?php echo CHtml::textField("montoCheques", $montoCheques, array("id" => "montoCheques","readonly"=>"readonly")); ?>
</div>

<?php 
if(!empty($montoCheques)){
    echo "<br />";
    $this->renderPartial("/formaPagoOrden/formaPagoOrdenPendientes",array("dataProvider"=>$dataProvider)); 
}
?>
<div class="row">
    <strong><?php echo CHtml::label("Monto pagado efectivo", "montoPagadoEfectivo") ?></strong>
    <?php echo CHtml::textField("montoPagadoEfectivo", $montoPagadoEfectivo, array("id" => "montoPagadoEfectivo", "readonly"=>"readonly")); ?>
</div>    
<div class="row">
    <strong><?php echo CHtml::label("Monto a pagar (efectivo)", "montoPagar") ?></strong>
    <?php 
    $this->widget("FormatCurrency",
                array(
                    "name" => "montoPagar",
                    "value" => $saldoEfectivo,
                    ));
    ?>
</div>


<div class="row">
    <strong><?php echo CHtml::label("Saldo efectivo", "saldoEfectivo") ?></strong>
    <?php echo CHtml::textField("saldoEfectivo", $saldoEfectivo, array("id" => "saldoEfectivo","readonly"=>"readonly")); ?>
</div>
<div class="row">
    <strong><?php echo CHtml::label("Monto Total", "monto") ?></strong>
    <?php echo CHtml::textField("monto", Utilities::MoneyFormat($ordenesPago->monto), array("id" => "monto", "readonly" => "readonly")); ?>
</div>
    <?php
    //echo Chtml::hiddenField("montoEfectivoOriginal",$montoEfectivo,array("id"=>"montoEfectivoOriginal"));
    ?>
<?php $this->endWidget();?>

