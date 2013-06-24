<?php
 
// this file must be stored in:
// protected/components/WebUser.php
 
class WebUser extends CWebUser {
 
  public function getModel()
    {
        return Yii::app()->getSession()->get('model');
    }
 
    public function login($identity, $duration)
    {
        parent::login($identity, $duration);
        Yii::app()->getSession()->add('model', $identity->getModel());
    }
 
    public function logout($destroySession= true)
    {
        // I always remove the session variable model.
        Yii::app()->getSession()->remove('model');
   }   
}

?>