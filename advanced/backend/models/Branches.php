<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "branches".
 *
 * @property integer $branch_id
 * @property integer $companies_company_id
 * @property string $branch_name
 * @property string $branch_address
 * @property string $branch_created_date
 * @property string $branch_status
 *
 * @property Companies $companiesCompany
 * @property Departments[] $departments
 */
class Branches extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'branches';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companies_company_id', 'branch_name', 'branch_created_date'], 'required'],
            [['companies_company_id'], 'integer'],
            [['branch_created_date'], 'safe'],
            [['branch_status'], 'string'],
            [['branch_name'], 'unique'],      // branch 处ajax 验证要用的
            ['branch_status', 'required', 'when'=>function($model){         //检测，当 branch_address 不为空的时候，可以选择 branche_status
                return (!empty($model->branch_address)) ? true : false;
                //  whenClient, 是一个 JavaScript 函数，其返回值决定 本条验证规则是否发挥作用，返回false,不发挥作用，反之，发挥作用
            }, 'whenClient'=>"function(){    
                if( $('#branch_address').val() === undefined ){     
                    false;
                } else {
                    true;
                }
            }"],
            [['branch_name', 'branch_address'], 'string', 'max' => 100],
            [['companies_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companies::className(), 'targetAttribute' => ['companies_company_id' => 'company_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'branch_id' => 'Branch ID',
            'companies_company_id' => 'Companies Company Name',
            'branch_name' => 'Branch Name',
            'branch_address' => 'Branch Address',
            'branch_created_date' => 'Branch Created Date',
            'branch_status' => 'Branch Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompaniesCompany()
    {
        return $this->hasOne(Companies::className(), ['company_id' => 'companies_company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Departments::className(), ['branches_branch_id' => 'branch_id']);
    }
}
