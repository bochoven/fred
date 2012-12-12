<?$dbh= getdbh();$item = new Item(); $name = new Name(); // Init db
        $sql = "SELECT i.*, n.name, n.cat 
        		FROM item i 
                LEFT JOIN name n ON (i.short = n.short)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute()?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Short Name</th>
			<th>Name</th>
			<th>Brand</th>
			<th>Location</th>
			<th>Category</th>
			<th>Amount</th>
		</tr>
	</thead>
	<?while($article = $stmt->fetch( PDO::FETCH_OBJ )):?>
	
	<tr>
		<td><?=$article->short?></td>
		<td><a data-toggle="modal" data-target="#myModal" href="<?=url("user/detail/$article->id")?>"><?=$article->name?></a></td>
		<td><?=$article->brand?></td>
		<td><?=$article->loc?></td>
		<td><?=$article->cat?></td>
		<td><span class="badge badge-info"><?=$article->cnt?></span></td>
	</tr>
	
	
	<?endwhile?>

</table>

<div class="modal hide" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body"></div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
</div>
