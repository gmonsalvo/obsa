<?php
/* @var $this PesificacionesController */
/* @var $model Pesificaciones */
?>
<script>
    function validate()
    {
        if($("#saldo").val()<0){
            alert("La suma del efectivo recibido y los gastos superan el monto Total");
            return false;
        }
        return true;
    }

    function recalcular(){
        var subtotalGastos=parseFloat($("#gastosPesificacionCheques").val()) + parseFloat($("#gastosVarios").val()) + parseFloat($("#montoGastosChequesRechazados").val());
        $("#montoGastos").val(subtotalGastos);
        var saldo=parseFloat($("#totalNominalCheques").val())-parseFloat(subtotalGastos)-parseFloat($("#montoAcreditar").val());
        $("#saldo").val(saldo);
        //        var totalPesific=parseFloat(Unformat($("#montoTotal").val()));
        //        if(total>totalPesific){
        //                alert("La suma del monto a acreditar y los gastos superan el monto Total de la pesificacion");
        //                $("#botonAcreditar").attr("disabled","disabled");
        //        }
        //        else
        //            $("#botonAcreditar").removeAttr("disabled");
    }

    function MoneyFormat(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return '$ '+x1 + x2;
    }

    function Unformat(nStr)
    {
        nStr += '';
        x = nStr.split('$ ');
        y = x[1];
        y = y.split('.');
        var z='';
        for(var i=0;i<y.length;i++)
            z=z+y[i];
        x = z.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        return x1 + x2;

    }

    function agregarCheque(){
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('cheques/getCheque') ?>",
            data:{'id':$.fn.yiiGridView.getSelection("cheques-grid")},
            dataType: 'Text',
            success:function(data){
                $( "#dialog-form" ).dialog( "open" );
                var datos=jQuery.parseJSON(data);
                $( "#chequeId" ).val(datos.chequeId);
                $( "#fechaPago" ).val(datos.fechaPago);
                $("#librador").val(datos.librador);
                $("#montoOrigen").val(datos.montoOrigen);
                $("#numeroCheque").val(datos.numeroCheque);
            }
        });
    }

    function rechazarCheque(){
        var error=0;
        if($('#listadoChequesRechazados').css("display")!="none"){
            $("#gridChequesRechazados tbody tr").each(function() {
                if($( "#chequeId" ).val()==$(this).children().eq(0).text()){
                    alert("El cheque " + $( "#numeroCheque" ).val() + " ya fue ingresado");
                    error=1;
                    return 0;
                }

            });
            if(error==1)
                return 0;
        }

        $('#listadoChequesRechazados').css("display","block");
        $( '#gridChequesRechazados tbody' ).append( '<tr>' +
            '<td>' + $( "#chequeId" ).val() + '</td>' +
            '<td>' + $( "#numeroCheque" ).val() + '</td>' +
            '<td>' + $( "#fechaPago" ).val() + '</td>' +
            '<td>'+ $("#librador").val() + '</td>' +
            '<td>'+ $("#montoOrigen").val() + '</td>' +
            '<td>' + $( "#gastosRechazo" ).val() + '</td>' +
            '<td onclick="Eliminar(this)"><span class="link">borrar</span></td>'+
            '</tr>' );
        $("#montoGastosChequesRechazados").val(parseFloat($("#montoGastosChequesRechazados").val())+parseFloat($( "#gastosRechazo" ).val()) + parseFloat($("#montoOrigen").val()));
        $("#montoGastosCheques").html("Total: "+$("#montoGastosChequesRechazados").val());
        recalcular();
        $( this ).dialog( 'close' );

    }

    function Close(){
        $( this ).dialog( 'close' );
    }

    function PrepararChequesRechazados()
    {
        if(!validate())
            return false;
        var chequesRechazar = [];
        var montosChequesRechazados = [];
        $('#gridChequesRechazados tbody tr').each(function(i, tr) {
            var ids = [];
            var montos = [];
            $('td', tr).each(function(i, td) {
                // columna 0 es chequeId y columna 5 monto cheque
                if(i==0)
                    ids.push($(td).html());
                if(i==5)
                    montos.push($(td).html());
            });
            chequesRechazar.push(ids);
            montosChequesRechazados.push(montos);
        });
        $("#chequesIdRechazar").val(chequesRechazar);
        $("#montosChequesRechazados").val(montosChequesRechazados);
    }

    function Eliminar(obj){
        if(confirm("Desea eliminar la fila?")){
            var gastosRechazo=$(obj).parent().children().eq(5).text(); //monto colocado
            var montoNominal=$(obj).parent().children().eq(4).text(); //monto colocado
            $("#montoGastosChequesRechazados").val(parseFloat($("#montoGastosChequesRechazados").val())-parseFloat(gastosRechazo) - parseFloat(montoNominal));
            $("#montoGastosCheques").html("Total: "+$("#montoGastosChequesRechazados").val());

            $(obj).parent("tr").remove();
            if($('#gridChequesRechazados >tbody >tr').length == 0)
                $('#listadoChequesRechazados').hide();
        }
        recalcular();

    }

