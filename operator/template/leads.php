<?php include_once 'header.php';?>

<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-md-10">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3><?php echo secondsToTime($total_support, $jkl['g230']);?></h3>
        <p><?php echo $jkl["stat_s6"];?></p>
      </div>
      <div class="icon">
        <i class="fa fa-clock-o"></i>
      </div>
      <a href="javascript:void(0)" class="small-box-footer"><?php echo $jkl["stat_s6"];?></a>
    </div>
  </div><!-- ./col -->
  <div class="col-md-2 hidden-xs hidden-sm">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3><?php echo $bounce_percentage;?>%</h3>
        <p><?php echo $jkl["stat_s19"];?></p>
      </div>
      <div class="icon">
        <i class="fa fa-user"></i>
      </div>
      <a href="javascript:void(0)" class="small-box-footer"><?php echo $jkl["stat_s19"];?></a>
    </div>
  </div><!-- ./col -->
</div><!-- /.row -->

<div class="row">
	<div class="col-md-12">
		<p><span class="badge badge-dark"><i class="fa fa-comments-o"></i> <?php echo $jkl['g225'];?></span>
		<span class="badge badge-danger"><i class="fa fa-file-text-o"></i> <?php echo $jkl['g226'];?></span></p>
	</div>
</div>

<?php if (isset($totalAll) && $totalAll != 0) { ?>

<form method="post" class="jak_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box">
<div class="box-body">


<?php if (JAK_SUPERADMINACCESS) { ?>
<p class="pull-right">
<a class="btn btn-warning btn-sm btn-confirm" href="<?php echo JAK_rewrite::jakParseurl('leads', 'truncate');?>" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["e40"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-exclamation-triangle"></i></a> <button class="btn btn-danger btn-sm btn-confirm" data-action="delete" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["e30"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-trash-o"></i></button>
</p>
<div class="clearfix"></div>
<?php } ?>

<table id="dynamic-data" class="table table-striped table-bordered w-100 d-block d-md-table">
<thead>
<tr>
<th>#</th>
<th><input type="checkbox" id="jak_delete_all"></th>
<th><?php echo $jkl["g54"];?></th>
<th><?php echo $jkl["l5"];?></th>
<th><?php echo $jkl["g130"];?></th>
<th><?php echo $jkl["g131"];?></th>
<th><?php echo $jkl["g181"];?></th>
<th><i class="fa fa-comments-o"></i></th>
<th><?php echo $jkl["g13"];?></th>
</tr>
</thead>
</table>

</div>
</div>
<input type="hidden" name="action" id="action">
</form>

<?php } else { ?>

<div class="alert alert-info">
<?php echo $jkl['i3'];?>
</div>

<?php } ?>
		
<?php include_once 'footer.php';?>