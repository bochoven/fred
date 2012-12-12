<?php
// This Model maps a short name to a long name and adds a category
class Name extends Model {

        function __construct($short='')
        {
			parent::__construct('id','name'); //primary key, tablename
			$this->rs['id'] = 0;
			$this->rs['short'] = '';
			$this->rs['name'] = '';
			$this->rs['cat'] = '';
                
                // Create table if it does not exist
        		$this->create_table();
                
                if ($short)
                  $this->retrieve_one('short=?', $short);
        }

        function fetch_array($wherewhat = '', $bindings = '')
        {
        	$out = array();

        	foreach($this->retrieve_many($wherewhat = '', $bindings = '') as $obj)
        	{
        		$out[$obj->short] = $obj;
        	}

        	return $out;
        }          
                
}