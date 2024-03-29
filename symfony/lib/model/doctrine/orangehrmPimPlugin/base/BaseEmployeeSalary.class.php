<?php

/**
 * BaseEmployeeSalary
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $empNumber
 * @property integer $payGradeId
 * @property string $currencyCode
 * @property string $amount
 * @property string $payPeriodId
 * @property string $salaryName
 * @property string $notes
 * @property integer $credits_taught
 * @property intger $reduced_credit
 * @property integer $total_credits
 * @property intger $hours
 * @property CurrencyType $currencyType
 * @property Employee $employee
 * @property Payperiod $payperiod
 * @property EmpDirectdebit $directDebit
 * @property PayGrade $payGrade
 * @property AdjPayGrade $AdjPayGrade
 * 
 * @method integer        getId()             Returns the current record's "id" value
 * @method integer        getEmpNumber()      Returns the current record's "empNumber" value
 * @method integer        getPayGradeId()     Returns the current record's "payGradeId" value
 * @method string         getCurrencyCode()   Returns the current record's "currencyCode" value
 * @method string         getAmount()         Returns the current record's "amount" value
 * @method string         getPayPeriodId()    Returns the current record's "payPeriodId" value
 * @method string         getSalaryName()     Returns the current record's "salaryName" value
 * @method string         getNotes()          Returns the current record's "notes" value
 * @method integer        getCreditsTaught()  Returns the current record's "credits_taught" value
 * @method intger         getReducedCredit()  Returns the current record's "reduced_credit" value
 * @method integer        getTotalCredits()   Returns the current record's "total_credits" value
 * @method intger         getHours()          Returns the current record's "hours" value
 * @method CurrencyType   getCurrencyType()   Returns the current record's "currencyType" value
 * @method Employee       getEmployee()       Returns the current record's "employee" value
 * @method Payperiod      getPayperiod()      Returns the current record's "payperiod" value
 * @method EmpDirectdebit getDirectDebit()    Returns the current record's "directDebit" value
 * @method PayGrade       getPayGrade()       Returns the current record's "payGrade" value
 * @method AdjPayGrade    getAdjPayGrade()    Returns the current record's "AdjPayGrade" value
 * @method EmployeeSalary setId()             Sets the current record's "id" value
 * @method EmployeeSalary setEmpNumber()      Sets the current record's "empNumber" value
 * @method EmployeeSalary setPayGradeId()     Sets the current record's "payGradeId" value
 * @method EmployeeSalary setCurrencyCode()   Sets the current record's "currencyCode" value
 * @method EmployeeSalary setAmount()         Sets the current record's "amount" value
 * @method EmployeeSalary setPayPeriodId()    Sets the current record's "payPeriodId" value
 * @method EmployeeSalary setSalaryName()     Sets the current record's "salaryName" value
 * @method EmployeeSalary setNotes()          Sets the current record's "notes" value
 * @method EmployeeSalary setCreditsTaught()  Sets the current record's "credits_taught" value
 * @method EmployeeSalary setReducedCredit()  Sets the current record's "reduced_credit" value
 * @method EmployeeSalary setTotalCredits()   Sets the current record's "total_credits" value
 * @method EmployeeSalary setHours()          Sets the current record's "hours" value
 * @method EmployeeSalary setCurrencyType()   Sets the current record's "currencyType" value
 * @method EmployeeSalary setEmployee()       Sets the current record's "employee" value
 * @method EmployeeSalary setPayperiod()      Sets the current record's "payperiod" value
 * @method EmployeeSalary setDirectDebit()    Sets the current record's "directDebit" value
 * @method EmployeeSalary setPayGrade()       Sets the current record's "payGrade" value
 * @method EmployeeSalary setAdjPayGrade()    Sets the current record's "AdjPayGrade" value
 * 
 * @package    orangehrm
 * @subpackage model\pim\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmployeeSalary extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_emp_basicsalary');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('emp_number as empNumber', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('sal_grd_code as payGradeId', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('currency_id as currencyCode', 'string', 6, array(
             'type' => 'string',
             'notnull' => true,
             'default' => '',
             'length' => 6,
             ));
        $this->hasColumn('ebsal_basic_salary as amount', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('payperiod_code as payPeriodId', 'string', 13, array(
             'type' => 'string',
             'length' => 13,
             ));
        $this->hasColumn('salary_component as salaryName', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('comments as notes', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('credits_taught', 'integer', 4, array(
             'type' => 'integer',
             'default' => '0',
             'length' => 4,
             ));
        $this->hasColumn('reduced_credit', 'intger', 4, array(
             'type' => 'intger',
             'default' => '0',
             'length' => 4,
             ));
        $this->hasColumn('total_credits', 'integer', 4, array(
             'type' => 'integer',
             'default' => '0',
             'length' => 4,
             ));
        $this->hasColumn('hours', 'intger', 4, array(
             'type' => 'intger',
             'default' => '0',
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('CurrencyType as currencyType', array(
             'local' => 'currencyCode',
             'foreign' => 'currency_id'));

        $this->hasOne('Employee as employee', array(
             'local' => 'empNumber',
             'foreign' => 'empNumber'));

        $this->hasOne('Payperiod as payperiod', array(
             'local' => 'payPeriodId',
             'foreign' => 'payperiod_code'));

        $this->hasOne('EmpDirectdebit as directDebit', array(
             'local' => 'id',
             'foreign' => 'salary_id'));

        $this->hasOne('PayGrade as payGrade', array(
             'local' => 'payGradeId',
             'foreign' => 'id'));

        $this->hasOne('AdjPayGrade', array(
             'local' => 'adjPayGradeId',
             'foreign' => 'id'));
    }
}