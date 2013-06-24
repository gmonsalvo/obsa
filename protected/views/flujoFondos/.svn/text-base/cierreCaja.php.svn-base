<script type="text/javascript">
    var diferenciaPermitidaPesos = "<?php echo $cuentaPesos->diferenciaPermitida?>";
    var diferenciaPermitidaDolares = "<?php echo $cuentaDolares->diferenciaPermitida?>";
    function calcular(moneda)
    {
        if(moneda=="Dolares"){
            var val06=0;
            var val08=0;
            var val09=0;
            var val10=0;
        } else {
            var val06=validarNumero('#txt'+moneda+'2') * 2;
            var val08=validarNumero('#txt'+moneda+'050') * 0.50;
            var val09=validarNumero('#txt'+moneda+'025') * 0.25;
            var val10=validarNumero('#txt'+moneda+'010') * 0.10;
        }
        var val01=validarNumero('#txt'+moneda+'100') * 100;
        var val02=validarNumero('#txt'+moneda+'50') * 50;
        var val03=validarNumero('#txt'+moneda+'20') * 20;
        var val04=validarNumero('#txt'+moneda+'10') * 10;
        var val05=validarNumero('#txt'+moneda+'5') * 5;
        var val07=validarNumero('#txt'+moneda+'1') * 1;
        if (isNaN(val01)){
            val01=0;
        }
        if (isNaN(val02)){
            val02=0;
        }
        if (isNaN(val03)){
            val03=0;
        }
        if (isNaN(val04)){
            val04=0;
        }
        if (isNaN(val05)){
            val05=0;
        }
        if (isNaN(val06)){
            val06=0;
        }
        if (isNaN(val07)){
            val07=0;
        }
        if (isNaN(val08)){
            val08=0;
        }
        if (isNaN(val09)){
            val09=0;
        }
        if (isNaN(val10)){
            val10=0;
        }
        $("#total"+moneda).val(val01+val02+val03+val04+val05+val06+val07+val08+val09+val10);
    }

    function validarNumero(id)
    {
        if(!(isNaN($(id).val())))
        {
            $(id).css('border-color','#808080');
            return parseFloat($(id).val());
        }
        else if($(id).val()=="")
        {
            $(id).css('border-color','#808080');
            return 0;
        }
        else
        {
            $(id).css('border-color','#f00');
            return 0;
        }
    }

    function validate()
    {
        if($("#totalPesos").val()=="")
        {
            alert("Debe debe realizar el control de efectivo antes de realizar el cierre");
            return false;
        }
        if(parseFloat(Unformat("$ "+$("#diferenciaPesos").val()))>parseFloat(diferenciaPermitidaPesos))
        {
            alert("La diferencia en pesos no puede superar el margen permitido de "+ diferenciaPermitidaPesos+" pesos");
            return false;
        }

//        if(parseFloat($("#diferenciaDolares").val())>parseFloat(diferenciaPermitidaDolares))
//        {
//            alert("La diferencia en dolares no puede superar el margen permitido de " + diferenciaPermitidaDolares + "dolares");
//            return false;
//        }
        return true;
    }

    function Unformat(nStr)
    {
        nStr += '';
        x = nStr.split('$ ');
        y = x[1];
        //return y;
        //alert(y);
        y = y.split('.');
        var z='';
        for(var i=0;i<y.length;i++)
            z=z+y[i];
        x = z.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        return x1 + x2;

    }
</script>


