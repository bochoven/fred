<?$this->view('partials/head')?>

    <div class="container">
      <div class="row">
        <div class="span12">
          <h2>Reservations <a href="<?=url("user/reservation/")?>" id="add-item" class="btn btn-primary pull-right"><b class="icon-plus"></b> New reservation</a></h2>
          <?$resobj = new Reservation()?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th>Start</th>
			<th>End</th>
			<th>User</th>
			<th>Status</th>
			<th>Booked</th>
			<th></th>
		</tr>
	</thead>
	<?foreach($resobj->retrieve_many('id > 0 ORDER BY start') as $res):?>

	
	<tr>
		<td><a href="<?=url("user/reservation/$res->id")?>"><?=$res->title?></a></td>
		<td><?=$res->start?></td>
		<td><?=$res->end?></td>
		<td><?=$res->user_id?></td>
		<td><?=$res->status?></td>
		<td><?=$res->res_date?></td>
		<td><a href="<?=url("user/delete_reservation/$res->id")?>" class="icon-minus-sign text-error remove-row"> remove</a></td>
	</tr>

	<?endforeach?>
	
</table>

<div class="modal hide" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body"></div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
</div>

        </div><!--/span-->
      </div><!--/row-->

      <hr>

<?$this->view('partials/foot')?>

	<script type="text/javascript">

		// remove row
          $('a.remove-row').click(function(e){
            e.preventDefault();
             r=confirm("Are you sure you want to remove this reservation?");
             if(r==true)
             {
             	var mytr = $(this).closest('tr');
             	$.post( $(this).attr('href'),
					function( data ) {
						// Todo: Check for errors
						mytr.remove();
					}, 'json'
				);
             }
            
          })
	</script>

  </body>
</html>

