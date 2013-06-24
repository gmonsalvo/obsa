<?php
$this->breadcrumbs = array(
    'Pesificaciones' => array('admin'),
    'Nueva',
);

$this->menu = array(
    array('label' => 'Listar Pesificaciones', 'url' => array('admin')),
);
?>

<h1>Pesificaciones</h1>
<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => '',
));
echo "<b>Datos de la Pesificacion</b><br>";
echo "Fecha: ".Utilities::ViewDateFormat($model->fecha)."<br>";
echo "Pesificador: ".$model->pesificador->denominacion."<br>";
echo "Monto de la Pesificacion: ".Utilities::MoneyFormat($model->getMontototal());
$this->endWidget();
?>
<div id="detallePesificacion">
<?php echo $render; ?>
</div>
<?php
       echo CHtml::ajaxButton(
            'Crear Detalle',
            array('detallePesificaciones/create'),
            array('data'=>array('pesificacionId'=>$model->id, 'asDialog'=>1),
            	  'success' => 'js:function(response){
            	  		$("#form_detalle").empty().html(response);
						$( "#dialog-form" ).dialog("open");
            	  }'
            	),
            array('update'=>'#form_detalle')
        );
?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'pesificaciones-form',
    'enableAjaxValidation'=>false,
    'method' => 'POST',
    'action' => Yii::app()->createUrl("/pesificaciones/acreditar")
)); ?>
<?php echo CHtml::hiddenField("pesificacionId",$model->id); ?>
<?php echo CHtml::submitButton('Acreditar Cambios'); ?>
<?php $this->endWidget(); ?>
<?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialog-form',
            'options' => array(
                'title' => 'Agregar Concepto',
                'autoOpen' => false,
                'modal' => 'true',
            ),
            'htmlOptions' => array('style' => 'font-size: 62.5%;height:476.133px'),
        ));
        ?>
        <div title="Create new user" style="font-size: 120%;">
        <p class="validateTips"><b>Todos los campos son requeridos.</b></p>

        <fieldset>
        	<div id="form_detalle">
                <!-- solo se pone esto para inicializar variables javascript -->
        		<?php echo $this->renderPartial('/detallePesificaciones/_form', array( 'model' => new DetallePesificaciones(), 'pesificacionId'=>$_GET["pesificacionId"]), true);
        		?>
                <?php echo $this->renderPartial('/detallePesificaciones/_formUpdate', array( 'model' => new DetallePesificaciones(), 'pesificacionId'=>$_GET["pesificacionId"]), true);
                ?>
        		</div>
        </fieldset>
    </div>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>