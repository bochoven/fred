<?php
require('kissmvc_core.php');

//===============================================================
// Engine
//===============================================================
class Engine extends KISS_Engine
{
        function request_not_found( $msg='' ) 
        {
                header( "HTTP/1.0 404 Not Found" );
                                
                die( '<html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL was not found on this server.</p><p>Please go <a href="javascript: history.back( 1 )">back</a> and try again.</p><hr /><p>Powered By: <a href="http://kissmvc.com">KISSMVC</a></p></body></html>' );
        }
        
}

//===============================================================
// Controller
//===============================================================
class Controller extends KISS_Controller 
{
        
}

//===============================================================
// Model/ORM
//===============================================================
class Model extends KISS_Model
{
    protected $rt = array(); // Array holding types
    protected $idx = array(); // Array holding indexes

        function save() {
        // one function to either create or update!
        if ($this->rs[$this->pkname] == '')
        {
            //primary key is empty, so create
            $this->create();
        }
        else
        {
            //primary key exists, so update
            $this->update();
        }
    }

        // ------------------------------------------------------------------------

        /**
         * Create table
         * 
         * Create table based on $this->rs array
         * and $this->rt array
         *
         * @param array assoc array with optional type strings
         * @return void
         * @author bochoven
         **/
        function create_table()
        {
                $dbh = $this->getdbh();
                
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES,false); 
                
        if( ! $dbh->prepare( "SELECT * FROM ".$this->enquote($this->tablename)." LIMIT 1" ))
        {
                        // Get columns
                        $columns = array();
                        foreach($this->rs as $name => $val)
                        {
                                // Determine type automagically
                                $type = is_int($val) ? 'INTEGER' : (is_string($val) ? 'VARCHAR(255)' : (is_float($val) ? 'REAL' : 'BLOB'));
                                
                                // Or set type from type array
                                $columns[$name] = isset($this->rt[$name]) ? $this->rt[$name] : $type;
                        }
                        
                        // Set primary key
                        $columns[$this->pkname] = 'INTEGER PRIMARY KEY';
                        
                        // Set autoincrement per db engine
                        switch($dbh->getAttribute(constant("PDO::ATTR_DRIVER_NAME")))
                        {
                                case 'sqlite':
                                        $columns[$this->pkname] .= ' AUTOINCREMENT';
                                        break;
                                case 'mysql':
                                        $columns[$this->pkname] .= ' AUTO_INCREMENT';
                        }
                        
                        // Compile columns sql
            $sql = '';
                        foreach($columns as $name => $type)
                        {
                                $sql .= $this->enquote($name) . " $type,";
                        }
                        $sql = rtrim($sql, ',');

            $rowsaffected = $dbh->exec(sprintf("CREATE TABLE %s (%s)", $this->enquote($this->tablename), $sql));

                        // Set indexes
                        $this->set_indexes();
                        
        }
                //print_r($dbh->errorInfo());
        return ($dbh->errorCode() == '00000');
        }
        
        // ------------------------------------------------------------------------

        /**
         * Set indexes for this table
         *
         * @return boolean
         * @author bochoven
         **/
        function set_indexes()
        {
                $dbh = $this->getdbh();
                
                foreach($this->idx as $idx_name => $idx_data)
                {
                        $dbh->exec(sprintf("CREATE INDEX '%s' ON %s (%s)", $idx_name, $this->enquote($this->tablename), join(',', $idx_data)));
                }
                
                
                return ($dbh->errorCode() == '00000');
        }

		/**
		 * Delete all entries in this table
		 *
		 * @return void
		 * @author Bochoven, A.E. van
		 **/
		function delete_all( $wherewhat = '', $bindings = '' )
		{
			$dbh = $this->getdbh();
            if ( is_scalar( $bindings ) )
                $bindings=$bindings ? array( $bindings ) : array();
            $sql = 'DELETE FROM '.$this->enquote( $this->tablename );
            if ( $wherewhat )
                $sql .= ' WHERE '.$wherewhat;
            $stmt = $dbh->prepare( $sql );
            return $stmt->execute( $bindings );
		}

}

//===============================================================
// View
//===============================================================
class View extends KISS_View
{
        
}
