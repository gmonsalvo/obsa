<table border=1 class="formulario">
    <tr>
        <td><?php echo CHtml::label($ordenesCambio->operacionCambio->tipoOperacion==OperacionesCambio::TYPE_COMPRA ? "Entran ".$ordenesCambio->operacionCambio->moneda->denominacion : "Salen ".$ordenesCambio->operacionCambio->moneda->denominacion, "sale") ?> </td>
        <td><?php echo CHtml::textField("montoSale", $ordenesCambio->monto, array("id" => "sale", "readonly" => "readonly")); ?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::label($ordenesCambio->operacionCambio->tipoOperacion==OperacionesCambio::TYPE_COMPRA ? "Salen pesos" : "Entra pesos", "entra") ?> </td>
        <td><?php echo CHtml::textField("montoEntra", $ordenesCambio->monto*$ordenesCambio->operacionCambio->tasaCambio, array("id" => "entra", "readonly" => "readonly")); ?></td>
    </tr>
</table>    

