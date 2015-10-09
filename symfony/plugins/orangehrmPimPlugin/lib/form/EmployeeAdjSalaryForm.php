<?php

/*
  // OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
  // all the essential functionalities required for any enterprise.
  // Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com

  // OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
  // the GNU General Public License as published by the Free Software Foundation; either
  // version 2 of the License, or (at your option) any later version.

  // OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
  // without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
  // See the GNU General Public License for more details.

  // You should have received a copy of the GNU General Public License along with this program;
  // if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
  // Boston, MA  02110-1301, USA
 */

/**
 * Form class for employee salary detail
 */
class EmployeeAdjSalaryForm extends BaseForm {

    public $fullName;
    private $currencyService;
    public $havePayGrades = false;
    private $payGrades;    
    private $payPeriods;

    public function configure() {
         $this->salaryPermissions = $this->getOption('salaryPermissions');
         
        $empNumber = $this->getOption('empNumber');
        $employee = $this->getOption('employee');
        $this->fullName = $employee->getFullName();

        $this->payGrades = $this->_getPayGrades();        
        $this->payPeriods = $this->_getPayPeriods();

        $widgets = array('emp_number' => new sfWidgetFormInputHidden(array(), array('value' => $empNumber)));
        $validators = array('emp_number' => new sfValidatorString(array('required' => true)));

        if ($this->salaryPermissions->canRead()) {

            $salaryWidgets = $this->getSalaryWidgets();
            $salaryValidators = $this->getSalaryValidators();

            if (!($this->salaryPermissions->canUpdate() || $this->salaryPermissions->canCreate()) ) {
                foreach ($salaryWidgets as $widgetName => $widget) {
                    $widget->setAttribute('disabled', 'disabled');
                }
            }
            $widgets = array_merge($widgets, $salaryWidgets);
            $validators = array_merge($validators, $salaryValidators);
        }

        $this->setWidgets($widgets);
        $this->setValidators($validators);

        $this->widgetSchema->setNameFormat('salary[%s]');

        // set up your post validator method
        $this->validatorSchema->setPostValidator(
                new sfValidatorCallback(array(
                    'callback' => array($this, 'postValidate')
                ))
        );
    }

    /*
     * Tis fuction will return the widgets of the form
     */

    public function getSalaryWidgets() {
        $widgets = array();

        //creating widgets
        // Note: Widget names were kept from old non-symfony version
        $widgets['id'] = new sfWidgetFormInputHidden();        
        $widgets['basic_salary'] = new sfWidgetFormInputText();
        $widgets['adj_payperiod_code'] = new sfWidgetFormSelect(array('choices' => $this->payPeriods));        
        $widgets['year'] = new sfWidgetFormInputText();
        $widgets['term_id'] = new sfWidgetFormInputText();
        $widgets['credits_taught'] = new sfWidgetFormInputText();
        $widgets['reduced_credit'] = new sfWidgetFormInputText();
        $widgets['total_credits'] = new sfWidgetFormInputText();
        $widgets['hours'] = new sfWidgetFormInputText();
        $widgets['comments'] = new sfWidgetFormTextArea();                

        if (count($this->payGrades) > 0) {
            $this->havePayGrades = true;
            $widgets['sal_grd_code'] = new sfWidgetFormSelect(array('choices' => $this->payGrades));
        } else {
            $widgets['sal_grd_code'] = new sfWidgetFormInputHidden();
        }

        // Remove default options from list validated against
        //unset($this->payGrades['']);        
        unset($this->payPeriods['']);

        return $widgets;
    }

    /*
     * Tis fuction will return the form validators
     */

    public function getSalaryValidators() {

        $validators = array(
            'id' => new sfValidatorNumber(array('required' => false, 'min' => 0)),            
            'basic_salary' => new sfValidatorNumber(array('required' => true, 'trim' => true, 'min' => 0, 'max' => 999999999.99)),
            'adj_payperiod_code' => new sfValidatorChoice(array('required' => false, 'choices' => array_keys($this->payPeriods))),            
            'year' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'term_id' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'credits_taught' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'reduced_credit' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'total_credits' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'hours' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'comments' => new sfValidatorString(array('required' => false, 'max_length' => 255)),            
        );
        
        if ($this->havePayGrades) {
            $validator = array('sal_grd_code' => new sfValidatorChoice(array('required' => false, 'choices' => array_keys($this->payGrades))));
        } else {
            // We do not expect a value. Validate as an empty string
            $validator = array('sal_grd_code' => new sfValidatorString(array('required' => false, 'max_length' => 10)));
        }
        
        $validators = array_merge($validators, $validator);

        return $validators;
    }

