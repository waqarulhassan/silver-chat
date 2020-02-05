<?php include_once 'header.php';?>

<?php if (JAK_HOLIDAY_MODE != 0) { ?>
<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo $jkl["g303"];?> (<?php echo (JAK_HOLIDAY_MODE == 1 ? $jkl["g1"] : $jkl["g305"]);?>)</div>
<?php } if (isset($gcarray) && !empty($gcarray)) { ?>
<div class="row">
  <div class="col-md-12">
  <div class="box box-success">
    <div class="box-header">
      <h3 class="box-title"><i class="fa fa-comments"></i> <?php echo $jkl["m29"];?></h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <?php foreach ($gcarray as $c) { ?>
          <a class="btn btn-primary btn-sm" href="<?php echo str_replace("operator/", "", JAK_rewrite::jakParseurl('groupchat', $c["id"], $c["lang"]));?>" target="_blank"><i class="fa fa-comments"></i> <?php echo $c["title"];?></a>&nbsp;
        <?php } ?>
      </div>
  </div>
  </div>
</div>
<?php } ?>

<?php if ($stataccess) { ?>

<h3><?php echo $jkl["m10"];?> <a href="<?php echo JAK_rewrite::jakParseurl('statistics');?>"><i class="fa fa-pie-chart"></i></a></h3>

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
<?php } ?>

<div class="box">
    <div class="box-header">
      <h3 class="box-title"><i class="fa fa-download"></i> Downloads and Support</h3>
      <div class="box-body">
<p>Often on the road, download our native apps for Android and iOS to easily serve your clients outside your office. Push notifications included, just setup your business hours in <a href="<?php echo JAK_rewrite::jakParseurl('users','edit',JAK_USERID);?>">your operator profile</a>. Your Live Chat URL: <strong><?php echo rtrim(BASE_URL_ORIG,"/");?></strong></p>
  <p>Get your native push notifications token and user key from our <a href="https://www.jakweb.ch/push">Push Server</a>. Use the same login details from when you have purchased a license with us.</p>
</div>
  </div>
</div>
<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
        <img src="img/dashboard-002.jpg" class="img-fluid">
      <a href="https://play.google.com/store/apps/details?id=ch.jakweb.livechat" class="small-box-footer">Get Android App <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <img src="img/dashboard-001.jpg" class="img-fluid">
      <a href="https://itunes.apple.com/us/app/live-chat-3-lcps/id1229573974" class="small-box-footer">Get iOS App <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <img src="img/dashboard-003.jpg" class="img-fluid">
      <a href="https://www.jakweb.ch/downloads" class="small-box-footer">Live Chat Plugins <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-red">
      <img src="img/dashboard-004.jpg" class="img-fluid">
      <a href="https://www.jakweb.ch/faq" class="small-box-footer">FAQ <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->
</div><!-- /.row -->

<!-- Only for super admin access -->
<?php if (JAK_SUPERADMINACCESS && $jakhs['hostactive']) { ?>

<!-- For hosted solutions to inform customer -->

<h2>Welcome <?php echo $jakuser->getVar("username");?></h2>
<p>Thank you for using our Live Chat solution.</p>
<div class="alert alert-info" id="membermsg">Your membership is valid until: <span id="memberdate"><?php echo JAK_base::jakTimesince(JAK_VALIDTILL, JAK_DATEFORMAT, JAK_TIMEFORMAT);?></span></div>
<h3>Available resources</h3>
<ul>
  <li>You use <?php echo $totalop;?> operators from <?php echo $jakhs['operators'];?></li>
  <li>You use <?php echo $totaldep;?> departments from <?php echo $jakhs['departments'];?></li>
  <li>You use <?php echo $totalwidg;?> chat widgets from <?php echo $jakhs['chatwidgets'];?></li>
</ul>

<?php if (JAK_VALIDTILL != 0 && (JAK_VALIDTILL < time())) { ?>

<div class="alert alert-danger" id="expiredmsg">Your membership has expired, the chat widget will not appear on your website. Please renew your membership with one of the options below.</div>

<?php } ?>

<?php if (JAK_VALIDTILL != 0 && JAK_VALIDTILL < strtotime("+30 day") && (!empty($sett["paypal"]) || !empty($sett["stripepublic"]))) { ?>
  <!-- Extend membership -->
  <h2>Extend your access to your custom Live Chat access</h2>
  <div class="row">
    <div class="col-4">
      <select name="month" id="month" class="form-control">
        <option value="<?php echo $jakhs['pricemonth'];?>">1 Month (<?php echo $jakhs['pricemonth'].' '.$sett["currency"];?>)</option>
        <option value="<?php echo (3*$jakhs['pricemonth']);?>">3 Months (<?php echo (3*$jakhs['pricemonth']).' '.$sett["currency"];?>)</option>
        <option value="<?php echo (6*$sett["mo6month"]);?>">6 Months (<?php echo (6*$jakhs['pricemonth']).' '.$sett["currency"];?>)</option>
        <option value="<?php echo (12*$sett["mo12month"]);?>">12 Months (<?php echo (12*$jakhs['pricemonth']).' '.$sett["currency"];?>)</option>
      </select>
    </div>
    <div class="col-4">
      <?php if (!empty($sett["paypal"])) { ?><p><a href="javascript:void(0)" class="btn btn-info btn-block btn-pay" id="paypal"><i class="jak-loadbtn"></i> <i class="fa fa-paypal"></i> <?php echo $jkl['g294'];?></a></p><?php } ?>
    </div>
    <div class="col-4">
      <?php if (!empty($sett["stripepublic"])) { ?><p><a href="javascript:void(0)" class="btn btn-info btn-block btn-pay" id="stripe"><i class="jak-loadbtn"></i> <i class="fa fa-cc-stripe"></i> <?php echo $jkl['g293'];?></a></p><?php } ?>
    </div>
  </div>
  <input type="hidden" name="stripeToken" id="stripeToken">
  <input type="hidden" name="stripeEmail" id="stripeEmail">
  <div id="paypal_form" class="hidden"></div>
<?php } } ?>

<?php include_once 'footer.php';?>