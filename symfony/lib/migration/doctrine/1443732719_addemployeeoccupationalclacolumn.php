<?php

class Addemployeeoccupationalclacolumn extends Doctrine_Migration_Base
{
  public function up()
  {
	  $this->addColumn('hs_hr_employee', 'emp_occupational_classification', 'string', array('length' => '250'));
  }

  public function down()
  {
	  $this->removeColumn('hs_hr_employee', 'emp_occupational_classification');
  }
}
