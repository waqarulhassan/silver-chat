<div class="modal-header">
	<h4 class="modal-title"><?php echo $jkl["stat_s12"];?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
</div>
<div class="modal-body">

    	<?php if (isset($USER_FEEDBACK) && !empty($USER_FEEDBACK) && is_array($USER_FEEDBACK)) { ?>
    	
    	<div class="box box-primary">
    		<div class="box-header">
    			<h3 class="box-title"><?php echo $jkl["g81"].' '.$page3;?></h3>
    	  	</div><!-- /.box-header -->
    	  	<div class="box-body">
				<div class="padded-box">
				
				<ul class="list-group">
				<?php $count = 0; foreach($USER_FEEDBACK as $v) {
				
					if (JAK_SUPERADMINACCESS) {
					
						echo '<div class="box box-info" id="stat'.$v['id'].'">
						  <div class="box-header with-border">
						    <h3 class="box-title">'.$v['time'].' - '.$jkl['g86'].'</h3>
						    <div class="box-tools pull-right">
						      <button class="btn btn-box-tool delete-stat" id="'.$v['id'].'" onclick="if(!confirm(\''.$jkl["e30"].'\'))return false;"><i class="fa fa-times"></i></button>
						    </div>
						  </div>
						  <div class="box-body">
						    <span class="usr_rate">'.$jkl['g85'].': </span>'.$v['vote'].'/5<br />'.$jkl['g54'].': '.$v['name'].'<br />'.$jkl['l5'].': '.$v['email'].'<br />'.$jkl['stat_s12'].': '.$v['comment'].'<br />'.$jkl['g87'].': '.gmdate('H:i:s', $v['support_time']).'
						  </div>
						</div>';
					
					} else {
					
						echo '<div class="box box-info" id="stat'.$v['id'].'">
						  <div class="box-header with-border">
						    <h3 class="box-title">'.$v['time'].' - '.$jkl['g86'].'</h3>
						  </div>
						  <div class="box-body">
						    <span class="usr_rate">'.$jkl['g85'].': </span>'.$v['vote'].'/5<br />'.$jkl['g54'].': '.$v['name'].'<br />'.$jkl['l5'].': '.$v['email'].'<br />'.$jkl['stat_s12'].': '.$v['comment'].'<br />'.$jkl['g87'].': '.gmdate('H:i:s', $v['support_time']).'
						  </div>
						</div>';
					
					}
					
					$count++;
				    
				}?>
				</ul>
				
			</div>
		</div>
			
			<div class="box-footer">

				<?php if (isset($USER_FEEDBACK) && !empty($USER_FEEDBACK) && is_array($USER_FEEDBACK)) { ?>
				
				<h4><?php echo $jkl["g89"];?></h4>
				<p><?php echo '<strong>'.$jkl["g90"].':</strong> '.gmdate('H:i:s', $USER_SUPPORTT).'<br /><strong>'.$jkl["g91"].':</strong> '.round(($USER_VOTES / $count), 2);?>/5</p>
				
				
				
				<div class="jak-thankyou"></div>
				
				<form role="form" class="jak-ajaxform" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
				
					<div class="form-group">
					    <label class="control-label" for="email"><?php echo $jkl["g93"];?></label>
						<input type="text" name="email" id="email" class="form-control" placeholder="<?php echo $jkl["g68"];?>" />
					</div>
					
					<button type="submit" id="formsubmit" class="btn btn-primary pull-right ls-submit"><?php echo $jkl["g4"];?></button>
					
					<input type="hidden" name="email_feedback" value="1" />
					<input type="hidden" name="convid" value="<?php echo $page2;?>">
				</form>
				
				
				<?php } ?>

				</div>

		<?php } else { ?>

			<div class="alert alert-info">
				<?php echo $jkl['i3'];?>
			</div>

		<?php } ?>
		</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $jkl["g180"];?></button>
</div>

<?php if (isset($USER_FEEDBACK) && !empty($USER_FEEDBACK) && is_array($USER_FEEDBACK)) { ?>

<script type="text/javascript" src="../js/contact.js"></script>

<script type="text/javascript">
	ls.main_url = "<?php echo BASE_URL;?>";
	ls.lsrequest_uri = "<?php echo JAK_PARSE_REQUEST;?>";
	ls.ls_submit = "<?php echo $jkl['g4'];?>";
	ls.ls_submitwait = "<?php echo $jkl['g67'];?>";
	
	
	<?php if (JAK_SUPERADMINACCESS) { ?>
	
		$('.delete-stat').click(function() {
		
			var sid = $(this).attr('id');
			
			var request = $.ajax({
			  url:  'ajax/oprequests.php',
			  type: "POST",
			  data: "oprq=delstat&sid="+sid+"&uid="+ls.opid,
			  dataType: "json",
			  cache: false
			});
			
			request.done(function(msg) {
				
				if (msg.status) {
					$("#stat"+sid).fadeOut();
				} else {
					alert("<?php echo $jkl["not"];?>");
				}
			});
			
		});
	
	<?php } ?>
	
</script>
<?php } ?>