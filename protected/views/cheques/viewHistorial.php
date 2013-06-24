<?php
$this->breadcrumbs = array(
    'Cheques' => array('adminCheques'),
    'Modificar',
);

$this->menu = array(
    array('label' => 'Listado de Cheques', 'url' => array('adminCheques')),
);
?>

<h2><b>Historial del Cheque</b></h2>
<?php
//datos del cheque
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => 'Informacion del cheque',
));
echo "<b>#</b> " . $cheque->id . "<br>";
echo "<b>Numero cheque :</b> " . $cheque->numeroCheque . "<br>";
echo "<b>Banco :</b> " . $cheque->banco->nombre . "<br>";
echo "<b>Librador :</b> " . $cheque->librador->denominacion . "<br>";
echo "<b>Monto Origen:</b> " . Utilities::MoneyFormat($cheque->montoOrigen) . "<br>";
echo "<b>Monto Neto:</b> " . Utilities::MoneyFormat($cheque->montoNeto) . "<br>";
echo "<b>Fecha Vencimiento :</b> " . date("d/m/Y", strToTime($cheque->fechaPago)) . "<br>";
echo "<b>Endosante :</b> " . $cheque->endosante . "<br>";
echo "<b>Tipo Cheque :</b> " . $cheque->getTypeDescription("tipoCheque") . "<br>";
echo "<b>Estado Actual :</b> " . $cheque->getTypeDescription("estado") . "<br>";

$this->endWidget();


//datos de la compra
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => 'Informacion de la compra',
));
echo "<b>Comprado a :</b> " . $cheque->operacionCheque->cliente->razonSocial . "<br>";
echo "<b>Fecha :</b> " . $cheque->operacionCheque->fecha . "<br>";
echo "<b>Operador :</b> " . $cheque->operacionCheque->operador->apynom . "<br>";

$this->endWidget();

//datos de la Colocaciones

if (count($colocaciones) > 0) { // si hay colocaciones
    $titulo="Informacion de Colocacion Anterior";
    $numColocaciones=count($colocaciones);
    for($i=0;$i<$numColocaciones;$i++) {
        if($i==($numColocaciones-1))
            $titulo='Informacion de la Colocacion Actual';

        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => $titulo,
        ));
        echo "<b>Fecha :</b> " . date("d/m/Y", strToTime($colocaciones[$i]->fecha)) . "<br>";
        echo "<b>Operador :</b> " . $colocaciones[$i]->userStamp . "<br>";

        echo "<b>Inversores:</b> " . "<br>";

        foreach ($colocaciones[$i]->detalleColocaciones as $dc) {

            echo "    <b>Razon Social: </b>" . $dc->cliente->razonSocial . "<br>";;
            echo "  <b>Monto: </b>" . Utilities::MoneyFormat($dc->monto) . "<br>";
            echo " <b>Porcentaje de Tenencia: </b> " . Clientes::model()->getPorcentajeTenencia(null, $dc->clienteId, $colocaciones[$i]->id) . "<br>";
            echo "  <b>Tasa: </b>" . $dc->tasa . "<br>";
            echo "<br>";
        }

        $this->endWidget();
    }
}

//datos de la pesificacion
if(isset($pesificacion)){

        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => 'Informacion de la Pesificacion',
        ));
            echo "<b>Fecha :</b> " . date("d/m/Y", strToTime($pesificacion->fecha)) . "<br>";
            echo "<b>Pesificador :</b> " . $pesificacion->pesificador->denominacion . "<br>";
            echo "<b>Estado de la pesificacion : </b>";
            echo ($pesificacion->estado==0) ? "ABIERTO" : "CERRADO";
            if($pesificacion->estado==1)
                echo "<br/><b>Fecha de Acreditacion: </b>".date("d/m/Y h:i:s", strToTime($pesificacion->timeStamp));

        $this->endWidget();
}

// if(isset($chequeRechazado)){
//         $this->beginWidget('zii.widgets.CPortlet', array(
//             'title' => 'Rechazo del cheque',
//         ));
//             echo "<b>Fecha del rechazo:</b> " . date("d/m/Y", strToTime($pesificacion->timeStamp)) . "<br>";
//             echo "<b>Pesificador :</b> " . $chequeRechazado->pesificaciones->pesificador->denominacion . "<br>";
//             echo "<b>Gastos del rechazo :</b> " . Utilities::MoneyFormat($chequeRechazado->gastosRechazo) . "<br>";
//         $this->endWidget();
// }
?>