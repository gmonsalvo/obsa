<?php
$this->breadcrumbs=array(
	'Cheques'=>array('adminCheques'),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listado de Cheques', 'url'=>array('adminCheques')),
);
?>

<h2><b>Alta de Cheque Rechazado</b></h2>
<?php
	echo $this->renderPartial('viewCheck', array('model'=>$model));
	if ($model->montoGastos > 0)
	{
		echo "<br><b>EL CHEQUE YA FUE DADO DE ALTA</b>";
	}
	else
	{
		echo $this->renderPartial('_formUpdateAlta', array('model'=>$model));
	}
?>