<?php
class Item extends Model {

        function __construct($id='')
        {
			parent::__construct('id','item'); //primary key, tablename
			$this->rs['id'] = 0;
			$this->rs['short'] = '';
			$this->rs['loc'] = '';
			$this->rs['idnr'] = '';
			$this->rs['brand'] = '';
			$this->rs['serial'] = '';
			$this->rs['cnt'] = ''; // Amount
                
                // Create table if it does not exist
        		$this->create_table();
                
                if ($id)
                  $this->retrieve($id);

        }    

}