    public function postValidate($validator, $values) {
        $service = new PayGradeService();

        $salaryGrade = $values['sal_grd_code'];

        $salary = $values['basic_salary'];

        if (!empty($salaryGrade)) {

            $salaryDetail = $service->getCurrencyByCurrencyIdAndPayGradeId($values['currency_id'], $salaryGrade);


            if (empty($salaryDetail)) {

                $message = sfContext::getInstance()->getI18N()->__('Invalid Salary Grade.');
                $error = new sfValidatorError($validator, $message);
                throw new sfValidatorErrorSchema($validator, array('' => $error));
            } else if ((!empty($salaryDetail->minSalary) && ($salary < $salaryDetail->minSalary)) ||
                    (!empty($salaryDetail->maxSalary) && ($salary > $salaryDetail->maxSalary))) {

                $message = sfContext::getInstance()->getI18N()->__('Salary should be within min and max');
                $error = new sfValidatorError($validator, $message);
                throw new sfValidatorErrorSchema($validator, array('basic_salary' => $error));
            }
        } else {
            $values['sal_grd_code'] = null;
        }

        // cleanup cmbPayPeriod
        $payPeriod = $values['adj_payperiod_code'];
        if ($payPeriod == '0' || $payPeriod = '') {
            $values['adj_payperiod_code'] = null;
        }

        // Convert salary to a string. Since database field is a string field.
        // Otherwise, it may be converted to a string using scientific notation when encrypting.
        //        
        // Remove trailing zeros - will always have decimal point, so 
        // only trailing decimals are removed.
        $formattedSalary = rtrim(sprintf("%.2F", $salary), '0');

        // Remove decimal point (if it is the last char).
        $formattedSalary = rtrim($formattedSalary, '.');

        $values['basic_salary'] = $formattedSalary;

        return $values;
    }

    /**
     * Get EmployeeAdjSalary object
     */
    public function getAdjSalary() {

        $id = $this->getValue('id');

        $empAdjSalary = false;

        if (!empty($id)) {
            $empAdjSalary = Doctrine::getTable('EmployeeAdjSalary')->find($id);
        }

        if ($empAdjSalary === false) {
            $empAdjSalary = new EmployeeAdjSalary();
        }

        $empAdjSalary->setEmpNumber($this->getValue('emp_number'));
        $empAdjSalary->setAdjPayGradeId($this->getValue('sal_grd_code'));        
        $empAdjSalary->setAdjPayPeriodId($this->getValue('adj_payperiod_code'));        
        $empAdjSalary->setCreditsTaught($this->getValue('credits_taught'));
        $empAdjSalary->setReducedCredit($this->getValue('reduced_credit'));
        $empAdjSalary->setTotalCredits($this->getValue('total_credits'));
        $empAdjSalary->setHours($this->getValue('hours'));
        //$empAdjSalary->setAmount($this->getValue('basic_salary'));
        $empAdjSalary->setNotes($this->getValue('comments'));
        

        return $empAdjSalary;
    }

    private function _getPayGrades() {
        $choices = array();

        $service = new PayGradeService();
        $payGrades = $service->getPayGradeList();

        if (count($payGrades) > 0) {
            $choices = array('' => '-- ' . __('Select') . ' --');

            foreach ($payGrades as $payGrade) {
                $choices[$payGrade->getId()] = $payGrade->getName();
            }
        }
        return $choices;
    }

    /**
     * Get Pay Periods as array.
     * 
     * @return Array (empty array if no pay periods defined).
     */
    private function _getPayPeriods() {
        $payPeriods = Doctrine::getTable('Payperiod')->findAll();

        foreach ($payPeriods as $payPeriod) {
            $choices[$payPeriod->getCode()] = $payPeriod->getName();
        }

        asort($choices);

        $choices = array('' => '-- ' . __('Select') . ' --') + $choices;

        return $choices;
    }

}