</script>
<style>
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
    .mgrid_table tbody:hover
    {
        cursor: pointer;
    }
    .link{
        color:blue;
        text-decoration: underline;
    }
    .link:hover{
        text-decoration: underline;
        color:blue;
        cursor:pointer}
    </style>
    <?php $montoGastosRechazados = ChequesRechazados::model()->getMontoTotalCheques($model->id);?>
    <?php
    $this->breadcrumbs = array(
        'Pesificaciones' => array('index'),
        'Manage',
    );

    $this->menu = array(
        array('label' => 'Nueva Pesificacion', 'url' => array('create')),
    );
    ?>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialog-form',
        'options' => array(
            'title' => 'Marcar cheque rechazado',
            'autoOpen' => false,
            'modal' => 'true',
            'buttons' => array(
                'Asignar colocacion' => "js:rechazarCheque",
                'Cancelar' => "js:Close",
            ),
        ),
        'htmlOptions' => array('style' => 'font-size: 62.5%;height:476.133px'),
    ));
    ?>
    <div title="Create new user" style="font-size: 120%;">

    <fieldset>
        <?php echo CHtml::hiddenField("chequesRechazados", "", array("id" => "chequesRechazados")) ?>
        <?php echo CHtml::hiddenField("montoGastosChequesRechazados", $montoGastosRechazados, array("id" => "montoGastosChequesRechazados")) ?>
        <?php echo CHtml::hiddenField("chequeId", "", array("id" => "chequeId")) ?>
        <?php echo CHtml::hiddenField("numeroCheque", "", array("id" => "numeroCheque")) ?>
        <?php echo CHtml::hiddenField("librador", "", array("id" => "librador")) ?>
        <?php echo CHtml::hiddenField("fechaPago", "", array("id" => "fechaPago")) ?>
        <?php echo CHtml::hiddenField("montoOrigen", "", array("id" => "montoOrigen")) ?>
        Gastos por cheque rechazado:
        <input type="text" name="gastosRechazo" id="gastosRechazo" value="" class="text ui-widget-content ui-corner-all" />
    </fieldset>
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<div id="detallePesificaciones">
    <?php echo $this->renderPartial('/detallePesificaciones/verDetalles', array('model' => $model, "totalNetoCheques" => $totalNetoCheques)); ?>
</div>

