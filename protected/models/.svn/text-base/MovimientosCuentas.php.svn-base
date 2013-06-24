<?php


class MovimientosCuentas extends CFormModel
{
   
	public $cuentaOrigen;
    public $descripcion;
	public $monto;
    public $cuentaDestino;

	  public function rules()
    {
        return array(
            array('cuentaOrigen, cuentaDestino,monto,descripcion', 'required'),
			array('monto', 'compare','operator'=>'>=','compareValue'=>0  ),
			array('monto','numerical')
			
        );
    }
	
	}

?>