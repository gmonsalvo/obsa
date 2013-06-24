    <?php
    $this->beginWidget('zii.widgets.CPortlet', array(
        'id' => 'portletDetalleCheque',
        'title' => '',
    ));
    echo "<b>Detalle del cheque</b><br><br>"; 
    ?>
<table>
    <tr>
        <td><b>Numero Cheque</b></td>
        <td><?php echo $model->numeroCheque?></td>
        <td><b>Librador</b></td>
        <td><?php echo $model->librador->denominacion?></td>
    </tr>
    <tr>
        <td><b>Banco</b></td>
        <td><?php echo $model->banco->nombre?></td>
        <td><b>Monto Nominal</b></td>
        <td><?php echo Utilities::MoneyFormat($model->montoOrigen)?></td>
    </tr>
    <tr>
        <td><b>Fecha de Pago</b></td>
        <td><?php echo Utilities::ViewDateFormat($model->fechaPago)?></td>
        <td><b>Endosante</b></td>
        <td><?php echo $model->endosante?></td>
    </tr>
</table>
<?php
    $this->endWidget("portletDetalleCheque");
    ?>
