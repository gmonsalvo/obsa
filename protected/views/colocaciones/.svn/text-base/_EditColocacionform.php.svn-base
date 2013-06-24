<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cheques-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<script>

$(document).ready(function() {
    $('#clientes-grid tbody tr').live('dblclick', function() {
            var id = $.fn.yiiGridView.getKey(
                'clientes-grid',
                $(this).prevAll().length
            );

            $.post("<?php echo CHtml::normalizeUrl(array('clientes/getCliente', 'render' => false))?>",{id: id},function(data){
                            var datos=jQuery.parseJSON(data);
                            $( "#dialog-form" ).dialog( "open" );
                            $("#nombreinversor").text("Inversor: "+datos.cliente.razonSocial);
                            $("#inversor").val(datos.cliente.razonSocial);
                            $("#idCliente").val(datos.cliente.id);
                            $("#montodisponible").val(datos.saldo);
                            $("#tasa").val(datos.cliente.tasaInversor);
                            if(parseFloat($("#montoPorColocar").val())>parseFloat($("#montodisponible").val()))
                                $("#monto").val($("#montodisponible").val());
                            else
                                $("#monto").val($("#montoPorColocar").val());
                            $("#monto").focus();

            });
    });
});

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

    function Limpiar()
    {
        $("#colocaciones tbody").empty();
        $('#cheques-colocados').css("display","none");
        //$.fn.yiiGridView.updateGrid('clientes-grid');
        $.fn.yiiGridView.update('clientes-grid'); //hago un update para deseleccionar
        $("#submitBoton").attr('disabled','disabled');
    }

    function Create(){
        var error=0;
        if($('#cheques-colocados').css("display")!="none"){
            $("#colocaciones tbody tr").each(function() {
                if($( "#idCliente" ).val()==$(this).children().eq(0).text()){
                    alert("El inversor " + $( "#inversor" ).val() + " ya fue ingresado. Eliminelo de la tabla y vuelva a cargarlo");
                    error=1;
                    return 0;
                }

            });
        }
        //el inversor ya fue colocado
        if(error)
            return 0;
        if($( "#monto" ).val()==''){
            alert('Debe ingresar un monto para la colocacion');
            return 0;
        }
        if($( "#tasa" ).val()==''){
            alert('Debe ingresar una tasa para la colocacion');
            return 0;
        }

        if(isNaN($("#tasa").val())){
            alert('La tasa debe ser un numero');
            return 0;
        }
        if(parseFloat($( "#tasa" ).val())<=0){
            alert('La tasa debe ser mayor a 0');
            return 0;
        }
        if(isNaN($("#monto").val())) {
            alert('El monto debe ser un numero');
            return 0;
        }
        if(parseFloat($( "#monto" ).val())<=0){
            alert("El monto debe ser superior a 0");
            return 0;
        }
        if(parseFloat($( "#monto" ).val())>parseFloat($('#montodisponible').val())){
            alert("El monto que esta asignando es mayor al monto disponible para colocar. Por favor modifique el monto a asignar");
            return 0;
        }

        if(parseFloat($( "#monto" ).val())>parseFloat($('#montoPorColocar').val())){
            alert("El monto que esta asignando es mayor al monto por colocar. Por favor modifique el monto a asignar");
            return 0;
        }

        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('colocaciones/calculoValorActual') ?>",
            data:{'idCheque':$("#idCheque").val(), 'montoColocado': $( "#monto" ).val(), 'tasa': $( "#tasa" ).val(), 'clearing':$("#clearing").val()},
            dataType: 'Text',
            success:function(data){
                //$("#montoValorActual").val(data);
                $('#cheques-colocados').css("display","block");
                $( '#colocaciones tbody' ).append( '<tr>' +
                    '<td>' + $( "#idCliente" ).val() + '</td>' +
                    '<td>' + $( "#inversor" ).val() + '</td>' +
                    '<td>'+ MoneyFormat($( "#monto" ).val()) + '</td>' +
                    '<td>'+ MoneyFormat(data) + '</td>' +
                    '<td>' + $( "#tasa" ).val() + '</td>' +
                    '<td onclick="Eliminar(this)"><span class="link">borrar</span></td>'+
                    '</tr>' );
                var monto=parseFloat($('#montoPorColocar').val())-parseFloat($( "#monto" ).val());
                $('#montoPorColocar').val(parseFloat(monto));
                if($('#montoPorColocar').val()==0)
                    $("#submitBoton").removeAttr('disabled');

            }
        });
        $( this ).dialog( 'close' );
    }
    function Close(){
        $( this ).dialog( 'close' );
    }
    function Eliminar(obj){
        if(confirm("Desea eliminar la fila")){
            var montoColocado=Unformat($(obj).parent().children().eq(2).text()); //monto colocado
            var monto=parseFloat($('#montoPorColocar').val())+parseFloat(montoColocado);
            $('#montoPorColocar').val(parseFloat(monto));
            $("#submitBoton").attr('disabled','disabled');
            $(obj).parent("tr").remove();
            if($('#colocaciones >tbody >tr').length == 0)
                $('#cheques-colocados').css("display","none");
        }

    }

    function CrearDetallesColocaciones()
    {
        var detalleColocaciones = $('#colocaciones tr').map(function() {
            return $(this).find('td').map(function() {
                if($(this).html().indexOf("$")!=-1)
                    return Unformat($(this).html());
                else
                    return $(this).html();
            }).get();
        }).get();
        $('#detallesColocaciones').val(detalleColocaciones);
    }

    function calcularDiasColocados(){
        var diasColocados=parseInt($("#diasColocados").val());
        diasColocados=diasColocados-parseInt($("#clearing_viejo").val())+parseInt($("#clearing").val());
        $("#clearing_viejo").val($("#clearing").val());
        $("#diasColocados").val(diasColocados);
        $("#Colocaciones_diasColocados").val(diasColocados);
        $("#Colocaciones_clearing").val($("#clearing").val());
    }


