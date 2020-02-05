<?php include_once 'header.php';?>

<?php if ($newop && jak_get_access("usrmanage", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)) { ?>
<p><a class="btn btn-primary" href="<?php echo JAK_rewrite::jakParseurl('users', 'new');?>"><?php echo $jkl["m7"];?></a></p>
<?php } ?>

<form method="post" class="jak_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box">
<div class="box-body no-padding">

<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th>#</th>
<th><input type="checkbox" id="jak_delock_all"></th>
<th><?php echo $jkl["u"];?></th>
<th><?php echo $jkl["u1"];?></th>
<th><?php echo $jkl["u2"];?></th>
<th></th>
<th><?php if (JAK_SUPERADMINACCESS) { ?><button class="btn btn-default btn-sm btn-confirm" data-action="lock" data-title="<?php echo addslashes($jkl["g101"]);?>" data-text="<?php echo addslashes($jkl["all"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-lock"></i></button><?php } ?></th>
<th></th>
<th><?php if (JAK_SUPERADMINACCESS) { ?><button class="btn btn-danger btn-sm btn-confirm" data-action="delete" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["al"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-trash-o"></i></button><?php } ?></th>
</tr>
</thead>
<?php if (isset($JAK_USER_ALL) && is_array($JAK_USER_ALL)) foreach($JAK_USER_ALL as $v) { ?>
<tr>
<td><?php echo $v["id"];?></td>
<td><input type="checkbox" name="jak_delock_all[]" class="highlight" value="<?php echo $v["id"].':#:'.$v["access"];?>"></td>
<td><a href="<?php echo JAK_rewrite::jakParseurl('users', 'edit', $v["id"]);?>"><?php echo $v["name"];?></a></td>
<td><?php echo $v["email"];?></td>
<td><a href="<?php echo JAK_rewrite::jakParseurl('users', 'edit', $v["id"]);?>"><?php echo $v["username"];?></a></td>
<td><a class="btn btn-default btn-sm btn-modal" data-toggle="modal" href="<?php echo JAK_rewrite::jakParseurl('users', 'stats', $v["id"], $v["username"]);?>" data-target="#jakModal"><i class="fa fa-signal"></i></a></td>
<td><?php if (JAK_SUPERADMINACCESS) { ?><a class="btn btn-default btn-sm" href="<?php echo JAK_rewrite::jakParseurl('users', 'lock', $v["id"]);?>"><i class="fa fa-<?php if ($v["access"] == '1') { ?>check<?php } else { ?>lock<?php } ?>"></i></a><?php } ?></td>
<td><a class="btn btn-default btn-sm" href="<?php echo JAK_rewrite::jakParseurl('users', 'edit', $v["id"]);?>"><i class="fa fa-pencil"></i></a></td>
<td><?php if (JAK_SUPERADMINACCESS) { ?><a class="btn btn-default btn-sm btn-confirm" href="<?php echo JAK_rewrite::jakParseurl('users', 'delete', $v["id"]);?>" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["al"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-trash-o"></i></a><?php } ?></td>
</tr>
<?php } ?>
</table>
</div>

</div>
</div>
<input type="hidden" name="action" id="action">
</form>
		
<?php include_once 'footer.php';?>