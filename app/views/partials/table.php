<?$item = new Item(); $p_article = (object) array('short' => '', 'cat' => '')?>
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
	<?foreach($item->retrieve_many('1=1 ORDER BY cat, short') as $article):?>
	<?if($article->cat == $p_article->cat && $article->short == $p_article->short):?>
		<?$p_article->cnt++?>
		<?$p_article->rs['multi'] = 1?>
	<?else:?>
	
	<?if($p_article->short):?>
	<tr>
		<td><?=$p_article->short?></td>
		<td><a data-toggle="modal" data-target="#myModal" href="<?=url("user/detail/$p_article->id")?>"><?=$p_article->name?></a></td>
		<td><?=$p_article->brand?></td>
		<td><?=$p_article->loc?></td>
		<td><?=$p_article->cat?></td>
		<td><span class="badge badge-info"><?=$p_article->cnt?></span><?=isset($p_article->rs['multi'])?'*':''?></td>
	</tr>
	<?endif?>
	
	<?$p_article = $article?>

	<?endif?>
	<?endforeach?>
	<tr>
		<td><?=$p_article->short?></td>
		<td><a data-toggle="modal" data-target="#myModal" href="<?=url("user/detail/$p_article->id")?>"><?=$p_article->name?></a></td>
		<td><?=$p_article->brand?></td>
		<td><?=$p_article->loc?></td>
		<td><?=$p_article->cat?></td>
		<td><span class="badge badge-info"><?=$p_article->cnt?></span></td>
	</tr>
</table>

<div class="modal hide" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body"></div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
</div>
