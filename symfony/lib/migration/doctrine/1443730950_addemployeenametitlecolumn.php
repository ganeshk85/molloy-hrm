<?php

class Addemployeenametitlecolumn extends Doctrine_Migration_Base
{
  public function up()
  {
	  $this->addColumn('hs_hr_employee', 'emp_title', 'string', array('length' => '20'));
  }

  public function down()
  {
	  $this->removeColumn('hs_hr_employee', 'emp_title');
  }
}
