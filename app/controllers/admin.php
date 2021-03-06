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
										2 => 'short', 
										3 => 'loc',
										4 => 'idnr',
										5 => 'name',
										6 => 'brand',
										7 => 'serial',
										8 => 'prop Keuze',
										9 => 'prop Bijzonderheden',
										10 => 'cnt');
					
					

					$sheet = 0;
					
					// Reset db
					$item = new Item();
					$item->delete_all();
					$prop = new Prop();
					$prop->delete_all();
					$name_obj = new Name();
					$name_obj->delete_all();

					// Namelist holds the entries for the Name model
					$namelist = array();
					
					// Loop through rows skip first row
					for($row = 2;$row <= $data->rowcount($sheet); $row++)
					{						
						// If first column is empty, skip
						if(! trim($data->val($row,1,$sheet))) continue;
						
						$item = new Item();
						
						// Holds properties
						$props = array();

						// Temporary storage for name and cat
						$coltemp = array();
						
						// Loop through columns
						foreach($colinfo AS $col => $colname)
						{
							$val = $data->val($row,$col,$sheet);
							if($colname == 'name' OR $colname == 'cat')
							{
								if(trim($val))
									$coltemp[$colname] = trim($val);
							}
							elseif(trim($val) && strpos($colname, 'prop') === 0)
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

						// Set namelist item
						foreach($coltemp as $prop => $val)
						{
							$namelist[$item->short][$prop] = $val;	
						}
										
						
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

					// Store namelist
					foreach($namelist as $short => $vals)
					{
						$name_obj->id = '';
						$name_obj->short = $short;
						$name_obj->merge($vals);
						$name_obj->save();
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