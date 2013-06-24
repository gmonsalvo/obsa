<?php

/**
 * This is the model class for table "conceptos".
 *
 * The followings are the available columns in table 'conceptos':
 * @property integer $id
 * @property string $nombre
 * @property integer $tipoConcepto
 * @property integer $sucursalId
 *
 * The followings are the available model relations:
 * @property FlujoFondos[] $flujoFondoses
 */
class Conceptos extends CustomCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Conceptos the static model class
	 */
   	const TYPE_ACREEDOR=0;
	const TYPE_DEUDOR=1;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'conceptos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, tipoConcepto, sucursalId, userStamp, timeStamp', 'required'),
			array('tipoConcepto, sucursalId', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, tipoConcepto,sucursalId', 'safe', 'on'=>'search'),
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
			'flujoFondoses' => array(self::HAS_MANY, 'FlujoFondos', 'conceptoId'),
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
			'nombre' => 'Nombre',
			'tipoConcepto' => 'Tipo Concepto',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('tipoConcepto',$this->tipoConcepto);
		$criteria->compare('sucursalId',$this->sucursalId);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function getTypeOptions()
	{
		return array(
			self::TYPE_ACREEDOR=>'Acreedor',
			self::TYPE_DEUDOR=>'Deudor',
		);
	}
	
	public function getTypeDescription()
	{
		$options = array();
		$options = $this->getTypeOptions();
		return $options[$this->tipoConcepto];
		
	}
}