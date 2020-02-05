<?php include_once 'header.php';?>

<?php if (isset($CHATS_ALLC) && is_array($CHATS_ALLC) && !empty($CHATS_ALLC)) { ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box">
<div class="box-body no-padding">
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th>#</th>
<th><input type="checkbox" id="jak_delete_all" /></th>
<th><?php echo $jkl["g12"];?></th>
<th><?php echo $jkl["g145"];?></th>
<th><?php echo $jkl["g146"];?></th>
<th><?php echo $jkl["g13"];?></th>
<?php if (JAK_SUPERADMINACCESS) { ?><th class="content-go"><a class="btn btn-warning btn-sm btn-confirm" href="<?php echo JAK_rewrite::jakParseurl('chats', 'truncate');?>" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["e39"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-exclamation-triangle"></i></a></th>
<th><button class="btn btn-danger btn-sm btn-confirm" data-action="delete" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["e30"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-trash-o"></i></button></th><?php } ?>

</tr>
</thead>
<?php foreach($CHATS_ALLC as $vc) { ?>
<tr>
<td><?php echo $vc["id"];?></td>
<td><input type="checkbox" name="ls_delete_chats[]" class="highlight" value="<?php echo $vc["id"];?>" /></td>
<td><?php echo $vc["username"];?></td>
<td><?php echo $vc["touser"];?></td>
<td class="span8"><?php echo $vc["message"];?></td>
<td><?php echo JAK_base::jakTimesince($vc['sent'], JAK_DATEFORMAT, JAK_TIMEFORMAT);?></td>
<?php if (JAK_SUPERADMINACCESS) { ?><td></td>
<td><a class="btn btn-default btn-sm btn-confirm" href="<?php echo JAK_rewrite::jakParseurl('chats', 'delete', $vc["id"]);?>" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["e33"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-trash-o"></i></a></td><?php } ?>
</tr>
<?php } ?>
</table>
</div>
</div>
</div>
</form>

<?php } else { ?>

<div class="alert alert-info">
 	<?php echo $jkl['i3'];?>
</div>

<?php } if (isset($JAK_PAGINATE)) echo $JAK_PAGINATE;?>
		
<?php include_once 'footer.php';?>