<div class="form">
    <h2><b>Arqueo de Caja de Operaciones</b></h2>
    <?php
    $this->beginWidget('zii.widgets.CPortlet', array('title' => '',));
    echo "<b>Control de Efectivo en Pesos</b>";
    $this->endWidget();
    ?>
    <div id="sumaPesos">
        <b>Billetes</b>
        <table>
            <tr>
                <td width="10%">$ 100</td><td width="40%"><input type="text" name="txt100" id="txtPesos100" onBlur="calcular('Pesos')"></td>
                <td width="10%">$  50</td><td width="40%"><input type="text" name="txt50" id="txtPesos50" onBlur="calcular('Pesos')"></td>
            </tr>
            <tr>
                <td width="10%">$  20</td><td width="40%"><input type="text" name="txt20" id="txtPesos20" onBlur="calcular('Pesos')"></td>
                <td width="10%">$  10</td><td width="40%"><input type="text" name="txt10" id="txtPesos10" onBlur="calcular('Pesos')"></td>
            </tr>
            <tr>
                <td width="10%">$  5</td><td width="40%"><input type="text" name="txt5" id="txtPesos5" onBlur="calcular('Pesos')"></td>
                <td width="10%">$  2</td><td width="40%"><input type="text" name="txt2" id="txtPesos2" onBlur="calcular('Pesos')"></td>
            </tr>
        </table>
        <b>Monedas</b>
        <table>
            <tr>
                <td width="10%">$ 1</td><td width="40%"><input type="text" name="txt1" id="txtPesos1" onBlur="calcular('Pesos')"></td>
                <td width="10%">$ 0,50</td><td width="40%"><input type="text" name="txt050" id="txtPesos050" onBlur="calcular('Pesos')"></td>
            </tr>
            <tr>
                <td width="10%">$ 0,25</td><td width="40%"><input type="text" name="txt025" id="txtPesos025" onBlur="calcular('Pesos')"></td>
                <td width="10%">$ 0,10</td><td width="40%"><input type="text" name="txt010" id="txtPesos010" onBlur="calcular('Pesos')"></td>
            </tr>
        </table>
    </div>

    <table>
        <tr>
            <td>
                <b>Total </b><input type="text" name="total" id="totalPesos" style="color:blue; font-weight:bold" readonly="readonly">
            </td>
            <td>
                <?php
                echo CHtml::ajaxButton('Calcular', CHtml::normalizeUrl(array('flujoFondos/calcular', 'render' => false)), array(
                    'type' => 'POST',
                    'data' => array(
                        'total' => 'js:$("#totalPesos").val()',
                        'moneda' => 'pesos',
                    ),
                    'dataType' => 'text',
                    'beforeSend' => 'js:function(){
						if($("#totalPesos").val()=="") {
							alert("El valor total no puede estar vacio");
							return false;
						}
						return true;
						}',
                    'success' => 'js:function(data){
						var diferencia=data;
						$("#diferenciaPesos").val(diferencia);
						}',
                ));
                ?>
            </td>
            <td>
                <b>Diferencia </b><input type="text" name="diferencia" id="diferenciaPesos" style="color:blue; font-weight:bold" readonly="readonly">
            </td>
        </tr>
    </table>
    <br><br>
    <!-- ocultamos la parte de dolares por ahora -->
    <div style="display:none">
    <?php
    $this->beginWidget('zii.widgets.CPortlet', array('title' => '',));
    echo "<b>Control de Efectivo en Dolares</b>";
    $this->endWidget();
    ?>
    <div id="sumaDolares">
        <b>Billetes</b>
        <table>
            <tr>
                <td width="10%">$ 100</td><td width="40%"><input type="text" name="txt100" id="txtDolares100" onBlur="calcular('Dolares')"></td>
                <td width="10%">$  50</td><td width="40%"><input type="text" name="txt50" id="txtDolares50" onBlur="calcular('Dolares')"></td>
            </tr>
            <tr>
                <td width="10%">$  20</td><td width="40%"><input type="text" name="txt20" id="txtDolares20" onBlur="calcular('Dolares')"></td>
                <td width="10%">$  10</td><td width="40%"><input type="text" name="txt10" id="txtDolares10" onBlur="calcular('Dolares')"></td>
            </tr>
            <tr>
                <td width="10%">$  5</td><td width="40%"><input type="text" name="txt5" id="txtDolares5" onBlur="calcular('Dolares')"></td>
                <td width="10%">$  1</td><td width="40%"><input type="text" name="txt1" id="txtDolares1" onBlur="calcular('Dolares')"></td>
            </tr>
        </table>
    </div>
    </div>

    <table style="display:none">
        <tr>
            <td>
                <b>Total </b><input type="text" name="total" id="totalDolares" style="color:blue; font-weight:bold" readonly="readonly">
            </td>
            <td>
                <?php
                echo CHtml::ajaxButton('Calcular', CHtml::normalizeUrl(array('flujoFondos/calcular', 'render' => false)), array(
                    'type' => 'POST',
                    'data' => array(
                        'total' => 'js:$("#totalDolares").val()',
                        'moneda' => 'dolares',
                    ),
                    'dataType' => 'text',
                    'beforeSend' => 'js:function(){
						if($("#totalDolares").val()=="") {
							alert("El valor total no puede estar vacio");
							return false;
						}
						return true;
						}',
                    'success' => 'js:function(data){
						var diferencia=data;
						$("#diferenciaDolares").val(diferencia);
						}',
                ));
                ?>
            </td>
            <td>
                <b>Diferencia </b><input type="text" name="diferencia" id="diferenciaDolares" style="color:blue; font-weight:bold" readonly="readonly">
            </td>
        </tr>
    </table>
