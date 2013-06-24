<?php

/**
 * This is the model class for table "socios".
 *
 * The followings are the available columns in table 'socios':
 * @property integer $id
 * @property integer $libradorId
 * @property string $documento
 * @property string $apellidoNombre
 * @property integer $sucursalId
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property Sucursales $sucursal
 * @property Libradores $librador
 */
class Socios extends CustomCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Socios the static model class
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
		return 'socios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('documento, apellidoNombre, sucursalId, userStamp, timeStamp', 'required'),
			array('libradorId, sucursalId', 'numerical', 'integerOnly'=>true),
			array('documento', 'length', 'max'=>11),
			array('apellidoNombre', 'length', 'max'=>100),
			array('userStamp', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, libradorId, documento, apellidoNombre', 'safe', 'on'=>'search'),
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
			'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
			'librador' => array(self::BELONGS_TO, 'Libradores', 'libradorId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'libradorId' => 'Librador',
			'documento' => 'Documento',
			'apellidoNombre' => 'Apellido Nombre',
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
		$criteria->compare('libradorId',$this->libradorId);
		$criteria->compare('documento',$this->documento,true);
		$criteria->compare('apellidoNombre',$this->apellidoNombre,true);
		$criteria->compare('sucursalId',$this->sucursalId);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}