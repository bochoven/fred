<?$this->view('partials/head')?>

    <div class="container">
      <div class="row">
        <div class="span4">
          <?$reservation = new Reservation($id)?>
          <h2 class="title"><?=$reservation->title?$reservation->title:'New reservation'?></h2>
          <form id="new_course" action="<?=url('user/save_reservation/'.$id)?>" method="post" class="well clearfix">
          	<label for="title">Course Name</label>
          	<input type="text" name="title" id="title" placeholder="Course title" value="<?=$reservation->title?>">
      			<label for="start">Start date</label>
      			<input type="text" class="datepicker" name="start" id="start" value="<?=$reservation->start?>">
      			<label for="end">End date</label>
      			<input type="text" class="datepicker" name="end" id="end" value="<?=$reservation->end?>">
      			<label for="students">Number of students</label>
      			<input type="text" name="students" id="students" value="<?=$reservation->students?>"><br>
            <a href="<?=url("user/reservation/$id")?>" class="btn btn-danger cancel hide">Cancel</a>

      			<button type="submit" class="btn btn-primary hide pull-right">Save</button>
            <input type="hidden" name="item_list">
    			</form>

        </div><!--/span-->
         <div class="span8">
         	<h2>Course Items</h2>
         	<table id="item_list" style="font-size: 1.2em" class="table table-striped">
         		<tr>
         			<th>Item</th>
         			<th></th>
         		</tr>
            <?$dbh = getdbh(); 
            $sql = "SELECT DISTINCT r.*, n.name FROM res_item r LEFT JOIN name n ON (r.short = n.short) WHERE r.res_id = $id";
            $stmt = $dbh->prepare( $sql );?>
            <?if($stmt):?>
            <?$stmt->execute(); while ( $item = $stmt->fetch( PDO::FETCH_OBJ ) ):?>
            <tr>
              <td><span data-item="<?=$item->short?>" data-amt="<?=$item->amt?>" data-per="<?=$item->per?>" class="badge badge-info"><?=$item->amt?></span><i><?=$item->name?></i></td>
              <td style="text-align:right"><a href="" class="icon-edit edit-row"> edit</a>
              <a href="" class="icon-trash text-error remove-row"> remove</a>
              </td>
            </tr>
            <?endwhile?>
            <?endif?>
         	</table>
         	<p style="text-align: center">
         	<a href="/" id="add-item" class="btn btn-primary"><b class="icon-plus"></b> Add item</a>
         </div>
      </div><!--/row-->

      <hr>

<div class="modal hide" data-update="" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add Item</h3>
  </div>
  <div class="modal-body">
    <form>
    	<input type="text" value="1" name="amount" id="amount" style="width:2em">

    	<select name="item" id="item">

        <?$cat = ''; $dbh= getdbh();$item = new Item(); $name = new Name(); // Init db
        $sql = "SELECT * FROM item i 
                LEFT JOIN name n ON (i.short = n.short) 
                GROUP BY i.short ORDER BY cat, short ";
        $stmt = $dbh->prepare($sql);
        $stmt->execute()?>
      <?while($article = $stmt->fetch( PDO::FETCH_OBJ )):?>


        <?if($article->short == $p_article->short):?>
          <?$p_article->cnt++?>
          <?$p_article->rs['multi'] = 1?>
        <?else:?>

          <?if($p_article->cat != $cat):?>
            <?if($cat):?>
            </optgroup>
            <?endif?>
            <optgroup label="<?=$p_article->cat?>">
            <?$cat = $p_article->cat?>
          <?endif?>

        
          <?if($p_article->short):?>
                  <option value="<?=$p_article->short?>"><?=$p_article->name?></option>
          <?endif?>
        
          <?$p_article = $article?>

        <?endif?>
      <?endwhile?>

        </optgroup>
    	</select>
		per
    	<select name="per" id="per">
    		<option value="course">Course</option>
    		<option value="student1">Student</option>
    		<option value="student2">2 Students</option>
    		<option value="student3">3 Students</option>
    		<option value="student4">4 Students</option>
    		<option value="student5">5 Students</option>    		
    	</select>

	  </form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button id="save-changes" class="btn btn-primary">Add</button>
  </div>
