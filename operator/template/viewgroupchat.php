<?php include_once 'header.php';?>

<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $JAK_FORM_DATA["title"];?></h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<!-- chat output -->
		<div class="chat-wrapper">
			<div class="direct-chat-messages" style="height:500px;overflow-y:auto;"><?php echo $chatmsg;?></div>
		</div>
	</div>
	<div class="box-footer">
		<a href="<?php echo JAK_rewrite::jakParseurl('groupchat', 'edit', $datagc["groupchatid"]);?>" class="btn btn-default"><?php echo $jkl["g103"];?></a>
	</div>
</div>

<?php include_once 'footer.php';?>