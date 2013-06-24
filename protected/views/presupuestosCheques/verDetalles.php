<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'presupuestos-cheques-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'numeroCheque',
            'header' => 'Nro Cheque',
            'value' => '$data->numeroCheque',
        ),
        array(
            'name' => 'fechaPago',
            'header' => 'Vencimiento',
            'value' => '$data->fechaPago',
        ),
        array(
            'name' => 'libradorId',
            'header' => 'Librador',
            'value' => '$data->librador->denominacion',
        ),
        array(
            'name' => 'montoOrigen',
            'header' => 'Monto Nominal',
            'value' => 'Utilities::MoneyFormat($data->montoOrigen)',
        ),
    ),
));
?>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'presupuesto-operaciones-cheques-form',
        'enableAjaxValidation' => false,
        'action' => CController::createUrl('presupuestoOperacionesCheques/crearOperacion'),
            ));
    ?>
        <?php
        echo CHtml::hiddenField('id', '');
        ?>
    <div class="row buttons">
<?php echo CHtml::submitButton("Crear Operacion",array("name"=>"botonSubmit","id"=>"crear")); ?>
<?php echo CHtml::submitButton("Cancelar Presupuesto",array("name"=>"botonSubmit","id"=>"cancelar")); ?>        
    </div>
<?php $this->endWidget(); ?>

</div><!-- form -->
