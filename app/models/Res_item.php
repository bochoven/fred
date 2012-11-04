<?php
class Res_item extends Model {

        function __construct($id='')
        {
			parent::__construct('id','res_item'); //primary key, tablename
			$this->rs['id'] = 0;
      $this->rs['res_id'] = 0; // FK Reservation id
			$this->rs['short'] = ''; // FK Item short
			$this->rs['per'] = '';
			$this->rs['amt'] = '';
                
            // Create table if it does not exist
       		$this->create_table();
               
            if ($id)
              $this->retrieve($id);
        }               
                
}