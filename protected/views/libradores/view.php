<?php
$this->breadcrumbs=array(
	'Libradores'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Libradores', 'url'=>array('admin')),
	array('label'=>'Nuevo Librador', 'url'=>array('create')),
	array('label'=>'Modificar Librador', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Librador', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Esta seguro que desea eliminar este item?')),
	array('</br>'),
	array('</br>'),
	array('label'=>'Nuevo Socio', 'url'=>array('socios/create', 'libradorId'=>$model->id, 'denominacion'=>$model->denominacion)),
);
?>

<h1>Detalle del Librador Nro: <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'documento',
		'denominacion',
		'direccion',
		array(
		      'label'=>'Localidad',
		      'value'=>$model->localidad->descripcion,
		),
		array(
			'label'=>'Provincia',
			'value'=>$model->provincia->descripcion,
		),
		array(
			'label'=>'Actividad',
			'value'=>$model->actividad->descripcion,
		),
		'montoMaximo',
	),
)); ?>

<h1>Listado de Socios</h1>
<?php
$config = array();
$dataProvider = new CArrayDataProvider($rawData=$model->socios, $config);

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider
    ,'columns'=>array(
        array(
			'name'=>'id',
			'header'=>'Id',
		),
		array(
			'name'=>'documento',
			'header'=>'Documento',
		),
		array(
			'name'=>'apellidoNombre',
			'header'=>'Apellido y Nombre',
		),
        array(
            'class'=>'CButtonColumn'
            , 'viewButtonUrl'=>'Yii::app()->createUrl("/socios/view", array("id"=>$data["id"]))'
            , 'updateButtonUrl'=>'Yii::app()->createUrl("/socios/update", array("id"=>$data["id"]))'
            , 'deleteButtonUrl'=>'Yii::app()->createUrl("/socios/delete", array("id"=>$data["id"]))'
        ),
    ),
));