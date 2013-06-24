<?php

/**
 * This is the model class for table "operadores".
 *
 * The followings are the available columns in table 'operadores':
 * @property integer $id
 * @property string $apynom
 * @property string $direccion
 * @property string $celular
 * @property string $fijo
 * @property string $documento
 * @property string $email
 * @property string $comision
 * @property integer $usuarioId
 * @property integer $clienteId
 * @property integer $sucursalId
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property Clientes[] $clientes
 * @property Sucursales $sucursal
 */
class Operadores extends CustomCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Operadores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'operadores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('celular, documento, email, usuarioId, sucursalId, userStamp, timeStamp', 'required'),
			array('usuarioId, sucursalId, clienteId', 'numerical', 'integerOnly'=>true),
			array('apynom, direccion, email', 'length', 'max'=>100),
			array('celular, fijo', 'length', 'max'=>45),
			array('documento', 'length', 'max'=>11),
			array('comision', 'length', 'max'=>5),
			array('userStamp', 'length', 'max'=>50),
                        array('apynom','unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, apynom, direccion, celular, fijo, documento, email, comision', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'clientes' => array(self::HAS_ONE, 'Clientes', 'clienteId'),
			'usuario' => array(self::HAS_ONE, 'User', 'usuarioId'),
			'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'apynom' => 'Apellido y Nombre',
			'direccion' => 'Direccion',
			'celular' => 'Celular',
			'fijo' => 'Fijo',
			'documento' => 'DU/CUIT/CUIL',
			'email' => 'Email',
			'comision' => 'Comision',
			'usuarioId' => 'Usuario',
                        'clienteId' => 'Cliente',
			'sucursalId' => 'Sucursal',
			'userStamp' => 'User Stamp',
			'timeStamp' => 'Time Stamp',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('apynom',$this->apynom,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('celular',$this->celular,true);
		$criteria->compare('fijo',$this->fijo,true);
		$criteria->compare('documento',$this->documento,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('comision',$this->comision,true);
		$criteria->compare('usuarioId',$this->usuarioId);
		$criteria->compare('sucursalId',$this->sucursalId);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getUser()
	{
		return Yii::app()->user->model->username;
	}

	public function getComisionesPendientes(){
		return ComisionesOperadores::model()->findAll('operadorId=:operadorId AND estado=:estado', array(':operadorId'=>$this->id,':estado'=>ComisionesOperadores::ESTADO_PENDIENTE));
	}
	
}