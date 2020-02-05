<?php include_once 'header.php';?>


<?php if (isset($JAK_LOGINLOG_ALL) && is_array($JAK_LOGINLOG_ALL)) { ?>

<form method="post" class="jak_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box">
<div class="box-body no-padding">
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th>#</th>
<th><input type="checkbox" id="jak_delete_all"></th>
<th><?php echo $jkl["l1"];?></th>
<th><?php echo $jkl["g12"];?></th>
<th><?php echo $jkl["g11"];?></th>
<th><?php echo $jkl["g10"];?></th>
<th><?php echo $jkl["g13"];?></th>
<th><?php echo $jkl["g14"];?></th>
<th><a class="btn btn-warning btn-sm btn-confirm" href="<?php echo JAK_rewrite::jakParseurl('logs', 'truncate');?>" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["e34"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-exclamation-triangle"></i></a></th>
<th><button class="btn btn-danger btn-sm btn-confirm" data-action="delete" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["e33"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-trash-o"></i></button></th>
</tr>
</thead>
<?php foreach($JAK_LOGINLOG_ALL as $v) { ?>
<tr>
<td><?php echo $v["id"];?></td>
<td><input type="checkbox" name="jak_delete_all[]" class="highlight" value="<?php echo $v["id"];?>"></td>
<td><?php echo $v["name"];?></td>
<td><?php echo $v["fromwhere"];?></td>
<td><?php echo $v["ip"];?></td>
<td><?php echo $v["usragent"];?></td>
<td><?php echo JAK_base::jakTimesince($v["time"], JAK_DATEFORMAT, JAK_TIMEFORMAT);?></td>
<td><i class="fa fa-<?php if ($v["access"] == '1') { ?>check<?php } else { ?>lock<?php } ?>"></i></td>
<td></td>
<td><a class="btn btn-default btn-sm btn-confirm" href="<?php echo JAK_rewrite::jakParseurl('logs', 'delete', $v["id"]);?>" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["e33"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-trash-o"></i></a></td>
</tr>
<?php } ?>
</table>
</div>
</div>
</div>
<input type="hidden" name="action" id="action">
</form>

<?php } else { ?>

<div class="alert alert-info">
<?php echo $jkl['i3'];?>
</div>

<?php } if (isset($JAK_PAGINATE)) echo $JAK_PAGINATE;?>
		
<?php include_once 'footer.php';?>