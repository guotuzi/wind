<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "companies".
 *
 * @property integer $company_id
 * @property string $company_name
 * @property string $company_email
 * @property string $company_address
 * @property string $company_created_date
 * @property string $company_status
 *
 * @property Branches[] $branches
 * @property Departments[] $departments
 */
class Companies extends \yii\db\ActiveRecord
{
    public $file;   // 添加 logo 图片的文件属性

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
            [['company_created_date'], 'safe'],
            [['company_status'], 'string'],
            [['company_name', 'company_email', 'company_address', 'logo'], 'string', 'max' => 100],
            [['file'], 'image', 'minHeight'=> '1024', 'minWidth'=> '1024'],    //验证，上传图片的大小
        ];
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
            'file' => 'Logo',
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
