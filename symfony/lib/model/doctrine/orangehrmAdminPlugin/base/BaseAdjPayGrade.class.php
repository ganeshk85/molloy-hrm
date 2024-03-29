<?php

/**
 * BaseAdjPayGrade
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $EmployeeSalary
 * @property Doctrine_Collection $EmployeeAdjSalary
 * 
 * @method integer             getId()                Returns the current record's "id" value
 * @method string              getName()              Returns the current record's "name" value
 * @method Doctrine_Collection getEmployeeSalary()    Returns the current record's "EmployeeSalary" collection
 * @method Doctrine_Collection getEmployeeAdjSalary() Returns the current record's "EmployeeAdjSalary" collection
 * @method AdjPayGrade         setId()                Sets the current record's "id" value
 * @method AdjPayGrade         setName()              Sets the current record's "name" value
 * @method AdjPayGrade         setEmployeeSalary()    Sets the current record's "EmployeeSalary" collection
 * @method AdjPayGrade         setEmployeeAdjSalary() Sets the current record's "EmployeeAdjSalary" collection
 * 
 * @package    orangehrm
 * @subpackage model\admin\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAdjPayGrade extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ohrm_adj_pay_grade');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 60, array(
             'type' => 'string',
             'length' => 60,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('EmployeeSalary', array(
             'local' => 'id',
             'foreign' => 'adjPayGradeId'));

        $this->hasMany('EmployeeAdjSalary', array(
             'local' => 'id',
             'foreign' => 'adjPayGradeId'));
    }
}