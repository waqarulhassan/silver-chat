<?php include "header.php";?>

<div class="login-wrapper">

<div class="login-title">
	<h1><?php echo JAK_TITLE;?></h1>
</div>

<div class="form-signin">

<div class="loginF">
<?php if (isset($ErrLogin)) { ?>
<div class="alert alert-danger lost-pwd">
<?php echo $jkl["f"];?>
</div>
<?php } ?>
<form id="login_form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
  <div class="form-group">
    <input type="text" name="username" class="form-control<?php if (isset($ErrLogin)) echo " is-invalid";?>" id="username" placeholder="<?php echo $jkl["l1"].' / '.$jkl["l5"];?>">
  </div>
  <div class="form-group">
    <input type="password" name="password" class="form-control<?php if (isset($ErrLogin)) echo " is-invalid";?>" id="password" placeholder="<?php echo $jkl["l2"];?>">
  </div>

  <input type="hidden" name="action" value="login">
  <button type="submit" name="logID" class="btn btn-block btn-success"><?php echo $jkl["l3"];?> <span class="rocket-sprite"></span></button>

  <div class="form-check">
    <label class="form-check-label">
      <input class="form-check-input" type="checkbox" name="lcookies"> <?php echo $jkl["l4"];?>
    </label>
  </div>
</form>

</div>

<div class="forgotP">
<h4><?php echo $jkl["l13"];?></h4>
<?php if (isset($errorfp)) { ?><div class="alert alert-danger"><?php echo $errorfp["e"];?></div><?php } ?>
<form role="form" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
<div class="form-group">
	<label for="email" class="sr-only"><?php echo $jkl["l5"];?></label>
  	<input type="text" name="lsE" class="form-control<?php if (isset($errorfp)) echo " is-invalid";?>" id="email" placeholder="<?php echo $jkl["l5"];?>">
</div>
<button type="submit" name="forgotP" class="btn btn-info btn-block"><?php echo $jkl["g94"];?></button>
</form>
<hr>
<div class="btn btn-warning btn-block lost-pwd"><i class="fa fa-lightbulb-o"></i> <?php echo $jkl["g3"];?></div>
</div>

<?php if (isset($jakhs['copyright']) && !empty($jakhs['copyright'])) echo '<div class="copyright text-center">'.$jakhs['copyright'].'</div>';?>
  
</div>

</div>

<div class="moonspace"><img src="<?php echo BASE_URL;?>img/astroowls.png" class="img-fluid" alt="moon and space"></div>

<?php include "footer.php";?>