</script>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'colocaciones-form',
        'enableAjaxValidation' => false,
        'action' => Yii::app()->createUrl("/colocaciones/editarColocacion")
            ));
    ?>


    <?php echo $form->errorSummary($nuevoModel); ?>

    <div class="row">
        <?php echo $form->labelEx($nuevoModel, 'fecha'); ?>
        <?php echo $form->textField($nuevoModel, 'fecha', array('readonly' => 'readonly', 'value' => Utilities::ViewDateFormat($originalModel->fecha))); ?>
        <?php echo $form->error($nuevoModel, 'fecha'); ?>
    </div>

    <?php echo $form->hiddenField($nuevoModel, 'chequeId', array('id' => 'idCheque', 'value' => $cheques->id)); ?>
    <?php echo $form->hiddenField($nuevoModel, 'colocacionAnteriorId', array('value' => $originalModel->id)); ?>
    <?php echo $form->hiddenField($nuevoModel, 'diasColocados',array('value' => 0 )); ?>
    <?php echo CHtml::hiddenField('detallesColocaciones', ''); ?>
    <?php echo CHtml::hiddenField('clearing', $originalModel->getClearing(),array("id"=>"Colocaciones_clearing")); ?>
    <?php echo CHtml::hiddenField('idClienteRecolocado', $idClienteRecolocado); ?>

    <?php echo $form->hiddenField($nuevoModel, 'montoTotal', array('value' => 0)); ?>

    <?php
    $this->beginWidget('zii.widgets.CPortlet', array(
        'id' => 'portletInversores',
        'title' => '',
    ));
    echo "<b>Inversores</b>";
    $this->endWidget("portletInversores");
    ?>

    <?php
    $clientes = new Clientes();
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'clientes-grid',
        'dataProvider' => $clientes->searchInversoresParaColocacion(),
        'filter' => $clientes,
        // 'selectionChanged' => 'HabilitarColocacion',
        'columns' => array(
            'razonSocial',
            array(
                'name' => 'saldo',
                'header' => 'Saldo',
                'value' => 'Utilities::MoneyFormat($data->saldo)',
            ),
            'tasaInversor',
            array(
                'name' => 'operadorId',
                'header' => 'Operador',
                'value' => '$data->operador->apynom',
            ),
        ),
        'htmlOptions' => array(
            'class' => 'grid-view mgrid_table',
        ),
    ));
    ?>


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
        <br>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialog-form',
            'options' => array(
                'title' => 'Colocar inversor',
                'autoOpen' => false,
                'modal' => 'true',
                'buttons' => array(
                    'Asignar colocacion' => "js:Create",
                    'Cancelar' => "js:Close",
                ),
            ),
            'htmlOptions' => array('style' => 'font-size: 62.5%;height:476.133px'),
        ));
        ?>
        <div title="Create new user" style="font-size: 120%;">
        <p class="validateTips"><b>Todos los campos son requeridos.</b></p>

        <fieldset>
            <label for="inversor" id="nombreinversor"></label>
            <input type="hidden" name="inversor" id="inversor" class="text ui-widget-content ui-corner-all" />
            <input type="hidden" name="idCliente" id="idCliente" class="text ui-widget-content ui-corner-all" />
            <input type="hidden" name="clearing_viejo" id="clearing_viejo" value="<?php echo $originalModel->getClearing()?>" class="text ui-widget-content ui-corner-all" />
            Monto Disponible:
            <input type="text" name="montodisponible" id="montodisponible" value="" class="text ui-widget-content ui-corner-all" readonly="readonly"/>
            <label for="clearing">Clearing:</label>
            <input type="text" name="clearing" id="clearing" value="<?php echo $originalModel->getClearing()?>" onblur="calcularDiasColocados()" class="text ui-widget-content ui-corner-all" />
            <label for="diasColocados">Dias colocados:</label>
            <input type="text" name="diasColocados" id="diasColocados" value="<?php echo $originalModel->diasColocados?>" class="text ui-widget-content ui-corner-all" readonly="readonly" />
            <label for="monto">Monto a colocar</label>
            <input type="text" name="monto" id="monto" value="" class="text ui-widget-content ui-corner-all" />
            <label for="tasa">Tasa</label>
            <input type="text" name="tasa" id="tasa" value="" class="text ui-widget-content ui-corner-all" />
        </fieldset>
    </div>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
    <div id="cheques-colocados" class="ui-widget">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => '',
        ));
        echo "<b>Colocaciones</b>";
        $this->endWidget("dialog-form");
        ?>
        <?php echo $detalleColocaciones; ?>
    </div>

    <div class="row">
        <?php echo CHtml::label('Monto por colocar', 'label1'); ?>
        <?php echo CHtml::textField('montoPorColocar', 0, array('id' => 'montoPorColocar', 'size' => 15, 'maxlength' => 15, 'readonly' => 'readonly')); ?>
        <?php //echo $form->error($model,'montoTotal');  ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($nuevoModel->isNewRecord ? 'Cerrar colocacion' : 'Modificar colocacion', array('id' => 'submitBoton', 'onclick' => 'CrearDetallesColocaciones()')); ?>
        <?php $this->endWidget("colocaciones-form"); ?>
        <?php echo CHtml::Button('Cancelar', array('submit' => CHttpRequest::getUrlReferrer())); ?>
    </div>



</div><!-- form -->