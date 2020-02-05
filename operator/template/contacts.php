<?php include_once 'header.php';?>

<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-md-4">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3><?php echo $totalAll;?></h3>
        <p><?php echo $jkl["stat_s29"];?></p>
      </div>
      <div class="icon">
        <i class="fa fa-commenting-o"></i>
      </div>
      <a href="javascript:void(0)" class="small-box-footer"><?php echo $jkl["stat_s29"];?></a>
    </div>
  </div><!-- ./col -->
  <div class="col-md-4">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3><?php echo $totalAllc;?></h3>
        <p><?php echo $jkl["stat_s30"];?></p>
      </div>
      <div class="icon">
        <i class="fa fa-commenting"></i>
      </div>
      <a href="javascript:void(0)" class="small-box-footer"><?php echo $jkl["stat_s30"];?></a>
    </div>
  </div><!-- ./col -->
  <div class="col-md-4 hidden-xs hidden-sm">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3><?php echo $bounce_percentage;?>%</h3>
        <p><?php echo $jkl["stat_s31"];?></p>
      </div>
      <div class="icon">
        <i class="fa fa-user"></i>
      </div>
      <a href="javascript:void(0)" class="small-box-footer"><?php echo $jkl["stat_s31"];?></a>
    </div>
  </div><!-- ./col -->
</div><!-- /.row -->

<?php if (isset($totalAll) && !empty($totalAll)) { ?>

<form method="post" class="jak_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box">
<div class="box-body">

<?php if (JAK_SUPERADMINACCESS) { ?>
<p class="pull-right">
<a class="btn btn-warning btn-sm btn-confirm" href="<?php echo JAK_rewrite::jakParseurl('contacts', 'truncate');?>" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["e40"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-exclamation-triangle"></i></a> <button class="btn btn-danger btn-sm btn-confirm" data-action="delete" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["e30"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-trash-o"></i></button>
</p>
<div class="clearfix"></div>
<?php } ?>

</tr>
</thead>

<table id="dynamic-data" class="table table-striped table-bordered w-100 d-block d-md-table">
<thead>
<tr>
<th>#</th>
<th><input type="checkbox" id="jak_delete_contacts"></th>
<th><?php echo $jkl["g54"];?></th>
<th><?php echo $jkl["l5"];?></th>
<th><?php echo $jkl["stat_s30"];?></th>
<th><?php echo $jkl['g13'];?></th>
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

<?php } if (isset($JAK_PAGINATE)) echo $JAK_PAGINATE;?>
		
<?php include_once 'footer.php';?>