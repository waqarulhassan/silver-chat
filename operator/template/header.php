<!DOCTYPE html>
<html lang="<?php echo $USER_LANGUAGE;?>">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
  <meta name="description" content="Live Chat PHP">
  <meta name="keywords" content="Your premium Live Support/Chat application from JAKWEB">
  <meta name="author" content="Live Chat PHP">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <title><?php echo $SECTION_TITLE;?> - <?php echo JAK_TITLE;?></title>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo BASE_URL_ORIG;?>css/stylesheet.css?=<?php echo JAK_UPDATED;?>" type="text/css" media="screen">
  <link rel="stylesheet" href="<?php echo BASE_URL;?>css/screen.css?=<?php echo JAK_UPDATED;?>" type="text/css" media="screen">
  
  <?php if ($jkl["rtlsupport"]) { ?>
  <!-- RTL Support -->
  <link rel="stylesheet" href="<?php echo BASE_URL_ORIG;?>css/style-rtl.css?=<?php echo JAK_UPDATED;?>" type="text/css" media="screen">
  <!-- End RTL Support -->
  <?php } ?>
  
  <!-- Le fav and touch icons -->
  <link rel="shortcut icon" href="<?php echo BASE_URL_ORIG;?>img/ico/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo BASE_URL_ORIG;?>img/ico/144.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo BASE_URL_ORIG;?>img/ico/114.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo BASE_URL_ORIG;?>img/ico/72.png">
  <link rel="apple-touch-icon-precomposed" href="<?php echo BASE_URL_ORIG;?>img/ico/57.png">
   
</head>
<body<?php if (!JAK_USERID) echo ' class="login-page"';?>>
<?php if (JAK_USERID) { ?>
  <div off-canvas="menu-left left push" class="main-sidebar">
    <!-- sidebar: style -->
      <section class="sidebar">
        <div class="back-home"><a href="<?php echo BASE_URL_ADMIN;?>"><img src="<?php echo BASE_URL;?>img/logo.png" alt="logo"></a></div>
        
        <div class="user">
              <a data-toggle="collapse" href="#collapseOP" aria-expanded="false" aria-controls="collapseOP"><img src="<?php echo BASE_URL_ORIG.basename(JAK_FILES_DIRECTORY).$jakuser->getVar("picture");?>" class="user-image toggle-available<?php if ($jakuser->getVar("available") == 0) { echo ' status-danger'; } elseif ($jakuser->getVar("available") == 2) { echo ' status-warning'; }?>" alt="user image"></a>
              <div class="user-info">
                <?php echo $jakuser->getVar("name");?>
              </div>
              <div class="user-extra">
                <a href="javascript:void(0)" id="sound_alert" onclick="toggleAlert()" class="btn btn-secondary btn-sm<?php echo ($jakuser->getVar("sound") ? ' btn-active' : ' btn-spacer');?>" title="<?php echo $jkl["h8"];?>"><i class="fa fa-volume-<?php echo ($jakuser->getVar("sound") ? 'up' : 'off');?>"></i></a> <a href="javascript:void(0)" id="push_alert" onclick="togglePush()" class="btn btn-secondary btn-sm btn-spacer<?php echo ($jakuser->getVar("push_notifications") ? ' btn-active' : '');?>" title="<?php echo $jkl["u16"];?>"><i class="fa fa-mobile"></i></a>
                <?php if ($jakuser->getVar("operatorchatpublic") == 1){;?> <a href="javascript:void(0)" class="btn btn-secondary btn-sm" id="operator_chat" title="<?php echo $jkl["h9"];?>" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 && window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('<?php echo JAK_rewrite::jakParseurl('chat');?>', 'lsr', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,width=800,height=520,resizable=1');this.newWindow.focus();this.newWindow.opener=window;return false;"><i class="fa fa-comments"></i></a><?php } ?>
              </div>
        </div>

        <div class="collapse" id="collapseOP">
          <ul class="sidebar-menu-status">
            <li><a href="javascript:void(0)" onclick="toggleAvailable(1,<?php echo $JAK_UONLINE;?>)"><i class="fa fa-circle text-success"></i> <?php echo $jkl["g"];?></a></li>
            <li><a href="javascript:void(0)" onclick="toggleAvailable(2,<?php echo $JAK_UONLINE;?>)"><i class="fa fa-circle text-warning"></i> <?php echo $jkl["g202"];?></a></li>
            <li><a href="javascript:void(0)" onclick="toggleAvailable(0,0)"><i class="fa fa-circle text-danger"></i> <?php echo $jkl["g1"];?></a></li>
          </ul>
        </div>

        <div id="transfer"></div>

        <h3 class="chat-queue"><i class="fa fa-comments-o"></i> <?php echo $jkl["g5"];?> <span id="totalchats" class="badge badge-info"></span></h3>
        <div id="currentConv" class="list-group"></div>

        <?php if ($jakuser->getVar("operatorlist") || $jakuser->getVar("operatorchat")){?>
        <h3 class="chat-queue"><i class="fa fa-user-secret"></i> <?php echo $jkl["g134"];?></h3>
        <div id="operatorOnline" class="list-group"></div>
        <?php } ?>
      </section>
      <section class="navbar">
        <div class="jaklogo">
          <a href="<?php echo BASE_URL;?>" class="nav-help-right" title="<?php echo $jkl["m"];?>"><span class="logo-sprite"></span></a>
        </div>
        <?php include_once 'navbar.php';?>
      </section>
      <?php if (isset($jakhs['copyright']) && !empty($jakhs['copyright'])) echo '<div class="copyright text-center">'.$jakhs['copyright'].'</div>';?>
  </div>
  <div canvas="container">

  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h2><a href="#" class="main-sidebar-toggle d-md-none"><i class="fa fa-bars"></i></a> <?php echo $SECTION_TITLE;?>
      <small><?php echo $SECTION_DESC;?></small>
    </h2>
    <?php if ($page != 'live') { ?>
    <div class="pull-right">
      <?php if ($page == '' && ($jakhs['hostactive'] == 1 && !empty(JAKDB_MAIN_NAME) || jak_get_access("maintenance", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS))) { ?>
      <div class="user-tickets">
        <a href="<?php echo ($jakhs['hostactive'] == 1 && !empty(JAKDB_MAIN_NAME) ? JAK_rewrite::jakParseurl('tickets') : JAK_rewrite::jakParseurl('maintenance', 'check'));?>"><i class="fa fa-bell-o"></i></a>
         <?php if ($jakhs['hostactive'] == 1 && isset($count) && $count != 0) echo '<span class="badge badge-pill badge-danger">'.$count.'</span>';?>
      </div>
      <?php } ?>
      <div class="user-profile">
        <a href="<?php echo JAK_rewrite::jakParseurl('users','edit',JAK_USERID);?>"><img src="<?php echo BASE_URL_ORIG.basename(JAK_FILES_DIRECTORY).$jakuser->getVar("picture");?>" class="user-image toggle-available<?php if ($jakuser->getVar("available") == 0) { echo ' status-danger'; } elseif ($jakuser->getVar("available") == 2) { echo ' status-warning'; }?>" alt="user image"> <?php echo $jakuser->getVar("name");?></a>
      </div>
    </div>
    <div class="clearfix"></div>
    <?php } ?>
  </section>
  
  <!-- Main content -->
  <section class="content">

    <!-- Show the user that the connection to the server has been interrupted -->
    <div class="alert alert-danger" id="connection-error" style="display:none"><i class="fa fa-exclamation-triangle"></i> <?php echo $jkl["g330"];?></div>
<?php } else { ?>
<div class="row">
  <div class="col-md-12">
<?php } ?>