<div id="listadoChequesAcreditados">
    <?php
    $this->beginWidget('zii.widgets.CPortlet', array(
        'id' => 'portletChequesAcreditados',
        'title' => '',
    ));
    echo "<b>Listado de cheques acreditados</b><br><br>";
    ?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'cheques-grid',
        'dataProvider' => $cheques->searchChequesByEstado(array(Cheques::TYPE_ACREDITADO)),
        'filter' => $cheques,
        'selectionChanged' => 'agregarCheque',
        'columns' => array(
            'numeroCheque',
            array(
                'name' => 'fechaPago',
                'header' => 'Fecha Venc.',
                'value' => '$data->fechaPago',
            ),
            array(
                'name' => 'librador_denominacion',
                'header' => 'Librador',
                'value' => '$data->librador->denominacion',
            ),
            array(
                'name' => 'montoOrigen',
                'header' => 'Valor Nominal',
                'value' => 'Utilities::MoneyFormat($data->montoOrigen)',
            ),
            array(
                'name' => 'banco_nombre',
                'header' => 'Banco',
                'value' => '$data->banco->nombre',
            ),
        ),
        'htmlOptions' => array(
            'class' => 'grid-view mgrid_table',
        ),
    ));
    ?>

    <?php
    $this->endWidget("portletChequesAcreditados");
    ?>
</div>
<?php
$tablaCheques=ChequesRechazados::model()->getChequesRechazadosHtml($model->id);?>
<div id="listadoChequesRechazados" style="<?php if($tablaCheques=="") echo "display:none"?>">
    <?php if($tablaCheques=="") { ?>
        <table id="gridChequesRechazados" class="ui-widget ui-widget-content">
            <thead>
                <tr class="ui-widget-header ">
                    <th>Id Cheque</th>
                    <th>Numero Cheque</th>
                    <th>Fecha Venc.</th>
                    <th>Librador</th>
                    <th>Valor Nominal</th>
                    <th>Gastos de rechazo</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    <?php }else
            echo $tablaCheques;
        ?>
    <div id="montoGastosCheques" align="right">Total: <?php echo $montoGastosRechazados?></div>
</div>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'pesificaciones-form',
        'enableAjaxValidation' => false,
        'action' => CController::createUrl('pesificaciones/acreditar'),
        'htmlOptions' => array('onSubmit' => 'return PrepararChequesRechazados()'),
            ));
    ?>
    <div align="left"><?php echo CHtml::label("Gastos Varios", "gastosVarios"); ?></div>
    <?php echo CHtml::textField("gastosVarios", ($model->montoGastos - $montoGastosRechazados - $gastosPesificacionCheques), array("id" => "gastosVarios", "onblur" => "recalcular(this)")); ?>
    <div align="left"><?php echo CHtml::label("Subtotal Gastos", "montoGastos"); ?></div>
    <?php echo CHtml::textField("montoGastos", $model->montoGastos, array("id" => "montoGastos", "readonly" => "readonly")); ?>
    <div align="left"><?php echo CHtml::label("Efectivo Recibido", "montoAcreditar"); ?></div>
    <?php echo CHtml::textField("montoAcreditar", $model->montoAcreditar, array("id" => "montoAcreditar", "onblur" => "recalcular(this)")); ?>
    <div align="left"><?php echo CHtml::label("Saldo", "saldo"); ?></div>
    <?php echo CHtml::textField("saldo", ($totalNominalCheques - $model->montoGastos - $model->montoAcreditar), array("id" => "saldo", "disabled" => "disabled")); ?>
    <?php echo CHtml::hiddenField("totalNominalCheques", $totalNominalCheques, array("id" => "totalNominalCheques")) ?>
    <?php echo CHtml::hiddenField("gastosPesificacionCheques", $gastosPesificacionCheques, array("id" => "gastosPesificacionCheques")) ?>
    <?php echo CHtml::hiddenField("chequesIdRechazar", "", array("id" => "chequesIdRechazar")) ?>
    <?php echo CHtml::hiddenField("montosChequesRechazados", "", array("id" => "montosChequesRechazados")) ?>
    <?php echo CHtml::hiddenField("pesificacionId", $model->id, array("id" => "pesificacionId")) ?>
    <div class="row buttons">
<?php echo CHtml::submitButton("Acreditar", array("id" => "botonAcreditar")); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
