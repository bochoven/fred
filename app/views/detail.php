<?$item = new Item($id);?>
<?$prop = new Prop(); $props = $prop->retrieve_many('itemid = ?', $id)?>

<div class="modal-content modal-top">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3><?=$item->name?></h3>
</div>
<div class="modal-content">
	<table class="table table-striped">
		<tr>
			<th>Brand</th>
			<td><?=$item->brand?></td>
		</tr>
		<tr>
			<th>Location</th>
			<td><?=$item->loc?></td>
		</tr>
		<tr>
			<th>Category</th>
			<td><?=$item->cat?></td>
		</tr>
		<tr>
			<th>Subcategory</th>
			<td><?=$item->subcat?></td>
		</tr>
		<tr>
			<th>Serial Number</th>
			<td><?=$item->serial?></td>
		</tr>
		<tr>
			<th>ID Number</th>
			<td><?=$item->idnr?></td>
		</tr>
		<tr>
			<th>Amount</th>
			<td><span class="badge badge-info"><?=$item->cnt?></span></td>
		</tr>
		
		<?foreach($props as $prop):?>
		
		<tr>
			<th><?="$prop->prop"?></th>
			<td><?=$prop->val?></td>
		</tr>
		
		<?endforeach?>

	</table>
</div>