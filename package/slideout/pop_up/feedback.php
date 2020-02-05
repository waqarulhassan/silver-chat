<div class="navbar navbar-default">
	<div class="container">
    	<div class="navbar-header">
        	<a class="navbar-brand" href="<?php echo $_SERVER['REQUEST_URI'];?>"><?php echo $jkl["g"];?> - <?php echo JAK_TITLE;?></a>
    	</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php echo $headermsg;?>
		</div>
	</div>
	<hr>
	<div class="jrc_chat_form">
			
		<?php if ($errors) { ?>
			<div class="alert alert-danger"><?php if (isset($errors["name"])) echo $errors["name"]; if (isset($errors["email"])) echo $errors["email"];?></div>
		<?php } ?>
		
		<div class="jak-thankyou"></div>
				
		<!--- Chat Rating -->
		<form role="form" class="jak-ajaxform" action="<?php echo htmlentities($_SERVER['REQUEST_URI']);?>" method="post">
			<?php if (JAK_CRATING) { ?>
					<div class="form-group">
					    <label class="control-label" for="vote5"><?php echo $jkl["g23"];?></label>
					    	<div id="star-container">
					    		<i class="fa fa-thumbs-down fa-2x updown" id="updown-1"></i>
								<i class="fa fa-thumbs-up fa-2x updown thumb-up" id="updown-2"></i>
					    	</div>
					    	<input type="hidden" name="fbvote" id="fbvote" value="5">
					</div>
			<?php } ?>
					
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label class="control-label" for="name"><?php echo $jkl["g4"];?></label>
						<input type="text" name="name" id="name" class="form-control" value="<?php if (isset($_SESSION['jrc_name'])) echo $_SESSION['jrc_name'];?>">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label class="control-label" for="email"><?php echo $jkl["g5"];?></label>
						<input type="email" name="email" id="email" class="form-control" value="<?php if (isset($_SESSION['jrc_email'])) echo $_SESSION['jrc_email'];?>">
					</div>
				</div>
			</div>
					
					<div class="form-group">
					    <label class="control-label" for="feedback"><?php echo $jkl["g24"];?></label>
					    <textarea name="message" id="feedback" rows="5" class="form-control"></textarea>
					</div>
					
					<?php if (JAK_SEND_TSCRIPT == 1) { ?>
					
					<div class="checkbox">
						<label>
					      <input type="checkbox" name="send_email" id="send_email"> <?php echo $jkl["g38"];?>
						</label>
					</div>
					
					<?php } else { ?>
						<input type="hidden" name="send_email" value="0">
					<?php } ?>
					
					<div class="form-actions">
						<button type="submit" class="btn btn-primary btn-block ls-submit"><?php echo $jkl["g25"];?></button>
					</div>
					
					<input type="hidden" name="convid" value="<?php echo $fb[0];?>" />
					<input type="hidden" name="send_feedback" value="1">
				
			</form>

			<?php if (isset($jakhs['copyright']) && !empty($jakhs['copyright'])) echo '<div class="copyright text-center">'.$jakhs['copyright'].'</div>';?>
			
		</div>
</div>