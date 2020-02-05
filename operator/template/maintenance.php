<?php include_once 'header.php';?>

<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
<div class="box">
<div class="box-body no-padding">
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th colspan="2"><?php echo $jkl["g183"];?></th>
</tr>
</thead>
<tr>
	<td><?php echo $jkl["g182"];?></td>
	<td><button type="submit" name="delCache" class="btn btn-danger"><?php echo $jkl["g48"];?></button></td>
</tr>
<tr>
	<td><?php echo $jkl["g313"];?></td>
	<td><button type="submit" name="delTokens" class="btn btn-danger"><?php echo $jkl["g48"];?></button></td>
</tr>
<tr>
	<td><?php echo $jkl["g185"];?></td>
	<td><button type="submit" name="optimize" class="btn btn-success"><?php echo $jkl["g185"];?></button></td>
</tr>
</table>
</div>
</div>
</div>

<div class="box box-success">
  	<div class="box-header with-border">
  		<i class="fa fa-server"></i>
    	<h3 class="box-title"><?php echo $jkl["g236"];?></h3>
  	</div><!-- /.box-header -->
  	<div class="box-body">
	<p><?php echo sprintf($jkl["g118"], JAK_VERSION);?></p>
	<?php include_once('include/chat_update.php');?>
	</div>
</div>

</form>

<?php include_once 'footer.php';?>