<?php
class user extends Controller
{
	function __construct()
	{

	} 

	//===============================================================

	function index()
	{
		redirect('user/reservations');
	}

	//===============================================================

	function inventory()
	{
		$data = array();
		$obj = new View();
		$obj->view('voorraad', $data);
	}

	//===============================================================

	function reservation($id = '')
	{
		$data = array('id' => $id);
		$obj = new View();
		$obj->view('reservation', $data);
	}
	
	//===============================================================

	function reservations($id = '')
	{
		$data = array('id' => $id);
		$obj = new View();
		$obj->view('reservation_list', $data);
	}

	//===============================================================

	function detail($id)
	{
		$data = array('id' => $id);
		$obj = new View();
		$obj->view('detail', $data);
	}

	//===============================================================


	function save_reservation($id = '')
	{
		$out = array('error' => '', 'redirect' => '');

		// Todo: check POST vars

		$reservation = new Reservation($id);
		$reservation->merge($_POST);
		$reservation->user_id = 'test_user'; // Fixme
		$reservation->save();

		if(isset($_POST['item_list']))
		{
			$newid = $reservation->id;
			$res_obj = new Res_item();

			// Delete all res items for this reservation
			$res_obj->delete_all('res_id=?', $newid);

			$res_obj->res_id = $newid;

			// JSON decode item_list
			foreach(json_decode($_POST['item_list']) AS $item)
			{
				$res_obj->id = '';
				$res_obj->merge((array)$item)->save();
			}

		}


		if( ! $id)
		{
			$out['redirect'] = url("user/reservation/$reservation->id");
		}

		echo json_encode($out);
	}
	//===============================================================

	function delete_reservation($id='')
	{
		// Todo: Check permissions

		$reservation = new Reservation($id);
		$reservation->delete();

	}
	//===============================================================


	function calendar()
	{
		$data = array();
		$obj = new View();
		$obj->view('calendar', $data);
	}

	//===============================================================


	function json_events()
	{

		$range[1] = isset($_GET['start']) ? date('Y-m-d', $_GET['start']) : '2000-01-01';
		$range[0] = isset($_GET['end']) ? date('Y-m-d', $_GET['end']) : '2000-01-01';

 		$out = array();

		$reservation = new Reservation();
		//foreach($reservation->retrieve_many('start >= ? AND end <= ?', $range) AS $event)
		foreach($reservation->retrieve_many() AS $event)
		{
			$out[] = array(	'id' => $event->id,
							'title' => $event->title,
							'start' => $event->start,
							'end' => $event->end,
							'url' => url("user/reservation/$event->id"));
		}

		echo json_encode($out);

	}

	

}