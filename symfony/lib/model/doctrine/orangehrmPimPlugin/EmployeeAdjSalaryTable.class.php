<?php

/**
 * EmployeeAdjSalaryTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class EmployeeAdjSalaryTable extends PluginEmployeeAdjSalaryTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object EmployeeAdjSalaryTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('EmployeeAdjSalary');
    }
}