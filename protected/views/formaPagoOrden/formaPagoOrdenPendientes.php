<?php if(count($dataProvider->getData())>0) { ?>
        <table class="ui-widget ui-widget-content">
            <thead>
                <tr class="ui-widget-header ">
                    <th>Fecha Venc.</th>
                    <th>Nro. Cheque</th>
                    <th>Banco</th>
                    <th>Monto Nominal</th>
                    <th>Librador</th>
                </tr>
                <?php foreach ($dataProvider->getData() as $formaPagoOrden) {
                    echo "<tr>";
                    echo "<td>".Utilities::ViewDateFormat($formaPagoOrden->cheque->fechaPago)."</td>";
                    echo "<td>".$formaPagoOrden->cheque->numeroCheque."</td>";
                    echo "<td>".$formaPagoOrden->cheque->banco->nombre."</td>";
                    echo "<td>".Utilities::MoneyFormat($formaPagoOrden->monto)."</td>";
                    echo "<td>".$formaPagoOrden->cheque->librador->denominacion."</td>";
                    echo "</tr>";
                } ?>
            </thead>
            <tbody>
            </tbody>
        </table>
<?php } ?>
<?php
// $this->widget('zii.widgets.grid.CGridView', array(
//     'id' => 'forma-pago-orden-grid',
//     'dataProvider' => $dataProvider,
//     'columns' => array(
//         array(
//             'name' => 'cheque',
//             'header' => 'Fecha Venc.',
//             'value' => '$data->cheque->fechaPago',
//         ),
//         array(
//             'name' => 'cheque',
//             'header' => 'Nro Cheque',
//             'value' => '$data->cheque->numeroCheque',
//         ),
//         array(
//             'name' => 'cheque',
//             'header' => 'Banco',
//             'value' => '$data->cheque->banco->nombre',
//         ),
//         array(
//             'name' => 'monto',
//             'header' => 'Monto Nominal',
//             'value' => 'Utilities::MoneyFormat($data->monto)',
//         ),
//         array(
//             'name' => 'cheque',
//             'header' => 'Librador',
//             'value' => '$data->cheque->librador->denominacion',
//         ),
//     ),
// ));
?>