</div>
<br><br>
<div>
    <?php
    $this->beginWidget('zii.widgets.CPortlet', array('title' => '',));
    echo "<b>Ordenes de Pago del dia</b>";
    $this->endWidget();
    ?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'ordenes-pago-grid',
        'dataProvider' => OrdenesPago::model()->searchByFecha(Date("Y-m-d")),
        'selectableRows' => 1,
        'filter' => OrdenesPago::model(),
        'columns' => array(
            array(
                'name' => 'id',
                'header' => 'Nro Orden',
                'value' => '$data->id',
            ),
            array(
                'name' => 'clienteId',
                'header' => 'Cliente',
                'value' => '$data->cliente->razonSocial',
            ),
            'fecha',
            array(
                'name' => 'monto',
                'header' => 'Monto',
                'value' => 'Utilities::MoneyFormat($data->monto)',
            ),
            'descripcion',
            array(
                'name' => 'estado',
                'header' => 'Estado',
                'value' => '$data->getTypeDescription($data->estado)',
            ),
        ),
    ));
    ?>
</div>
<br><br>
<div>
    <?php
    $this->beginWidget('zii.widgets.CPortlet', array('title' => '',));
    echo "<b>Ordenes de Ingreso del dia</b>";
    $this->endWidget();
    ?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'ordenes-pago-grid',
        'dataProvider' => OrdenIngreso::model()->searchByFecha(Date("Y-m-d")),
        'selectableRows' => 1,
        'filter' => OrdenIngreso::model(),
        'columns' => array(
            array(
                'name' => 'id',
                'header' => 'Nro Orden',
                'value' => '$data->id',
            ),
            array(
                'name' => 'clienteId',
                'header' => 'Cliente',
                'value' => '$data->cliente->razonSocial',
            ),
            'fecha',
            array(
                'name' => 'monto',
                'header' => 'Monto',
                'value' => 'Utilities::MoneyFormat($data->monto)',
            ),
            'descripcion',
            array(
                'name' => 'estado',
                'header' => 'Estado',
                'value' => '$data->getTypeDescription($data->estado)',
            ),
        ),
    ));
    ?>
</div>
<br><br>
<div>
    <?php
    $this->beginWidget('zii.widgets.CPortlet', array('title' => '',));
    echo "<b>Detalle de Cheques Comprados</b>";
    $this->endWidget();
    ?>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'cheques-grid',
        'dataProvider' => $cheques->searchToday(),
        'filter' => $cheques,
        'columns' => array(
            'numeroCheque',
            array(
                'name' => 'banco',
                'header' => 'Banco',
                'value' => '$data->banco->nombre',
            ),
            array(
                'name' => 'librador',
                'header' => 'Librador',
                'value' => '$data->librador->denominacion'
            ),
            array(
                'name' => 'montoNeto',
                'header' => 'Monto',
                'value' => 'Yii::app()->numberFormatter->format("#,##0.00", $data->montoNeto)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'name' => 'fechaPago',
                'header' => 'Fecha Vto',
                'value' => 'date("d/m/Y", strToTime($data->fechaPago))',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
        ),
    ));
    ?>
</div>
<div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'cierreCaja-form',
        'enableAjaxValidation' => false,
        'method' => 'post',
        'action' => Yii::app()->createUrl("/flujoFondos/cierreCaja"),
        'htmlOptions' => array('onSubmit' => 'return validate(this)')
            ));
    ?>
    <?php echo $form->errorSummary(new FlujoFondos);?>
    <?php echo CHtml::submitButton('Cierre del dia', array('id' => 'btnCierre','name'=>'btnCierre', "disabled"=>$deshabilitarSubmit)); ?>
    <?php $this->endWidget(); ?>
</div>