</div>

<?$this->view('partials/foot')?>

<script src="<?=WEB_FOLDER?>assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">

  // Init datepickers
	$('.datepicker').datepicker({'format':'yyyy-mm-dd'});

  // Show submit and cancel button when a field is changed
  $('#new_course input').focus(function() {
    show_buttons();
  })

  // Update item list with correct numbers
  update_item_list();
  add_item_events();

  // On submit reservation
	$('#new_course').submit(function(e){
		e.preventDefault();

    // Collect item list
    var item_list = Array();
    $('#item_list tr .badge').each(function(i){
      item_list.push({'short':$(this).data('item'), 'amt':$(this).data('amt'), 'per':$(this).data('per')});
    });

    // Store item_list in form
    $(this).find('input[name=item_list]').val(JSON.stringify(item_list));

		$.post( $(this).attr('action'), $(this).serialize(),
		  function( data ) {
			// Check for errors
			if(data.redirect)
      {
        window.location.replace(data.redirect);
      }
      // Update items
      update_item_list();

      // Update title
      $('h2.title').text($('#title').val());

      // Hide Submit and cancel buttons
      $('#new_course button').removeClass('btn-primary').addClass('btn-success').fadeOut(1000);
      $('#new_course a.cancel').fadeOut(1000);

		  }, 'json'
		);
	});

  $('#students').change(function(){
    // Update items
    update_item_list();
  })

  function update_item_list()
  {
    $('#item_list tr .badge').each(function(i)
      {
        var amt = $(this).data('amt');
        var per = $(this).data('per');
        if(per!='course')
        {
          $(this).text(Math.ceil($('#students').val() / per.substring(7) * amt));
        }
      });
  }

  function show_buttons()
  {
    $('#new_course button').removeClass('btn-success').addClass('btn-primary').fadeIn(1000);
    $('#new_course a.cancel').fadeIn(1000);
  }

  function add_item_events()
  {
    // remove row
    $('a.remove-row').click(function(e){
      e.preventDefault();
      $(this).closest('tr').remove();
      show_buttons();
    });

    // Edit
    $('a.edit-row').click(function(e){
      e.preventDefault();

      // Find corresponding badge
      var badge = $(this).closest('tr').find('.badge');

      // Set selected
      $('select#item').val($(badge).data('item'));

      // Set amount
      $('#amount').val($(badge).data('amt'));

      // Set per
      $('select#per').val($(badge).data('per'));

      $('.modal').data('update', badge).modal('show');

    });
  }

	// add item event
	$('#add-item').click(function(e){
		e.preventDefault();
		$('.modal').modal('show');
	})

	// save item
	$('#save-changes').click(function(e){
		e.preventDefault();

		val=$("select#item option:selected").val();
    name=$("select#item option:selected").text();
    amt=$("input#amount").val();
    per=$("select#per option:selected").val();
    if(per=='course')
    {
      netto_amt=amt;
    }
    else
    {
      netto_amt = Math.ceil($('#students').val() / per.substring(7) * amt);
    }

    // Check if update
    if($('.modal').data('update'))
    {
        badge=$('.modal').data('update');
        badge.data('item', val);
        badge.data('amt', amt);
        badge.data('per', per);
        badge.next().text(name);
        badge.text(netto_amt);
    }
    else
    {
      // Add row to table
      $('#item_list tr:last').after('<tr><td><span data-item="'+val+'" data-amt="'+amt+'" data-per="'+per+'" class="badge badge-info">'+netto_amt+'</span><i>'+name+'</i></td>\
        <td style="text-align:right"><a href="" class="icon-edit edit-row"> edit</a>\
        <a href="" class="icon-trash text-error remove-row"> remove</a></td></tr>');
      
      add_item_events();

    }

    show_buttons();

    //close modal
		$('.modal').data('update', '').modal('hide');
	});


</script>

  </body>
</html>
