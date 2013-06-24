<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('clientes-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<script>

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

    function HabilitarRecolocacion(){
        if($.fn.yiiGridView.getSelection('cheques-grid')!=""){
            $("#btnRecolocacion").removeAttr('disabled');
            $("#idCheque").val($.fn.yiiGridView.getSelection('cheques-grid'));
        }
        else{
            $("#btnRecolocacion").attr('disabled','disabled');
            $("#idCheque").val('');
        }

    }

    function MostrarColocaciones(id){
        //si hay alguno seleccionado
        if($.fn.yiiGridView.getSelection(id)!=''){
            $.ajax({
                type: 'POST',
                url: "<?php echo CController::createUrl('cheques/chequesColocadosEnCliente') ?>",
                data:{'id':$.fn.yiiGridView.getSelection(id)},
                dataType: 'Text',
                success:function(data){
                    //var datos=data.split(";");
                    $('#colocacionesInversor').css("display", "block");
                    $('#colocacionesInversor').html(data);
                    $("#idCliente").val($.fn.yiiGridView.getSelection(id));
                    //$("#montoPorColocar").val(datos[1]);
                    //Limpiar(); //borro la tabla y selecciones que haya
                }
            });
        }
        else {
            $("#idCliente").val($.fn.yiiGridView.getSelection(id));
            $('#colocacionesInversor').hide();
        }
    }

</script>
<div class="form">

    <?php
    $this->beginWidget('zii.widgets.CPortlet', array(
        'id' => 'portletInversores',
        'title' => '',
    ));
    echo "<b>Inversores</b>";
    $this->endWidget("portletInversores");
    ?>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'cheques-form',
        'enableAjaxValidation' => false,
        'method' => 'post',
        'action' => Yii::app()->createUrl("/colocaciones/editarColocacion")
            ));
    ?>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'clientes-grid',
        'dataProvider' => $clientes->searchInversoresParaColocacion(),
        'filter' => $clientes,
        'selectionChanged' => 'MostrarColocaciones',
        'columns' => array(
            array(
                'header' => 'Inversor seleccionado',
                'class' => 'CCheckBoxColumn',
            ),
            'razonSocial',
            array(
                'name' => 'saldo',
                'header' => 'Saldo Cta Cte',
                'value' => 'Utilities::MoneyFormat($data->saldo)',
            ),
            array(
                'name' => 'saldo',
                'header' => 'Saldo en Colocaciones',
                'value' => 'Utilities::MoneyFormat($data->saldoColocaciones)',
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

    <div id="colocacionesInversor" style="display:none">
        <?php
        $dataProvider = $cheques->searchChequesByEstado(Cheques::TYPE_EN_CARTERA_COLOCADO); //tipo de cheque en cartera colocado
        $dataProvider->setPagination(false);
        $this->renderPartial('/cheques/chequesColocadosPorInversor', array(
            'dataProvider' => $dataProvider,'idCliente'=>0
        ));
        ?>

    </div>
    <?php echo CHtml::hiddenField('idCheque', '', array('id' => 'idCheque')) ?>
<?php echo CHtml::hiddenField('idCliente', '', array('id' => 'idCliente')) ?>
<?php echo CHtml::submitButton('Reemplazar', array('id' => 'btnRecolocacion', 'disabled' => 'disabled')); ?>
<?php $this->endWidget("cheques-form"); ?>
</div><!-- form -->