<?php
/* @var $this PesificacionesController */
/* @var $model Pesificaciones */
?>
<script>
    function HabilitarBoton()
    {
        if($.fn.yiiGridView.getSelection("pesificaciones-grid")!=""){
            $("#botonSubmit").removeAttr("disabled");
            $("#pesificacionId").val($.fn.yiiGridView.getSelection("pesificaciones-grid"));
        }else{
            $("#botonSubmit").attr("disabled","disabled");
            $("#pesificacionId").val("");
        }
    }
</script>
<?php
$this->breadcrumbs = array(
    'Pesificaciones' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'Nueva Pesificacion', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('pesificaciones-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Listado de Pesificaciones</h1>

<p>
    Haga click en alguna de las filas para ver los detalles de la pesificacion
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'pesificaciones-grid',
    'dataProvider' => $model->searchPesificacionesSinCompletar(),
    'filter' => $model,
    'selectionChanged' => 'HabilitarBoton',
    'selectableRows' => 1,
    'columns' => array(
        array(
            'header' => 'Cheques seleccionados',
            'class' => 'CCheckBoxColumn',
        ),
        array(
            'name' => 'fecha',
            'header' => 'Fecha',
            'value' => 'Utilities::ViewDateFormat($data->fecha)'
        ),
        array(
            'name' => 'montototal',
            'header' => 'Monto Total',
            'value' => 'Utilities::MoneyFormat($data->montototal)',
        ),
        array(
            'name' => 'montoAcreditar',
            'header' => 'Monto a Acreditar',
            'value' => 'Utilities::MoneyFormat($data->montoAcreditar)',
        ),
        array(
            'name' => 'montoGastos',
            'header' => 'Monto Gastos',
            'value' => 'Utilities::MoneyFormat($data->montoGastos)',
        ),
        array(
            'name' => 'pesificadorId',
            'header' => 'Pesificador',
            'value' => '$data->pesificador->denominacion',
        ),
    ),
));
?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'pesificaciones-form',
        'enableAjaxValidation' => false,
        'method' => 'GET',
        'action' => Yii::app()->createUrl("/pesificaciones/acreditacionPesificacion")
            ));
    ?>
    	<div class="row buttons">
                <?php echo CHtml::hiddenField("pesificacionId", "", array("id"=>"pesificacionId"));?>
		<?php echo CHtml::submitButton("Detalle",array("name"=>"botonSubmit","id"=>"botonSubmit","disabled"=>"disabled")); ?>
	</div>

<?php $this->endWidget('pesificaciones-form'); ?>

