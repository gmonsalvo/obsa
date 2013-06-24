<?php

/**
 * This is the model class for table "recibosDetalle".
 *
 * The followings are the available columns in table 'recibosDetalle':
 * @property integer $id
 * @property integer $reciboId
 * @property integer $tipoFondoId
 * @property string $monto
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property RecibosOrdenPago $recibo
 */
class RecibosDetalle extends CustomCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RecibosDetalle the static model class
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
		return 'recibosDetalle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('reciboId, tipoFondoId, monto, userStamp, timeStamp', 'required'),
			array('reciboId, tipoFondoId', 'numerical', 'integerOnly'=>true),
			array('monto', 'length', 'max'=>15),
			array('userStamp', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, reciboId, tipoFondoId, monto, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
			'recibo' => array(self::BELONGS_TO, 'RecibosOrdenPago', 'reciboId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'reciboId' => 'Recibo',
			'tipoFondoId' => 'Tipo Fondo',
			'monto' => 'Monto',
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
		$criteria->compare('reciboId',$this->reciboId);
		$criteria->compare('tipoFondoId',$this->tipoFondoId);
		$criteria->compare('monto',$this->monto,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}