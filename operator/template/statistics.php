<?php include_once 'header.php';?>

<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3><?php echo $sessCtotal;?></h3>
        <p><?php echo $jkl["stat_s25"];?></p>
      </div>
      <div class="icon">
        <i class="fa fa-bar-chart"></i>
      </div>
      <a href="<?php echo JAK_rewrite::jakParseurl('leads');?>" class="small-box-footer"><?php echo $jkl["stat_s28"];?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3><?php echo $commCtotal;?></h3>
        <p><?php echo $jkl["stat_s26"];?></p>
      </div>
      <div class="icon">
        <i class="fa fa-comments-o"></i>
      </div>
      <a href="<?php echo JAK_rewrite::jakParseurl('leads');?>" class="small-box-footer"><?php echo $jkl["stat_s28"];?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3><?php echo $statsCtotal;?></h3>
        <p><?php echo $jkl["stat_s10"];?></p>
      </div>
      <div class="icon">
        <i class="fa fa-pie-chart"></i>
      </div>
      <a href="<?php echo JAK_rewrite::jakParseurl('users');?>" class="small-box-footer"><?php echo $jkl["stat_s28"];?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3><?php echo $visitCtotal;?></h3>
        <p><?php echo $jkl["stat_s27"];?></p>
      </div>
      <div class="icon">
        <i class="fa fa-users"></i>
      </div>
      <a href="<?php echo JAK_rewrite::jakParseurl('uonline');?>" class="small-box-footer"><?php echo $jkl["stat_s28"];?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->
</div><!-- /.row -->

<?php if (JAK_SHOW_IPS) { ?>
<h4><?php echo $jkl["stat_s"];?></h4>
<div id="map_canvas"></div>
<?php } ?>
		
<h4><?php echo $jkl["stat_s3"];?></h4>
<form id="jak_statform" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
<div class="row">
	<div class="col-md-6">
		<?php if (isset($JAK_DEPARTMENTS) && !empty($JAK_DEPARTMENTS)) { ?>
		<select name="jak_depid" id="jak_depid" class="form-control">
		
		<option value="0"<?php if (isset($_REQUEST["jak_depid"]) && $_REQUEST["jak_depid"] == '0') { ?> selected="selected"<?php } ?>><?php echo $jkl["g105"];?></option>
		
		<?php foreach($JAK_DEPARTMENTS as $v) { ?>
		
		<option value="<?php echo $v["id"];?>"<?php if (isset($_REQUEST["jak_depid"]) && $_REQUEST["jak_depid"] == $v["id"]) { ?> selected="selected"<?php } ?>><?php echo $v["title"];?></option>
		
		<?php } ?>
		</select>
		<?php } ?>
		<input type="hidden" name="start_date" id="start_date" value="<?php if (isset($_SESSION["stat_start_date"])) echo $_SESSION["stat_start_date"];?>" />
		<input type="hidden" name="end_date" id="end_date" value="<?php if (isset($_SESSION["stat_end_date"])) echo $_SESSION["stat_end_date"];?>" />
	</div>
	<div class="col-md-6">
		<div id="reportrange" class="pull-right">
		    <i class="fa fa-calendar fa-lg"></i>
		    <span><?php echo date("F j, Y", strtotime($_SESSION["stat_start_date"]));?> - <?php echo date("F j, Y", strtotime($_SESSION["stat_end_date"]));?></span> <b class="caret"></b>
		</div>
	</div>
</div>
</form>
<hr>
	
<div class="row">
	<div class="col-md-6">
		
		<div id="chart_operator" style="width: 100%; height: 300px; margin-right: 20px;"></div>
		
	</div>
	
	<div class="col-md-6">
		
		<div id="chart_feedback" style=";width: 100%; height: 300px;"></div>
		
	</div>
		
</div>

<h4 class="mt-3"><?php echo $jkl["m10"];?></h4>
<div class="row">
	<div class="col-md-6">
		
		<div id="chart" style="width: 100%; height: 300px; margin-right: 20px;"></div>
		
	</div>
	
	<div class="col-md-6">
		
		<div id="chart2" style=";width: 100%; height: 300px;"></div>
		
	</div>
		
</div>

<?php include_once 'footer.php';?>