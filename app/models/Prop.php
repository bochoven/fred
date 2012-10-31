<?php
class Prop extends Model {

        function __construct($id='')
        {
			parent::__construct('id','prop'); //primary key, tablename
			$this->rs['id'] = 0;
			$this->rs['itemid'] = '';
			$this->rs['prop'] = '';
			$this->rs['val'] = '';
                
            // Create table if it does not exist
       		$this->create_table();
               
            if ($id)
              $this->retrieve($id);
        }               
                
}