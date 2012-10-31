 <?php
class admin extends Controller
{
        function __construct()
        {
                //die("authentication needed"); // TODO: implement auth
        } 
        
        
        //===============================================================
        
        function index()
        {
                $data = array();
				$obj = new View();
				$obj->view('admin', $data);
				
        }

		function submit()
		{
			if($_FILES)
			{
				if( isset($_FILES['file']) && $_FILES['file']['error'] == 0)
				{
					// Check if file is valid
					require(APP_PATH.'lib/excel_reader2'.EXT);
					$data = new Spreadsheet_Excel_Reader($_FILES['file']['tmp_name'], false);
					
					// Translation table between excel and db
					$colinfo = array(	1 => 'cat', 
										2 => 'subcat', 
										3 => 'prop Koeling', 
										4 => 'loc',
										5 => 'idnr',
										6 => 'name',
										7 => 'brand',
										8 => 'serial',
										9 => 'prop Keuze',
										10 => 'prop Bijzonderheden',
										11 => 'cnt');
					
					

					$sheet = 0;
					
					// Reset db
					$item = new Item();
					$item->delete_all();
					$prop = new Prop();
					$prop->delete_all();
					
					// Loop through rows skip first row
					for($row = 2;$row <= $data->rowcount($sheet); $row++)
					{						
						// If first column is empty, skip
						if(! trim($data->val($row,1,$sheet))) continue;
						
						$item = new Item();
						
						// Holds properties
						$props = array();
						
						// Loop through columns
						foreach($colinfo AS $col => $colname)
						{
							$val = $data->val($row,$col,$sheet);
							if(trim($val) && strpos($colname, 'prop') === 0)
							{
								$props[substr($colname, 5)] = $val;
							}
							else
							{
								$item->$colname = $val;
							}
							
						}
						$item->save();
						$id = $item->id; 						
						
						// Process props
						if($props)
						{
							$prop = new Prop();
							$prop->itemid = $id;

							foreach($props as $p => $v)
							{
								$prop->id = '';
								$prop->prop = $p;
								$prop->val = $v;
								$prop->save();
							}
						}	
					}

					// Move excel to downloads folder
					move_uploaded_file($_FILES['file']['tmp_name'], APP_ROOT . 'downloads/Apparatenlijst.xls');

				}
				else
				{
					echo 'upload failed';

				}

			}

			redirect();
		}
        
        
        //===============================================================
        
        function resetdb()
        {               
                require(APP_PATH.'helpers/db_helper'.EXT);
                
                reset_db();
                
                redirect();
        }
        
}