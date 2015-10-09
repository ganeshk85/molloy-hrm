<?php

class Addemployeeprevlastnamecolumn extends Doctrine_Migration_Base
{
  public function up()
  {
	  $this->addColumn('hs_hr_employee', 'emp_prev_lastname', 'string', array('length' => '100'));
  }

  public function down()
  {
	  $this->removeColumn('hs_hr_employee', 'emp_prev_lastname');
  }
}
