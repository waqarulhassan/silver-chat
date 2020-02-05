<div class="navbar navbar-default">
	<div class="container">
    	<div class="navbar-header">
        	<a class="navbar-brand" href="<?php echo $_SERVER['REQUEST_URI'];?>"><?php echo $jkl["g85"];?> - <?php echo JAK_TITLE;?></a>
    	</div>
	</div>
</div>

<!--- Container -->
<div class="container">

	<div class="jrc_chat_form">
		
		<?php if ($errors) { ?>
		<div class="alert alert-danger"><?php if (isset($errors["name"])) echo $errors["name"]; if (isset($errors["email"])) echo $errors["email"]; if (isset($errors["phone"])) echo $errors["phone"];?></div>
		<?php } ?>
		
		<form class="jak-ajaxform" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
		
			<?php if ($jakwidget['show_avatar']) { ?>
		    <div class="container avatars">
		      <div class="row text-center py-1 mb-3">
		        <div class="col-2 tooltipwrap">
		              <label>
		                <span class="tooltip"><?php echo $jkl["g18"];?></span>
		                  <input type="radio" name="avatar" value="/package/modern/avatar/standard.jpg"<?php if (isset($_SESSION['jrc_avatar']) && $_SESSION['jrc_avatar'] == "/package/modern/avatar/standard.jpg") echo ' checked';?>>
		                  <img src="<?php echo BASE_URL;?>/package/modern/avatar/standard.jpg" class="rounded img-fluid" alt="avatar">
		                </label>
		            </div>
		            <div class="col-2">
		              <label>
		                  <input type="radio" name="avatar" value="/package/modern/avatar/4.jpg"<?php if (isset($_SESSION['jrc_avatar']) && $_SESSION['jrc_avatar'] == "/package/modern/avatar/4.jpg") echo ' checked';?>>
		                  <img src="<?php echo BASE_URL;?>/package/modern/avatar/4.jpg" class="rounded img-fluid" alt="avatar">
		                </label>
		            </div>
		            <div class="col-2">
		              <label>
		                  <input type="radio" name="avatar" value="/package/modern/avatar/2.jpg"<?php if (isset($_SESSION['jrc_avatar']) && $_SESSION['jrc_avatar'] == "/package/modern/avatar/2.jpg") echo ' checked';?>>
		                  <img src="<?php echo BASE_URL;?>/package/modern/avatar/2.jpg" class="rounded img-fluid" alt="avatar">
		                </label>
		            </div>
		            <div class="col-2">
		              <label>
		                  <input type="radio" name="avatar" value="/package/modern/avatar/5.jpg"<?php if (isset($_SESSION['jrc_avatar']) && $_SESSION['jrc_avatar'] == "/package/modern/avatar/5.jpg") echo ' checked';?>>
		                  <img src="<?php echo BASE_URL;?>/package/modern/avatar/5.jpg" class="rounded img-fluid" alt="avatar">
		                </label>
		            </div>
		            <div class="col-2">
		              <label>
		                  <input type="radio" name="avatar" value="/package/modern/avatar/3.jpg"<?php if (isset($_SESSION['jrc_avatar']) && $_SESSION['jrc_avatar'] == "/package/modern/avatar/3.jpg") echo ' checked';?>>
		                  <img src="<?php echo BASE_URL;?>/package/modern/avatar/3.jpg" class="rounded img-fluid" alt="avatar">
		                </label>
		            </div>
		            <div class="col-2">
		              <label>
		                  <input type="radio" name="avatar" value="/package/modern/avatar/1.jpg"<?php if (isset($_SESSION['jrc_avatar']) && $_SESSION['jrc_avatar'] == "/package/modern/avatar/1.jpg") echo ' checked';?>>
		                  <img src="<?php echo BASE_URL;?>/package/modern/avatar/1.jpg" class="rounded img-fluid" alt="avatar">
		                </label>
		            </div>
		      </div>
		  </div>
		  <?php } ?>

		   		<div class="form-group">
		            <label for="name"><?php echo $jkl["g4"];?></label>
		           	<input type="text" name="name" id="name" class="form-control modern" value="<?php if (isset($_SESSION['jrc_name'])) echo $_SESSION['jrc_name'];?>" placeholder="<?php echo $jkl["g4"];?>">
		        </div>
		        <div class="form-group">
		            <label for="email"><?php echo $jkl["g5"];?></label>
		            <input type="<?php if ($jakwidget['client_email']) { echo 'email'; } else { echo 'text';}?>" name="email" id="email" class="form-control modern" value="<?php if (isset($_SESSION['jrc_email'])) echo $_SESSION['jrc_email'];?>" placeholder="<?php echo $jkl["g5"];?>">
		        </div>
		        <div class="form-group">
		            <label for="phone"><?php echo $jkl["g49"];?></label>
		            <input type="tel" name="phone" id="phone" class="form-control modern" value="<?php if (isset($_SESSION['jrc_phone'])) echo $_SESSION["jrc_phone"];?>" placeholder="<?php echo $jkl["g49"];?>">
		        </div>
		      
		      <button type="submit" class="btn btn-block btn-dark ls-submit"><?php echo $jkl["g86"];?></button>
		      <input type="hidden" name="edit_profile" value="1">
		  </form>

		<?php if (isset($jakhs['copyright']) && !empty($jakhs['copyright'])) echo '<div class="copyright text-center">'.$jakhs['copyright'].'</div>';?>
	</div>
</div>