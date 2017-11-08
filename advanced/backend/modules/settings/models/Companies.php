<?php

namespace backend\modules\settings\models;

use Yii;

/**
 * This is the model class for table "companies".
 *
 * @property integer $company_id
 * @property string $company_name
 * @property string $company_email
 * @property string $company_address
 * @property string $company_start_date
 * @property string $company_created_date
 * @property string $company_status
 *
 * @property Branches[] $branches
 * @property Departments[] $departments
 */
class Companies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'companies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_start_date'], 'required'],
            [['company_start_date', 'company_created_date'], 'safe'],

            //限制日期的输入大小；
            ['company_created_date', 'checkDate'],  // checkDate 是一个函数，自己写‘

            [['company_status'], 'string'],
            [['company_name', 'company_email', 'company_address'], 'string', 'max' => 100],
        ];
    }


    /**
     * company_start_date 的验证函数
     * @param $attribute
     * @param $params
     */
    public function checkDate($attribute, $params){
        $tody = date('Y-m-d');
        $selectedDate = date($this->company_start_date);
        if($selectedDate > $tody){
            $this->addError($attribute, 'Company Start Date Must be smaller ……');
        }
    }





    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company_id' => 'Company ID',
            'company_name' => 'Company Name',
            'company_email' => 'Company Email',
            'company_address' => 'Company Address',
            'company_start_date' => 'Company Start Date',
            'company_created_date' => 'Company Created Date',
            'company_status' => 'Company Status',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branches::className(), ['companies_company_id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Departments::className(), ['companies_company_id' => 'company_id']);
    }
}
