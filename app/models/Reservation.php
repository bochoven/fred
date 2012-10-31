<?php
class Reservation extends Model {

        function __construct($id='')
        {
			parent::__construct('id','reservation'); //primary key, tablename
			$this->rs['id'] = 0;
      $this->rs['title'] = '';
			$this->rs['res_date'] = '';
      $this->rs['start'] = '';
      $this->rs['end'] = '';
      $this->rs['user_id'] = '';
      $this->rs['students'] = 0;
      $this->rs['status'] = '';


                
            // Create table if it does not exist
       		$this->create_table();
               
            if ($id)
              $this->retrieve($id);
        }               
                
}