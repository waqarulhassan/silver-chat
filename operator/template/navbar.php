<ul class="sidebar-menu">
<li<?php if ($page == 'uonline') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('uonline');?>" class="nav-help-right" title="<?php echo $jkl["g122"];?>"><i class="fa fa-eye"></i></a></li>
<?php if (jak_get_access("leads", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){?>
<li<?php if ($page == 'leads') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('leads');?>" class="nav-help-right" title="<?php echo $jkl["m1"];?>"><i class="fa fa-comments-o"></i></a></li>
<?php } if (jak_get_access("off_all", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){?>
<li<?php if ($page == 'contacts') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('contacts');?>" class="nav-help-right" title="<?php echo $jkl["m22"];?>"><i class="fa fa-commenting"></i></a></li>
<?php } if (jak_get_access("ochat", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){?>
<li<?php if ($page == 'chats') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('chats');?>" class="nav-help-right" title="<?php echo $jkl["m14"];?>"><i class="fa fa-comments"></i></a></li>
<?php } if (jak_get_access("files", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){?>
<li<?php if ($page == 'files') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('files');?>" class="nav-help-right" title="<?php echo $jkl["m2"];?>"><i class="fa fa-files-o"></i></a></li>
<?php } if (jak_get_access("responses", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){?>
<li<?php if ($page == 'response') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('response');?>" class="nav-help-right" title="<?php echo $jkl["m3"];?>"><i class="fa fa-comment"></i></a></li>
<?php } if (jak_get_access("proactive", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){?>
<li<?php if ($page == 'proactive') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('proactive');?>" class="nav-help-right" title="<?php echo $jkl["m18"];?>"><i class="fa fa-bolt"></i></a></li>
<?php } if (jak_get_access("proactive", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){?>
<li<?php if ($page == 'bot') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('bot');?>" class="nav-help-right" title="<?php echo $jkl["m23"];?>"><i class="fa fa-android"></i></a></li>
<?php } if (jak_get_access("departments", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){?>
<li<?php if ($page == 'departments') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('departments');?>" class="nav-help-right" title="<?php echo $jkl["m9"];?>"><i class="fa fa-university"></i></a></li>
<?php } if (jak_get_access("answers", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){?>
<li<?php if ($page == 'answers') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('answers');?>" class="nav-help-right" title="<?php echo $jkl["m20"];?>"><i class="fa fa-pencil"></i></a></li>
<?php } ?>
<li<?php if ($page == 'users') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('users');?>" class="nav-help-right" title="<?php echo $jkl["m4"];?>"><i class="fa fa-user-circle"></i></a></li>
<?php if (jak_get_access("statistic", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){?>
<li<?php if ($page == 'statistics') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('statistics');?>" class="nav-help-right" title="<?php echo $jkl["m10"];?>"><i class="fa fa-area-chart"></i></a></li>
<?php } if (jak_get_access("widget", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){?>
<li<?php if ($page == 'widget') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('widget');?>" class="nav-help-right" title="<?php echo $jkl["m26"];?>"><i class="fa fa-code"></i></a></li>
<?php } if ((($jakhs['hostactive'] == 1 && $jakhs['groupchat'] == 1) || $jakhs['hostactive'] == 0) && jak_get_access("groupchat", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){?>
<li<?php if ($page == 'groupchat') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('groupchat');?>" class="nav-help-right" title="<?php echo $jkl["m29"];?>"><i class="fa fa-users"></i></a></li>
<?php } if (JAK_SUPERADMINACCESS){?>
<li<?php if ($page == 'buttons') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('buttons');?>" class="nav-help-right" title="<?php echo $jkl["g71"];?>"><i class="fa fa-magic"></i></a></li>
<?php } if (jak_get_access("blacklist", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){?>
<li<?php if ($page == 'blacklist') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('blacklist');?>" class="nav-help-right" title="<?php echo $jkl["m27"];?>"><i class="fa fa-list-alt"></i></a></li>
<?php } if (jak_get_access("settings", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS) || jak_get_access("blocklist", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){;?>
<li<?php if ($page == 'settings') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('settings');?>" class="nav-help-right" title="<?php echo $jkl["m5"];?>"><i class="fa fa-cog"></i></a></li>
<?php } if (jak_get_access("maintenance", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){?>
<li<?php if ($page == 'maintenance') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('maintenance');?>" class="nav-help-right" title="<?php echo $jkl["m19"];?>"><i class="fa fa-wrench"></i></a></li>
<?php } if (jak_get_access("logs", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)){?>
<li<?php if ($page == 'logs') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('logs');?>" class="nav-help-right" title="<?php echo $jkl["m6"];?>"><i class="fa fa-line-chart"></i></a></li>
<?php } if ($jakhs['hostactive'] == 1 && !empty(JAKDB_MAIN_NAME)) { ?>
<li<?php if ($page == 'tickets') echo ' class="active"';?>><a href="<?php echo JAK_rewrite::jakParseurl('tickets');?>" class="nav-help-right" title="<?php echo $jkl["m31"];?>"><i class="fa fa-ticket"></i></a></li>
<?php } ?>
<li><a href="<?php echo JAK_rewrite::jakParseurl('logout');?>" class="btn-confirm nav-help-right" data-title="<?php echo addslashes($jkl["l18"]);?>" data-text="<?php echo addslashes($jkl["l20"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>" title="<?php echo $jkl["l18"];?>"><i class="fa fa-sign-out"></i></a></li>
</ul>