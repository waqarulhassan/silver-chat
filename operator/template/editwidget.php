<?php include_once 'header.php';?>

<?php if ($errors) { ?>
<div class="alert alert-danger">
<?php if (isset($errors["e"])) echo $errors["e"];
	  if (isset($errors["e1"])) echo $errors["e1"];?>
</div>
<?php } ?>

<form class="jak_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

<p><?php echo $jkl['bw1'];?> <a href="javascript:void(0)" data-clipboard-target="#widget-code" class="btn btn-primary btn-sm clipboard"><i class="fa fa-clipboard"></i></a></p>
<div class="row">
	<div class="col-md-8">
		<div class="card border-success text-center">
		  <div class="card-body">
			<textarea rows="11" class="form-control" id="widget-code" readonly="readonly"><?php echo htmlentities('<!-- live chat 3 widget -->
<script type="text/javascript">
	(function(w, d, s, u) {
		w.id = '.$page2.'; w.lang = \'\'; w.cName = \'\'; w.cEmail = \'\'; w.cMessage = \'\'; w.lcjUrl = u;
		var h = d.getElementsByTagName(s)[0], j = d.createElement(s);
		j.async = true; j.src = \''.BASE_URL_ORIG.'js/jaklcpchat.js\';
		h.parentNode.insertBefore(j, h);
	})(window, document, \'script\', \''.BASE_URL_ORIG.'\');
</script>
<div id="jaklcp-chat-container"></div>
<!-- end live chat 3 widget -->');?></textarea>
			</div>
		</div>
		<hr>
		<p><?php echo $jkl['g301'];?> <a href="javascript:void(0)" data-clipboard-target="#marketing-code" class="btn btn-primary btn-sm clipboard"><i class="fa fa-clipboard"></i></a></p>
		<div class="card border-success text-center mb-3">
		  	<div class="card-body" id="marketing-code">
				<?php echo htmlentities('<a href="'.str_replace(JAK_OPERATOR_LOC."/", "", JAK_rewrite::jakParseurl('link', $page2, $JAK_FORM_DATA["lang"])).'">'.$jkl['g302'].'</a>');?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card border-info text-center">
			<div class="card-body">
				<div id="chat_preview" style="min-height: 180px">
					<div id="chat_preview_slide"><?php echo $jakgraphix["widgetpreview"];?></div>
				</div>

			</div>
		</div>
		<div class="clearfix"></div>
		<?php if (isset($jakgraphix["headfont"]) && $jakgraphix["headfont"] === true) { ?>
		<hr>
		<div class="row">
			<div class="col-sm-6">
				<input type="text" class="form-control" name="jak_sucolor" id="sumcolor" value="<?php echo $JAK_FORM_DATA["sucolor"];?>">
			</div>
			<div class="col-sm-6">
				<input type="text" class="form-control" name="jak_sutcolor" id="sumtcolor" value="<?php echo $JAK_FORM_DATA["sutcolor"];?>">
			</div>
		</div>
		<?php } else { ?>
		<input type="hidden" value="<?php echo $JAK_FORM_DATA["sucolor"];?>" name="jak_sucolor">
		<input type="hidden" value="<?php echo $JAK_FORM_DATA["sutcolor"];?>" name="jak_sutcolor">
		<?php } ?>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title"><?php echo $jkl["g47"];?></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<div class="table-responsive">
		<table class="table table-striped">
		<tr>
			<td>
			<div class="form-group">
				<label for="title"><?php echo $jkl["g16"];?></label>
				<input type="text" name="title" id="title" class="form-control<?php if (isset($errors["e"])) echo " is-invalid";?>" value="<?php echo $JAK_FORM_DATA["title"];?>" />
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label for="whatsapp_msg"><?php echo $jkl["u56"];?></label>
				<input type="text" name="whatsapp_msg" id="whatsapp_msg" class="form-control" value="<?php echo $JAK_FORM_DATA["whatsapp_message"];?>" />
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="department"><?php echo $jkl["g131"];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h6"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></label>
				<select name="jak_depid[]" id="department" class="form-control" multiple="multiple">
			
				<option value="0"<?php if ($JAK_FORM_DATA["depid"] == 0) echo ' selected="selected"';?>><?php echo $jkl["g105"];?></option>
				<?php if (isset($JAK_DEPARTMENTS) && is_array($JAK_DEPARTMENTS)) foreach($JAK_DEPARTMENTS as $z) { ?>
				
				<option value="<?php echo $z["id"];?>"<?php if (in_array($z["id"], explode(',', $JAK_FORM_DATA["depid"]))) echo ' selected';?>><?php echo $z["title"];?></option>
			
				<?php } ?>
			
				</select>
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="operator"><?php echo $jkl["g130"];?></label>
				<select name="jak_opid" id="operator" class="form-control">
							
					<option value="0"<?php if ($JAK_FORM_DATA["opid"] == 0) echo ' selected="selected"';?>><?php echo $jkl["g105"];?></option>
					<?php if (isset($JAK_OPERATORS) && is_array($JAK_OPERATORS)) foreach($JAK_OPERATORS as $o) { ?>
							
					<option value="<?php echo $o["id"];?>"<?php if ($JAK_FORM_DATA["opid"] == $o["id"]) echo ' selected="selected"';?>><?php echo $o["username"];?></option>
							
					<?php } ?>
							
				</select>
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="jak_lang"><?php echo $jkl["g22"];?></label>
				<select name="jak_lang" class="form-control">
				<?php if (isset($lang_files) && is_array($lang_files)) foreach($lang_files as $lf) { ?>
					<option value="<?php echo $lf;?>"<?php if ($JAK_FORM_DATA["lang"] == $lf) { ?> selected="selected"<?php } ?>><?php echo ucwords($lf);?></option><?php } ?>
				</select>
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="jak_feedback"><?php echo $jkl["stat_s12"];?></label>
				<div class="radio"><label><input type="radio" name="jak_feedback" id="jak_feedback" value="1"<?php if ($JAK_FORM_DATA["feedback"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_feedback" value="0"<?php if ($JAK_FORM_DATA["feedback"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div>
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="redirect_active"><?php echo $jkl["g190"];?></label>
				<div class="radio"><label><input type="radio" name="redirect_active" id="redirect_active" value="1"<?php if ($JAK_FORM_DATA["redirect_active"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
				<div class="radio"><label><input type="radio" name="redirect_active" value="0"<?php if ($JAK_FORM_DATA["redirect_active"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div>
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="url_red"><?php echo $jkl["g238"];?></label>
				<input type="text" name="url_red" id="url_red" class="form-control" value="<?php echo $JAK_FORM_DATA["redirect_url"];?>" placeholder="https://www.yourdomain.com/contactform">
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="jak_redi_contact"><?php echo $jkl["g252"];?></label>
				<input type="number" name="jak_redi_contact" id="jak_redi_contact" class="form-control" min="1" max="30" step="1" value="<?php echo $JAK_FORM_DATA["redirect_after"];?>">
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="jak_dsgvo">EU-DSGVO</label>
				<textarea name="jak_dsgvo" id="jak_dsgvo" class="form-control" rows="3"><?php echo $JAK_FORM_DATA["dsgvo"];?></textarea>
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="jak_whitelist"><?php echo $jkl["g325"];?></label>
				<textarea class="form-control" rows="3" name="jak_whitelist" placeholder="https://www.crossdomain.com"><?php if (isset($JAK_FORM_DATA["widget_whitelist"])) echo $JAK_FORM_DATA["widget_whitelist"];?></textarea>
			</div>
			</td>
		</tr>

		</table>
		</div>
		</div>
		<div class="box-footer">
			<a href="<?php echo JAK_rewrite::jakParseurl('widget');?>" class="btn btn-default"><?php echo $jkl["g103"];?></a>
			<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
		</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title"><?php echo $jkl["bw"];?></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<div class="table-responsive">
		<table class="table table-striped">
		<tr>
			<td>
			<select name="jak_widget" class="form-control" onchange="this.form.submit()">
				<?php if (isset($jakgraphix["buttonoptions"]) && is_array($jakgraphix["buttonoptions"])) foreach($jakgraphix["buttonoptions"] as $k => $v) { ?>
				<option value="<?php echo $k;?>"<?php if ($JAK_FORM_DATA["widget"] == $k) { ?> selected="selected"<?php } ?>><?php echo $v;?></option>
				<?php } ?>
			</select>
			</td>
		</tr>
		<tr>
			<td>
				<div class="form-check">
				  <input class="form-check-input" type="checkbox" name="jak_hide" id="jak_hide" value="1"<?php if ($JAK_FORM_DATA["hideoff"] == 1) echo ' checked';?>>
				  <label class="form-check-label" for="jak_hide">
				    <?php echo $jkl["chato"];?>
				  </label>
				</div>

				<div class="form-check">
				  <input class="form-check-input" type="checkbox" name="jak_float" id="jak_float" value="1"<?php if ($JAK_FORM_DATA["floatpopup"] == 1) echo ' checked';?>>
				  <label class="form-check-label" for="jak_float">
				    <?php echo $jkl["float"];?>
				  </label>
				</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="jak_floatcss"><?php echo $jkl["bw9"];?></label>
				<input type="text" class="form-control" name="jak_floatcss" value="<?php if (isset($JAK_FORM_DATA["floatcss"])) echo $JAK_FORM_DATA["floatcss"];?>" placeholder="top:20px;right:20px">
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="jak_btnanimation"><?php echo $jkl['bw2'];?></label>
				<select name="jak_btnanimation" class="form-control">
					<option value=""<?php if ($JAK_FORM_DATA["btn_animation"] == "") echo ' selected';?>><?php echo $jkl['bw'];?></option>
					<optgroup label="Attention Seekers">
			          <option value="bounce"<?php if ($JAK_FORM_DATA["btn_animation"] == "bounce") echo ' selected';?>>bounce</option>
			          <option value="flash"<?php if ($JAK_FORM_DATA["btn_animation"] == "flash") echo ' selected';?>>flash</option>
			          <option value="pulse"<?php if ($JAK_FORM_DATA["btn_animation"] == "pulse") echo ' selected';?>>pulse</option>
			          <option value="rubberBand"<?php if ($JAK_FORM_DATA["btn_animation"] == "rubberBand") echo ' selected';?>>rubberBand</option>
			          <option value="shake"<?php if ($JAK_FORM_DATA["btn_animation"] == "shake") echo ' selected';?>>shake</option>
			          <option value="swing"<?php if ($JAK_FORM_DATA["btn_animation"] == "swing") echo ' selected';?>>swing</option>
			          <option value="tada"<?php if ($JAK_FORM_DATA["btn_animation"] == "tada") echo ' selected';?>>tada</option>
			          <option value="wobble"<?php if ($JAK_FORM_DATA["btn_animation"] == "wobble") echo ' selected';?>>wobble</option>
			          <option value="jello"<?php if ($JAK_FORM_DATA["btn_animation"] == "jello") echo ' selected';?>>jello</option>
			        </optgroup>

			        <optgroup label="Bouncing Entrances">
			          <option value="bounceIn"<?php if ($JAK_FORM_DATA["btn_animation"] == "bounceIn") echo ' selected';?>>bounceIn</option>
			          <option value="bounceInDown"<?php if ($JAK_FORM_DATA["btn_animation"] == "bounceInDown") echo ' selected';?>>bounceInDown</option>
			          <option value="bounceInLeft"<?php if ($JAK_FORM_DATA["btn_animation"] == "bounceInLeft") echo ' selected';?>>bounceInLeft</option>
			          <option value="bounceInRight"<?php if ($JAK_FORM_DATA["btn_animation"] == "bounceInRight") echo ' selected';?>>bounceInRight</option>
			          <option value="bounceInUp"<?php if ($JAK_FORM_DATA["btn_animation"] == "bounceInUp") echo ' selected';?>>bounceInUp</option>
			        </optgroup>

			        <optgroup label="Fading Entrances">
			          <option value="fadeIn"<?php if ($JAK_FORM_DATA["btn_animation"] == "fadeIn") echo ' selected';?>>fadeIn</option>
			          <option value="fadeInDown"<?php if ($JAK_FORM_DATA["btn_animation"] == "fadeInDown") echo ' selected';?>>fadeInDown</option>
			          <option value="fadeInDownBig"<?php if ($JAK_FORM_DATA["btn_animation"] == "fadeInDownBig") echo ' selected';?>>fadeInDownBig</option>
			          <option value="fadeInLeft"<?php if ($JAK_FORM_DATA["btn_animation"] == "fadeInLeft") echo ' selected';?>>fadeInLeft</option>
			          <option value="fadeInLeftBig"<?php if ($JAK_FORM_DATA["btn_animation"] == "fadeInLeftBig") echo ' selected';?>>fadeInLeftBig</option>
			          <option value="fadeInRight"<?php if ($JAK_FORM_DATA["btn_animation"] == "fadeInRight") echo ' selected';?>>fadeInRight</option>
			          <option value="fadeInRightBig"<?php if ($JAK_FORM_DATA["btn_animation"] == "fadeInRightBig") echo ' selected';?>>fadeInRightBig</option>
			          <option value="fadeInUp"<?php if ($JAK_FORM_DATA["btn_animation"] == "fadeInUp") echo ' selected';?>>fadeInUp</option>
			          <option value="fadeInUpBig"<?php if ($JAK_FORM_DATA["btn_animation"] == "fadeInUpBig") echo ' selected';?>>fadeInUpBig</option>
			        </optgroup>

			        <optgroup label="Flippers">
			          <option value="flip"<?php if ($JAK_FORM_DATA["btn_animation"] == "flip") echo ' selected';?>>flip</option>
			          <option value="flipInX"<?php if ($JAK_FORM_DATA["btn_animation"] == "flipInX") echo ' selected';?>>flipInX</option>
			          <option value="flipInY"<?php if ($JAK_FORM_DATA["btn_animation"] == "flipInY") echo ' selected';?>>flipInY</option>
			        </optgroup>

			        <optgroup label="Lightspeed">
			          <option value="lightSpeedIn"<?php if ($JAK_FORM_DATA["btn_animation"] == "lightSpeedIn") echo ' selected';?>>lightSpeedIn</option>
			        </optgroup>

			        <optgroup label="Rotating Entrances">
			          <option value="rotateIn"<?php if ($JAK_FORM_DATA["btn_animation"] == "rotateIn") echo ' selected';?>>rotateIn</option>
			          <option value="rotateInDownLeft"<?php if ($JAK_FORM_DATA["btn_animation"] == "rotateInDownLeft") echo ' selected';?>>rotateInDownLeft</option>
			          <option value="rotateInDownRight"<?php if ($JAK_FORM_DATA["btn_animation"] == "rotateInDownRight") echo ' selected';?>>rotateInDownRight</option>
			          <option value="rotateInUpLeft"<?php if ($JAK_FORM_DATA["btn_animation"] == "rotateInUpLeft") echo ' selected';?>>rotateInUpLeft</option>
			          <option value="rotateInUpRight"<?php if ($JAK_FORM_DATA["btn_animation"] == "rotateInUpRight") echo ' selected';?>>rotateInUpRight</option>
			        </optgroup>

			        <optgroup label="Sliding Entrances">
			          <option value="slideInUp"<?php if ($JAK_FORM_DATA["btn_animation"] == "slideInUp") echo ' selected';?>>slideInUp</option>
			          <option value="slideInDown"<?php if ($JAK_FORM_DATA["btn_animation"] == "slideInDown") echo ' selected';?>>slideInDown</option>
			          <option value="slideInLeft"<?php if ($JAK_FORM_DATA["btn_animation"] == "slideInLeft") echo ' selected';?>>slideInLeft</option>
			          <option value="slideInRight"<?php if ($JAK_FORM_DATA["btn_animation"] == "slideInRight") echo ' selected';?>>slideInRight</option>
			        </optgroup>
			        
			        <optgroup label="Zoom Entrances">
			          <option value="zoomIn"<?php if ($JAK_FORM_DATA["btn_animation"] == "zoomIn") echo ' selected';?>>zoomIn</option>
			          <option value="zoomInDown"<?php if ($JAK_FORM_DATA["btn_animation"] == "zoomInDown") echo ' selected';?>>zoomInDown</option>
			          <option value="zoomInLeft"<?php if ($JAK_FORM_DATA["btn_animation"] == "zoomInLeft") echo ' selected';?>>zoomInLeft</option>
			          <option value="zoomInRight"<?php if ($JAK_FORM_DATA["btn_animation"] == "zoomInRight") echo ' selected';?>>zoomInRight</option>
			          <option value="zoomInUp"<?php if ($JAK_FORM_DATA["btn_animation"] == "zoomInUp") echo ' selected';?>>zoomInUp</option>
			        </optgroup>

			        <optgroup label="Specials">
			          <option value="jackInTheBox"<?php if ($JAK_FORM_DATA["btn_animation"] == "jackInTheBox") echo ' selected';?>>jackInTheBox</option>
			          <option value="rollIn"<?php if ($JAK_FORM_DATA["btn_animation"] == "rollIn") echo ' selected';?>>rollIn</option>
			        </optgroup>
				</select>
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="jak_floatcss"><?php echo $jkl["bw12"];?></label>
				<input type="text" class="form-control" name="jak_floatcsschat" value="<?php if (isset($JAK_FORM_DATA["floatcsschat"])) echo $JAK_FORM_DATA["floatcsschat"];?>" placeholder="top:20px;right:20px">
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="jak_chatanimation"><?php echo $jkl['bw2'];?></label>
				<select name="jak_chatanimation" class="form-control">
					<option value=""<?php if ($JAK_FORM_DATA["chat_animation"] == "") echo ' selected';?>><?php echo $jkl['bw'];?></option>
					<optgroup label="Attention Seekers">
			          <option value="bounce"<?php if ($JAK_FORM_DATA["chat_animation"] == "bounce") echo ' selected';?>>bounce</option>
			          <option value="flash"<?php if ($JAK_FORM_DATA["chat_animation"] == "flash") echo ' selected';?>>flash</option>
			          <option value="pulse"<?php if ($JAK_FORM_DATA["chat_animation"] == "pulse") echo ' selected';?>>pulse</option>
			          <option value="rubberBand"<?php if ($JAK_FORM_DATA["chat_animation"] == "rubberBand") echo ' selected';?>>rubberBand</option>
			          <option value="shake"<?php if ($JAK_FORM_DATA["chat_animation"] == "shake") echo ' selected';?>>shake</option>
			          <option value="swing"<?php if ($JAK_FORM_DATA["chat_animation"] == "swing") echo ' selected';?>>swing</option>
			          <option value="tada"<?php if ($JAK_FORM_DATA["chat_animation"] == "tada") echo ' selected';?>>tada</option>
			          <option value="wobble"<?php if ($JAK_FORM_DATA["chat_animation"] == "wobble") echo ' selected';?>>wobble</option>
			          <option value="jello"<?php if ($JAK_FORM_DATA["chat_animation"] == "jello") echo ' selected';?>>jello</option>
			        </optgroup>

			        <optgroup label="Bouncing Entrances">
			          <option value="bounceIn"<?php if ($JAK_FORM_DATA["chat_animation"] == "bounceIn") echo ' selected';?>>bounceIn</option>
			          <option value="bounceInDown"<?php if ($JAK_FORM_DATA["chat_animation"] == "bounceInDown") echo ' selected';?>>bounceInDown</option>
			          <option value="bounceInLeft"<?php if ($JAK_FORM_DATA["chat_animation"] == "bounceInLeft") echo ' selected';?>>bounceInLeft</option>
			          <option value="bounceInRight"<?php if ($JAK_FORM_DATA["chat_animation"] == "bounceInRight") echo ' selected';?>>bounceInRight</option>
			          <option value="bounceInUp"<?php if ($JAK_FORM_DATA["chat_animation"] == "bounceInUp") echo ' selected';?>>bounceInUp</option>
			        </optgroup>

			        <optgroup label="Fading Entrances">
			          <option value="fadeIn"<?php if ($JAK_FORM_DATA["chat_animation"] == "fadeIn") echo ' selected';?>>fadeIn</option>
			          <option value="fadeInDown"<?php if ($JAK_FORM_DATA["chat_animation"] == "fadeInDown") echo ' selected';?>>fadeInDown</option>
			          <option value="fadeInDownBig"<?php if ($JAK_FORM_DATA["chat_animation"] == "fadeInDownBig") echo ' selected';?>>fadeInDownBig</option>
			          <option value="fadeInLeft"<?php if ($JAK_FORM_DATA["chat_animation"] == "fadeInLeft") echo ' selected';?>>fadeInLeft</option>
			          <option value="fadeInLeftBig"<?php if ($JAK_FORM_DATA["chat_animation"] == "fadeInLeftBig") echo ' selected';?>>fadeInLeftBig</option>
			          <option value="fadeInRight"<?php if ($JAK_FORM_DATA["chat_animation"] == "fadeInRight") echo ' selected';?>>fadeInRight</option>
			          <option value="fadeInRightBig"<?php if ($JAK_FORM_DATA["chat_animation"] == "fadeInRightBig") echo ' selected';?>>fadeInRightBig</option>
			          <option value="fadeInUp"<?php if ($JAK_FORM_DATA["chat_animation"] == "fadeInUp") echo ' selected';?>>fadeInUp</option>
			          <option value="fadeInUpBig"<?php if ($JAK_FORM_DATA["chat_animation"] == "fadeInUpBig") echo ' selected';?>>fadeInUpBig</option>
			        </optgroup>

			        <optgroup label="Flippers">
			          <option value="flip"<?php if ($JAK_FORM_DATA["chat_animation"] == "flip") echo ' selected';?>>flip</option>
			          <option value="flipInX"<?php if ($JAK_FORM_DATA["chat_animation"] == "flipInX") echo ' selected';?>>flipInX</option>
			          <option value="flipInY"<?php if ($JAK_FORM_DATA["chat_animation"] == "flipInY") echo ' selected';?>>flipInY</option>
			        </optgroup>

			        <optgroup label="Lightspeed">
			          <option value="lightSpeedIn"<?php if ($JAK_FORM_DATA["chat_animation"] == "lightSpeedIn") echo ' selected';?>>lightSpeedIn</option>
			        </optgroup>

			        <optgroup label="Rotating Entrances">
			          <option value="rotateIn"<?php if ($JAK_FORM_DATA["chat_animation"] == "rotateIn") echo ' selected';?>>rotateIn</option>
			          <option value="rotateInDownLeft"<?php if ($JAK_FORM_DATA["chat_animation"] == "rotateInDownLeft") echo ' selected';?>>rotateInDownLeft</option>
			          <option value="rotateInDownRight"<?php if ($JAK_FORM_DATA["chat_animation"] == "rotateInDownRight") echo ' selected';?>>rotateInDownRight</option>
			          <option value="rotateInUpLeft"<?php if ($JAK_FORM_DATA["chat_animation"] == "rotateInUpLeft") echo ' selected';?>>rotateInUpLeft</option>
			          <option value="rotateInUpRight"<?php if ($JAK_FORM_DATA["chat_animation"] == "rotateInUpRight") echo ' selected';?>>rotateInUpRight</option>
			        </optgroup>

			        <optgroup label="Sliding Entrances">
			          <option value="slideInUp"<?php if ($JAK_FORM_DATA["chat_animation"] == "slideInUp") echo ' selected';?>>slideInUp</option>
			          <option value="slideInDown"<?php if ($JAK_FORM_DATA["chat_animation"] == "slideInDown") echo ' selected';?>>slideInDown</option>
			          <option value="slideInLeft"<?php if ($JAK_FORM_DATA["chat_animation"] == "slideInLeft") echo ' selected';?>>slideInLeft</option>
			          <option value="slideInRight"<?php if ($JAK_FORM_DATA["chat_animation"] == "slideInRight") echo ' selected';?>>slideInRight</option>
			        </optgroup>
			        
			        <optgroup label="Zoom Entrances">
			          <option value="zoomIn"<?php if ($JAK_FORM_DATA["chat_animation"] == "zoomIn") echo ' selected';?>>zoomIn</option>
			          <option value="zoomInDown"<?php if ($JAK_FORM_DATA["chat_animation"] == "zoomInDown") echo ' selected';?>>zoomInDown</option>
			          <option value="zoomInLeft"<?php if ($JAK_FORM_DATA["chat_animation"] == "zoomInLeft") echo ' selected';?>>zoomInLeft</option>
			          <option value="zoomInRight"<?php if ($JAK_FORM_DATA["chat_animation"] == "zoomInRight") echo ' selected';?>>zoomInRight</option>
			          <option value="zoomInUp"<?php if ($JAK_FORM_DATA["chat_animation"] == "zoomInUp") echo ' selected';?>>zoomInUp</option>
			        </optgroup>

			        <optgroup label="Specials">
			          <option value="jackInTheBox"<?php if ($JAK_FORM_DATA["chat_animation"] == "jackInTheBox") echo ' selected';?>>jackInTheBox</option>
			          <option value="rollIn"<?php if ($JAK_FORM_DATA["chat_animation"] == "rollIn") echo ' selected';?>>rollIn</option>
			        </optgroup>
				</select>
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="jak_engagecss"><?php echo $jkl["bw14"];?></label>
				<input type="text" class="form-control" name="jak_engagecss" value="<?php if (isset($JAK_FORM_DATA["engagecss"])) echo $JAK_FORM_DATA["engagecss"];?>" placeholder="top:20px;right:20px">
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="jak_engageanimation"><?php echo $jkl['bw2'];?></label>
				<select name="jak_engageanimation" class="form-control">
					<option value=""<?php if ($JAK_FORM_DATA["engage_animation"] == "") echo ' selected';?>><?php echo $jkl['bw'];?></option>
					<optgroup label="Attention Seekers">
			          <option value="bounce"<?php if ($JAK_FORM_DATA["engage_animation"] == "bounce") echo ' selected';?>>bounce</option>
			          <option value="flash"<?php if ($JAK_FORM_DATA["engage_animation"] == "flash") echo ' selected';?>>flash</option>
			          <option value="pulse"<?php if ($JAK_FORM_DATA["engage_animation"] == "pulse") echo ' selected';?>>pulse</option>
			          <option value="rubberBand"<?php if ($JAK_FORM_DATA["engage_animation"] == "rubberBand") echo ' selected';?>>rubberBand</option>
			          <option value="shake"<?php if ($JAK_FORM_DATA["engage_animation"] == "shake") echo ' selected';?>>shake</option>
			          <option value="swing"<?php if ($JAK_FORM_DATA["engage_animation"] == "swing") echo ' selected';?>>swing</option>
			          <option value="tada"<?php if ($JAK_FORM_DATA["engage_animation"] == "tada") echo ' selected';?>>tada</option>
			          <option value="wobble"<?php if ($JAK_FORM_DATA["engage_animation"] == "wobble") echo ' selected';?>>wobble</option>
			          <option value="jello"<?php if ($JAK_FORM_DATA["engage_animation"] == "jello") echo ' selected';?>>jello</option>
			        </optgroup>

			        <optgroup label="Bouncing Entrances">
			          <option value="bounceIn"<?php if ($JAK_FORM_DATA["engage_animation"] == "bounceIn") echo ' selected';?>>bounceIn</option>
			          <option value="bounceInDown"<?php if ($JAK_FORM_DATA["engage_animation"] == "bounceInDown") echo ' selected';?>>bounceInDown</option>
			          <option value="bounceInLeft"<?php if ($JAK_FORM_DATA["engage_animation"] == "bounceInLeft") echo ' selected';?>>bounceInLeft</option>
			          <option value="bounceInRight"<?php if ($JAK_FORM_DATA["engage_animation"] == "bounceInRight") echo ' selected';?>>bounceInRight</option>
			          <option value="bounceInUp"<?php if ($JAK_FORM_DATA["engage_animation"] == "bounceInUp") echo ' selected';?>>bounceInUp</option>
			        </optgroup>

			        <optgroup label="Fading Entrances">
			          <option value="fadeIn"<?php if ($JAK_FORM_DATA["engage_animation"] == "fadeIn") echo ' selected';?>>fadeIn</option>
			          <option value="fadeInDown"<?php if ($JAK_FORM_DATA["engage_animation"] == "fadeInDown") echo ' selected';?>>fadeInDown</option>
			          <option value="fadeInDownBig"<?php if ($JAK_FORM_DATA["engage_animation"] == "fadeInDownBig") echo ' selected';?>>fadeInDownBig</option>
			          <option value="fadeInLeft"<?php if ($JAK_FORM_DATA["engage_animation"] == "fadeInLeft") echo ' selected';?>>fadeInLeft</option>
			          <option value="fadeInLeftBig"<?php if ($JAK_FORM_DATA["engage_animation"] == "fadeInLeftBig") echo ' selected';?>>fadeInLeftBig</option>
			          <option value="fadeInRight"<?php if ($JAK_FORM_DATA["engage_animation"] == "fadeInRight") echo ' selected';?>>fadeInRight</option>
			          <option value="fadeInRightBig"<?php if ($JAK_FORM_DATA["engage_animation"] == "fadeInRightBig") echo ' selected';?>>fadeInRightBig</option>
			          <option value="fadeInUp"<?php if ($JAK_FORM_DATA["engage_animation"] == "fadeInUp") echo ' selected';?>>fadeInUp</option>
			          <option value="fadeInUpBig"<?php if ($JAK_FORM_DATA["engage_animation"] == "fadeInUpBig") echo ' selected';?>>fadeInUpBig</option>
			        </optgroup>

			        <optgroup label="Flippers">
			          <option value="flip"<?php if ($JAK_FORM_DATA["engage_animation"] == "flip") echo ' selected';?>>flip</option>
			          <option value="flipInX"<?php if ($JAK_FORM_DATA["engage_animation"] == "flipInX") echo ' selected';?>>flipInX</option>
			          <option value="flipInY"<?php if ($JAK_FORM_DATA["engage_animation"] == "flipInY") echo ' selected';?>>flipInY</option>
			        </optgroup>

			        <optgroup label="Lightspeed">
			          <option value="lightSpeedIn"<?php if ($JAK_FORM_DATA["engage_animation"] == "lightSpeedIn") echo ' selected';?>>lightSpeedIn</option>
			        </optgroup>

			        <optgroup label="Rotating Entrances">
			          <option value="rotateIn"<?php if ($JAK_FORM_DATA["engage_animation"] == "rotateIn") echo ' selected';?>>rotateIn</option>
			          <option value="rotateInDownLeft"<?php if ($JAK_FORM_DATA["engage_animation"] == "rotateInDownLeft") echo ' selected';?>>rotateInDownLeft</option>
			          <option value="rotateInDownRight"<?php if ($JAK_FORM_DATA["engage_animation"] == "rotateInDownRight") echo ' selected';?>>rotateInDownRight</option>
			          <option value="rotateInUpLeft"<?php if ($JAK_FORM_DATA["engage_animation"] == "rotateInUpLeft") echo ' selected';?>>rotateInUpLeft</option>
			          <option value="rotateInUpRight"<?php if ($JAK_FORM_DATA["engage_animation"] == "rotateInUpRight") echo ' selected';?>>rotateInUpRight</option>
			        </optgroup>

			        <optgroup label="Sliding Entrances">
			          <option value="slideInUp"<?php if ($JAK_FORM_DATA["engage_animation"] == "slideInUp") echo ' selected';?>>slideInUp</option>
			          <option value="slideInDown"<?php if ($JAK_FORM_DATA["engage_animation"] == "slideInDown") echo ' selected';?>>slideInDown</option>
			          <option value="slideInLeft"<?php if ($JAK_FORM_DATA["engage_animation"] == "slideInLeft") echo ' selected';?>>slideInLeft</option>
			          <option value="slideInRight"<?php if ($JAK_FORM_DATA["engage_animation"] == "slideInRight") echo ' selected';?>>slideInRight</option>
			        </optgroup>
			        
			        <optgroup label="Zoom Entrances">
			          <option value="zoomIn"<?php if ($JAK_FORM_DATA["engage_animation"] == "zoomIn") echo ' selected';?>>zoomIn</option>
			          <option value="zoomInDown"<?php if ($JAK_FORM_DATA["engage_animation"] == "zoomInDown") echo ' selected';?>>zoomInDown</option>
			          <option value="zoomInLeft"<?php if ($JAK_FORM_DATA["engage_animation"] == "zoomInLeft") echo ' selected';?>>zoomInLeft</option>
			          <option value="zoomInRight"<?php if ($JAK_FORM_DATA["engage_animation"] == "zoomInRight") echo ' selected';?>>zoomInRight</option>
			          <option value="zoomInUp"<?php if ($JAK_FORM_DATA["engage_animation"] == "zoomInUp") echo ' selected';?>>zoomInUp</option>
			        </optgroup>

			        <optgroup label="Specials">
			          <option value="jackInTheBox"<?php if ($JAK_FORM_DATA["engage_animation"] == "jackInTheBox") echo ' selected';?>>jackInTheBox</option>
			          <option value="rollIn"<?php if ($JAK_FORM_DATA["engage_animation"] == "rollIn") echo ' selected';?>>rollIn</option>
			        </optgroup>
				</select>
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="jak_buttonimg"><?php echo $jkl["g71"];?></label>
				<select name="jak_buttonimg" id="chatbutton" class="form-control">
				<?php if (isset($BUTTONS_ALL) && is_array($BUTTONS_ALL)) foreach($BUTTONS_ALL as $k) { if (getimagesize(APP_PATH.JAK_FILES_DIRECTORY.'/buttons/'.$k) && strpos($k,"_on")) { ?>
					<option value="<?php echo $k;?>"<?php if ($JAK_FORM_DATA["buttonimg"] == $k) { ?> selected="selected"<?php } ?>><?php echo $k;?></option><?php } } ?>
				</select>
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="jak_buttonimgmobile"><?php echo $jkl["bw13"];?></label>
				<select name="jak_buttonimgmobile" id="jak_buttonimgmobile" class="form-control">
				<?php if (isset($BUTTONS_ALL) && is_array($BUTTONS_ALL)) foreach($BUTTONS_ALL as $k) { if (getimagesize(APP_PATH.JAK_FILES_DIRECTORY.'/buttons/'.$k) && strpos($k,"_on")) { ?>
					<option value="<?php echo $k;?>"<?php if ($JAK_FORM_DATA["mobilebuttonimg"] == $k) { ?> selected="selected"<?php } ?>><?php echo $k;?></option><?php } } ?>
				</select>
			</div>
			</td>
		</tr>
		<?php if (isset($jakgraphix["slideimg"]) && $jakgraphix["slideimg"] === true) { ?>
		<tr>
			<td>
			<div class="form-group">
				<label class="control-label" for="jak_slideimg"><?php echo $jkl["g292"];?></label>
				<select name="jak_slideimg" id="sildecatchimg" class="form-control">
				<option value=""<?php if ($JAK_FORM_DATA["slideimg"] == '') echo ' selected="selected"';?>><?php echo $jkl["bw4"];?></option>
				<?php if (isset($SLIDEIMG_ALL) && is_array($SLIDEIMG_ALL)) foreach($SLIDEIMG_ALL as $s) { if (getimagesize(APP_PATH.JAK_FILES_DIRECTORY.'/slideimg/'.$s) && strpos($s,"_on")) { ?>
					<option value="<?php echo $s;?>"<?php if ($JAK_FORM_DATA["slideimg"] == $s) { ?> selected="selected"<?php } ?>><?php echo $s;?></option><?php } } ?>
				</select>
			</div>
			</td>
		</tr>
		<?php } else { ?>
		<input type="hidden" value="" name="jak_slideimg">
		<?php } ?>
		</table>
		</div>
		</div>
		<div class="box-footer">
			<a href="<?php echo JAK_rewrite::jakParseurl('widget');?>" class="btn btn-default"><?php echo $jkl["g103"];?></a>
			<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
		</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title"><?php echo $jkl["g15"];?></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<div class="table-responsive">
		<table class="table table-striped">
		<tr>
			<td><?php echo $jkl["g158"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_chat_direct" value="1"<?php if ($JAK_FORM_DATA["chat_direct"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_chat_direct" value="0"<?php if ($JAK_FORM_DATA["chat_direct"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["u54"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_chat_waonline" value="1"<?php if ($JAK_FORM_DATA["whatsapp_online"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_chat_waonline" value="0"<?php if ($JAK_FORM_DATA["whatsapp_online"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["u55"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_chat_waoffline" value="1"<?php if ($JAK_FORM_DATA["whatsapp_offline"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_chat_waoffline" value="0"<?php if ($JAK_FORM_DATA["whatsapp_offline"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g100"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_cemail" value="1"<?php if ($JAK_FORM_DATA['client_email'] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_cemail" value="0"<?php if ($JAK_FORM_DATA['client_email'] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g233"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_scemail" value="1"<?php if ($JAK_FORM_DATA['client_semail'] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_scemail" value="0"<?php if ($JAK_FORM_DATA['client_semail'] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g144"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_cphone" value="1"<?php if ($JAK_FORM_DATA['client_phone'] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_cphone" value="0"<?php if ($JAK_FORM_DATA['client_phone'] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g199"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_scphone" value="1"<?php if ($JAK_FORM_DATA['client_sphone'] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_scphone" value="0"<?php if ($JAK_FORM_DATA['client_sphone'] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g231"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_question" value="1"<?php if ($JAK_FORM_DATA['client_question'] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_question" value="0"<?php if ($JAK_FORM_DATA['client_question'] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g232"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_squestion" value="1"<?php if ($JAK_FORM_DATA['client_squestion'] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_squestion" value="0"<?php if ($JAK_FORM_DATA['client_squestion'] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g237"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_avatar" value="1"<?php if ($JAK_FORM_DATA['show_avatar'] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_avatar" value="0"<?php if ($JAK_FORM_DATA['show_avatar'] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		</table>
		</div>
		</div>
		<div class="box-footer">
			<a href="<?php echo JAK_rewrite::jakParseurl('widget');?>" class="btn btn-default"><?php echo $jkl["g103"];?></a>
			<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
		</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">

<div class="box">
<div class="box-body no-padding">
<div class="table-responsive">
<table class="table styleChanger">
<tr>
<td><?php echo $jkl["bw11"];?></td>
<td>
	<select name="chatSty" class="form-control" onchange="this.form.submit()">
		<?php if (isset($chat_packages) && is_array($chat_packages)) foreach($chat_packages as $c) { ?>
		<option value="<?php echo $c;?>"<?php if ($JAK_FORM_DATA["template"] == $c) { ?> selected="selected"<?php } ?>><?php echo $c;?></option>
		<?php } ?>
	</select>
</td>
</tr>
<tr id="chat_bubbles_c"<?php if (empty($jakgraphix["themes"])) echo ' style="display: none;"';?>>
<td><?php echo $jkl["style_s9"];?></td>
<td>
	<select name="chatCol" class="form-control" id="chat-colours-preview">
		<?php if (isset($jakgraphix["themes"]) && is_array($jakgraphix["themes"])) foreach($jakgraphix["themes"] as $t) { ?>
		<option value="<?php echo $t;?>"<?php if ($JAK_FORM_DATA["theme_colour"] == $t) { ?> selected="selected"<?php } ?>><?php echo $t;?></option>
		<?php } ?>
	</select>
</td>
</tr>
<tr>
<td><?php echo $jkl["style_s1"];?></td>
<td><input type="text" class="form-control" name="pcolor" id="pcolor" value="<?php echo $JAK_FORM_DATA["body_colour"];?>"></td>
</tr>
<tr><td class="content-title" colspan="2"><?php echo $jkl["style_s6"];?></td>
</tr>
<tr><td>H1, H2, H3...</td>
<td><input type="text" class="form-control" name="pfhead" id="phead" title="Heading" value="<?php echo $JAK_FORM_DATA["h_colour"];?>">
</td>
</tr>
<tr><td>div, p, code...</td>
<td><input type="text" class="form-control" name="pfont" id="pfont" title="Content" value="<?php echo $JAK_FORM_DATA["c_colour"];?>">
</td>
</tr>
<tr><td>Time</td>
<td><input type="text" class="form-control" name="pfheadc" id="pheadcontent" title="Heading Content" value="<?php echo $JAK_FORM_DATA["time_colour"];?>">
</td>
</tr>
<tr><td><?php echo $jkl["style_s8"];?></td>
<td><input type="text" class="form-control" name="pafont" id="pafont" value="<?php echo $JAK_FORM_DATA["link_colour"];?>">
</td>
</tr>
<tr><td><?php echo $jkl["style_s10"];?></td>
<td><input type="text" class="form-control" name="pfsidec" id="pfsidec" value="<?php echo $JAK_FORM_DATA["sidebar_colour"];?>">
</td>
</tr>
<tr><td><?php echo $jkl["style_s15"];?></td>
<td><select name="tFont" id="tFont" class="form-control">
		<option value=''<?php if ($JAK_FORM_DATA["t_font"] == ''){ echo ' selected="selected"'; } ?>><?php echo $jkl['g246'];?></option>
		<option value='Times New Roman'<?php if ($JAK_FORM_DATA["t_font"] == 'Times New Roman'){ echo ' selected="selected"'; } ?>>Times New Roman</option>
		<option value='Arial'<?php if ($JAK_FORM_DATA["t_font"] == 'Arial'){ echo ' selected="selected"'; } ?>>Arial</option>
		<option value='Palatino'<?php if ($JAK_FORM_DATA["t_font"] == 'Palatino'){ echo ' selected="selected"'; } ?>>Palatino Linotype</option>
		<option value='Arial Black'<?php if ($JAK_FORM_DATA["t_font"] == 'Arial Black'){ echo ' selected="selected"'; } ?>>Arial Black</option>
		<option value='Comic Sans MS'<?php if ($JAK_FORM_DATA["t_font"] == 'Comic Sans MS'){ echo ' selected="selected"'; } ?>>Comic Sans MS</option>
		<option value='Impact'<?php if ($JAK_FORM_DATA["t_font"] == 'Impact'){ echo ' selected="selected"'; } ?>>Impact</option>
		<option value='Tahoma'<?php if ($JAK_FORM_DATA["t_font"] == 'Tahoma'){ echo ' selected="selected"'; } ?>>Tahoma</option>
		<option value='Trebuchet MS'<?php if ($JAK_FORM_DATA["t_font"] == 'Trebuchet MS'){ echo ' selected="selected"'; } ?>>Trebuchet MS</option>
		<option value='Verdana'<?php if ($JAK_FORM_DATA["t_font"] == 'Verdana'){ echo ' selected="selected"'; } ?>>Verdana</option>
		<option value='Courier New'<?php if ($JAK_FORM_DATA["t_font"] == 'Courier New'){ echo ' selected="selected"'; } ?>>Courier New</option>
	</select>
</td>
</tr>
<tr><td><?php echo $jkl["style_s4"];?></td>
<td><select name="gFont" id="gFont" class="form-control">
		<optgroup label="Recomended Fonts">
			<option value='Open+Sans'<?php if ($JAK_FORM_DATA["h_font"] == 'Open+Sans'){ echo ' selected="selected"'; } ?>>Open Sans</option>
			<option value='Ubuntu'<?php if ($JAK_FORM_DATA["h_font"] == 'Ubuntu'){ echo ' selected="selected"'; } ?>>Ubuntu</option>
			<option value='Walter+Turncoat'<?php if ($JAK_FORM_DATA["h_font"] == 'Walter+Turncoat'){ echo ' selected="selected"'; } ?>>Walter Turncoat</option>
			<option value='Lato'<?php if ($JAK_FORM_DATA["h_font"] == 'Lato'){ echo ' selected="selected"'; } ?>>Lato</option>
			<option value='Amaranth'<?php if ($JAK_FORM_DATA["h_font"] == 'Amaranth'){ echo ' selected="selected"'; } ?>>Amaranth</option>
			<option value='Pacifico'<?php if ($JAK_FORM_DATA["h_font"] == 'Pacifico'){ echo ' selected="selected"'; } ?>>Pacifico</option>
			<option value='Anton'<?php if ($JAK_FORM_DATA["h_font"] == 'Anton'){ echo ' selected="selected"'; } ?>>Anton</option>
			<option value='Luckiest+Guy'<?php if ($JAK_FORM_DATA["h_font"] == 'Luckiest+Guy'){ echo ' selected="selected"'; } ?>>Luckiest Guy</option>
			<option value='Permanent+Marker'<?php if ($JAK_FORM_DATA["h_font"] == 'Permanent+Marker'){ echo ' selected="selected"'; } ?>>Permanent Marker</option>
			<option value='Merriweather'<?php if ($JAK_FORM_DATA["h_font"] == 'Merriweather'){ echo ' selected="selected"'; } ?>>Merriweather</option>
			<option value='Cuprum'<?php if ($JAK_FORM_DATA["h_font"] == 'Cuprum'){ echo ' selected="selected"'; } ?>>Cuprum</option>
			<option value='Neuton'<?php if ($JAK_FORM_DATA["h_font"] == 'Neuton'){ echo ' selected="selected"'; } ?>>Neuton</option>
			<option value='Lobster'<?php if ($JAK_FORM_DATA["h_font"] == 'Lobster'){ echo ' selected="selected"'; } ?>>Lobster</option>
			<option value='NonGoogle'<?php if ($JAK_FORM_DATA["h_font"] == 'NonGoogle'){ echo ' selected="selected"'; } ?>>Use Same as Content Font</option>
		</optgroup>
		<optgroup label="Other Fonts">
			<option value='Allan'<?php if ($JAK_FORM_DATA["h_font"] == 'Allan'){ echo ' selected="selected"'; } ?>>Allan</option>
			<option value='Allerta'<?php if ($JAK_FORM_DATA["h_font"] == 'Allerta'){ echo ' selected="selected"'; } ?>>Allerta</option>
			<option value='Allerta+Stencil'<?php if ($JAK_FORM_DATA["h_font"] == 'Allerta+Stencil'){ echo ' selected="selected"'; } ?>>Allerta Stencil</option>
			<option value='Anonymous+Pro'<?php if ($JAK_FORM_DATA["h_font"] == 'Anonymous+Pro'){ echo ' selected="selected"'; } ?>>Anonymous Pro</option>
			<option value='Arimo'<?php if ($JAK_FORM_DATA["h_font"] == 'Arimo'){ echo ' selected="selected"'; } ?>>Arimo</option>
			<option value='Arvo'<?php if ($JAK_FORM_DATA["h_font"] == 'Arvo'){ echo ' selected="selected"'; } ?>>Arvo</option>
			<option value='Astloch'<?php if ($JAK_FORM_DATA["h_font"] == 'Astloch'){ echo ' selected="selected"'; } ?>>Astloch</option>
			<option value='Bentham'<?php if ($JAK_FORM_DATA["h_font"] == 'Bentham'){ echo ' selected="selected"'; } ?>>Bentham</option>
			<option value='Bevan'<?php if ($JAK_FORM_DATA["h_font"] == 'Bevan'){ echo ' selected="selected"'; } ?>>Bevan</option>
			<option value='Buda:light'<?php if ($JAK_FORM_DATA["h_font"] == 'Buda:light'){ echo ' selected="selected"'; } ?>>Buda</option>
			<option value='Cabin'<?php if ($JAK_FORM_DATA["h_font"] == 'Cabin'){ echo ' selected="selected"'; } ?>>Cabin</option>
			<option value='Cabin+Sketch'<?php if ($JAK_FORM_DATA["h_font"] == 'Cabin+Sketch'){ echo ' selected="selected"'; } ?>>Cabin Sketch</option>
			<option value='Calligraffitti'<?php if ($JAK_FORM_DATA["h_font"] == 'Calligraffitti'){ echo ' selected="selected"'; } ?>>Calligraffitti</option>
			<option value='Candal'<?php if ($JAK_FORM_DATA["h_font"] == 'Candal'){ echo ' selected="selected"'; } ?>>Candal</option>
			<option value='Cantarell'<?php if ($JAK_FORM_DATA["h_font"] == 'Cantarell'){ echo ' selected="selected"'; } ?>>Cantarell</option>
			<option value='Cardo'<?php if ($JAK_FORM_DATA["h_font"] == 'Cardo'){ echo ' selected="selected"'; } ?>>Cardo</option>
			<option value='Cherry+Cream+Soda'<?php if ($JAK_FORM_DATA["h_font"] == 'Cherry+Cream+Soda'){ echo ' selected="selected"'; } ?>>Cherry Cream Soda</option>
			<option value='Chewy'<?php if ($JAK_FORM_DATA["h_font"] == 'Chewy'){ echo ' selected="selected"'; } ?>>Chewy</option>
			<option value='Coda:800'<?php if ($JAK_FORM_DATA["h_font"] == 'Coda:800'){ echo ' selected="selected"'; } ?>>Coda</option>
			<option value='Coda+Caption:800'<?php if ($JAK_FORM_DATA["h_font"] == 'Coda+Caption:800'){ echo ' selected="selected"'; } ?>>Coda Caption</option>
			<option value='Coming+Soon'<?php if ($JAK_FORM_DATA["h_font"] == 'Coming+Soon'){ echo ' selected="selected"'; } ?>>Coming Soon</option>
			<option value='Copse'<?php if ($JAK_FORM_DATA["h_font"] == 'Copse'){ echo ' selected="selected"'; } ?>>Copse</option>
			<option value='Corben'<?php if ($JAK_FORM_DATA["h_font"] == 'Corben'){ echo ' selected="selected"'; } ?>>Corben</option>
			<option value='Cousine'<?php if ($JAK_FORM_DATA["h_font"] == 'Cousine'){ echo ' selected="selected"'; } ?>>Cousine</option>
			<option value='Covered+By+Your+Grace'<?php if ($JAK_FORM_DATA["h_font"] == 'Covered+By+Your+Grace'){ echo ' selected="selected"'; } ?>>Covered By Your Grace</option>
			<option value='Crafty+Girls'<?php if ($JAK_FORM_DATA["h_font"] == 'Crafty+Girls'){ echo ' selected="selected"'; } ?>>Crafty Girls</option>
			<option value='Crimson+Text'<?php if ($JAK_FORM_DATA["h_font"] == 'Crimson+Text'){ echo ' selected="selected"'; } ?>>Crimson Text</option>
			<option value='Crushed'<?php if ($JAK_FORM_DATA["h_font"] == 'Crushed'){ echo ' selected="selected"'; } ?>>Crushed</option>
			<option value='Dancing+Script'<?php if ($JAK_FORM_DATA["h_font"] == 'Dancing+Script'){ echo ' selected="selected"'; } ?>>Dancing Script</option>
			<option value='Droid+Sans'<?php if ($JAK_FORM_DATA["h_font"] == 'Droid+Sans'){ echo ' selected="selected"'; } ?>>Droid Sans</option>
			<option value='Droid+Sans+Mono'<?php if ($JAK_FORM_DATA["h_font"] == 'Droid+Sans+Mono'){ echo ' selected="selected"'; } ?>>Droid Sans Mono</option>
			<option value='Droid+Serif'<?php if ($JAK_FORM_DATA["h_font"] == 'Droid+Serif'){ echo ' selected="selected"'; } ?>>Droid Serif</option>
			<option value='EB+Garamond'<?php if ($JAK_FORM_DATA["h_font"] == 'EB+Garamond'){ echo ' selected="selected"'; } ?>>EB Garamond</option>
			<option value='Expletus+Sans'<?php if ($JAK_FORM_DATA["h_font"] == 'Expletus+Sans'){ echo ' selected="selected"'; } ?>>Expletus Sans</option>
			<option value='Fontdiner+Swanky'<?php if ($JAK_FORM_DATA["h_font"] == 'Fontdiner+Swanky'){ echo ' selected="selected"'; } ?>>Fontdiner Swanky</option>
			<option value='Geo'<?php if ($JAK_FORM_DATA["h_font"] == 'Geo'){ echo ' selected="selected"'; } ?>>Geo</option>
			<option value='Goudy+Bookletter+1911'<?php if ($JAK_FORM_DATA["h_font"] == 'Goudy+Bookletter+1911'){ echo ' selected="selected"'; } ?>>Goudy Bookletter 1911</option>
			<option value='Gruppo'<?php if ($JAK_FORM_DATA["h_font"] == 'Gruppo'){ echo ' selected="selected"'; } ?>>Gruppo</option>
			<option value='Homemade+Apple'<?php if ($JAK_FORM_DATA["h_font"] == 'Homemade+Apple'){ echo ' selected="selected"'; } ?>>Homemade Apple</option>
			<option value='IM+Fell+DW+Pica'<?php if ($JAK_FORM_DATA["h_font"] == 'IM+Fell+DW+Pica'){ echo ' selected="selected"'; } ?>>IM Fell DW Pica</option>
			<option value='IM+Fell+French+Canon+SC'<?php if ($JAK_FORM_DATA["h_font"] == 'IM+Fell+French+Canon+SC'){ echo ' selected="selected"'; } ?>>IM Fell French Canon SC</option>
			<option value='IM+Fell+French+Canon'<?php if ($JAK_FORM_DATA["h_font"] == 'IM+Fell+French+Canon'){ echo ' selected="selected"'; } ?>>IM Fell French Canon</option>
			<option value='IM+Fell+Great+Primer+SC'<?php if ($JAK_FORM_DATA["h_font"] == 'IM+Fell+Great+Primer+SC'){ echo ' selected="selected"'; } ?>>IM Fell Great Primer SC</option>
			<option value='IM+Fell+Great+Primer'<?php if ($JAK_FORM_DATA["h_font"] == 'IM+Fell+Great+Primer'){ echo ' selected="selected"'; } ?>>IM Fell Great Primer</option>
			<option value='IM+Fell+English+SC'<?php if ($JAK_FORM_DATA["h_font"] == 'IM+Fell+English+SC'){ echo ' selected="selected"'; } ?>>IM Fell English SC</option>
			<option value='IM+Fell+English'<?php if ($JAK_FORM_DATA["h_font"] == 'IM+Fell+English'){ echo ' selected="selected"'; } ?>>IM Fell English</option>
			<option value='IM+Fell+DW+Pica+SC'<?php if ($JAK_FORM_DATA["h_font"] == 'IM+Fell+DW+Pica+SC'){ echo ' selected="selected"'; } ?>>IM Fell DW Pica SC</option>
			<option value='IM+Fell+Double+Pica+SC'<?php if ($JAK_FORM_DATA["h_font"] == 'IM+Fell+Double+Pica+SC'){ echo ' selected="selected"'; } ?>>IM Fell Double Pica SC</option>
			<option value='IM+Fell+Double+Pica'<?php if ($JAK_FORM_DATA["h_font"] == 'IM+Fell+Double+Pica'){ echo ' selected="selected"'; } ?>>IM Fell Double Pica</option>
			<option value='Inconsolata'<?php if ($JAK_FORM_DATA["h_font"] == 'Inconsolata'){ echo ' selected="selected"'; } ?>>Inconsolata</option>
			<option value='Indie+Flower'<?php if ($JAK_FORM_DATA["h_font"] == 'Indie+Flower'){ echo ' selected="selected"'; } ?>>Indie Flower</option>
			<option value='Irish+Grover'<?php if ($JAK_FORM_DATA["h_font"] == 'Irish+Grover'){ echo ' selected="selected"'; } ?>>Irish Grover</option>
			<option value='Josefin+Sans'<?php if ($JAK_FORM_DATA["h_font"] == 'Josefin+Sans'){ echo ' selected="selected"'; } ?>>Josefin Sans</option>
			<option value='Josefin+Slab'<?php if ($JAK_FORM_DATA["h_font"] == 'Josefin+Slab'){ echo ' selected="selected"'; } ?>>Josefin Slab</option>
			<option value='Just+Another+Hand'<?php if ($JAK_FORM_DATA["h_font"] == 'Just+Another+Hand'){ echo ' selected="selected"'; } ?>>Just Another Hand</option>
			<option value='Just+Me+Again+Down+Here'<?php if ($JAK_FORM_DATA["h_font"] == 'Just+Me+Again+Down+Here'){ echo ' selected="selected"'; } ?>>Just Me Again Down Here</option>
			<option value='Kenia'<?php if ($JAK_FORM_DATA["h_font"] == 'Kenia'){ echo ' selected="selected"'; } ?>>Kenia</option>
			<option value='Kranky'<?php if ($JAK_FORM_DATA["h_font"] == 'Kranky'){ echo ' selected="selected"'; } ?>>Kranky</option>
			<option value='Kreon'<?php if ($JAK_FORM_DATA["h_font"] == 'Kreon'){ echo ' selected="selected"'; } ?>>Kreon</option>
			<option value='Kristi'<?php if ($JAK_FORM_DATA["h_font"] == 'Kristi'){ echo ' selected="selected"'; } ?>>Kristi</option>
			<option value='League+Script'<?php if ($JAK_FORM_DATA["h_font"] == 'League+Script'){ echo ' selected="selected"'; } ?>>League Script</option>
			<option value='Lekton'<?php if ($JAK_FORM_DATA["h_font"] == 'Lekton'){ echo ' selected="selected"'; } ?>>Lekton</option>
			<option value='Meddon'<?php if ($JAK_FORM_DATA["h_font"] == 'Meddon'){ echo ' selected="selected"'; } ?>>Meddon</option>
			<option value='MedievalSharp'<?php if ($JAK_FORM_DATA["h_font"] == 'MedievalSharp'){ echo ' selected="selected"'; } ?>>MedievalSharp</option>
			<option value='Molengo'<?php if ($JAK_FORM_DATA["h_font"] == 'Molengo'){ echo ' selected="selected"'; } ?>>Molengo</option>
			<option value='Mountains+of+Christmas'<?php if ($JAK_FORM_DATA["h_font"] == 'Mountains+of+Christmas'){ echo ' selected="selected"'; } ?>>Mountains of Christmas</option>
			<option value='Neucha'<?php if ($JAK_FORM_DATA["h_font"] == 'Neucha'){ echo ' selected="selected"'; } ?>>Neucha</option>
			<option value='Nobile'<?php if ($JAK_FORM_DATA["h_font"] == 'Nobile'){ echo ' selected="selected"'; } ?>>Nobile</option>
			<option value='Nova+Script'<?php if ($JAK_FORM_DATA["h_font"] == 'Nova+Script'){ echo ' selected="selected"'; } ?>>Nova Script</option>
			<option value='Nova+Round'<?php if ($JAK_FORM_DATA["h_font"] == 'Nova+Round'){ echo ' selected="selected"'; } ?>>Nova Round</option>
			<option value='Nova+Oval'<?php if ($JAK_FORM_DATA["h_font"] == 'Nova+Oval'){ echo ' selected="selected"'; } ?>>Nova Oval</option>
			<option value='Nova+Mono'<?php if ($JAK_FORM_DATA["h_font"] == 'Nova+Mono'){ echo ' selected="selected"'; } ?>>Nova Mono</option>
			<option value='Nova+Cut'<?php if ($JAK_FORM_DATA["h_font"] == 'Nova+Cut'){ echo ' selected="selected"'; } ?>>Nova Cut</option>
			<option value='Nova+Slim'<?php if ($JAK_FORM_DATA["h_font"] == 'Nova+Slim'){ echo ' selected="selected"'; } ?>>Nova Slim</option>
			<option value='Nova+Flat'<?php if ($JAK_FORM_DATA["h_font"] == 'Nova+Flat'){ echo ' selected="selected"'; } ?>>Nova Flat</option>
			<option value='OFL+Sorts+Mill+Goudy+TT'<?php if ($JAK_FORM_DATA["h_font"] == 'OFL+Sorts+Mill+Goudy+TT'){ echo ' selected="selected"'; } ?>>OFL Sorts Mill Goudy TT</option>
			<option value='Old+Standard+TT'<?php if ($JAK_FORM_DATA["h_font"] == 'Old+Standard+TT'){ echo ' selected="selected"'; } ?>>Old Standard TT</option>
			<option value='Orbitron'<?php if ($JAK_FORM_DATA["h_font"] == 'Orbitron'){ echo ' selected="selected"'; } ?>>Orbitron</option>
			<option value='Oswald'<?php if ($JAK_FORM_DATA["h_font"] == 'Oswald'){ echo ' selected="selected"'; } ?>>Oswald</option>
			<option value='Philosopher'<?php if ($JAK_FORM_DATA["h_font"] == 'Philosopher'){ echo ' selected="selected"'; } ?>>Philosopher</option>
			<option value='PT+Sans'<?php if ($JAK_FORM_DATA["h_font"] == 'PT+Sans'){ echo ' selected="selected"'; } ?>>PT Sans</option>
			<option value='PT+Sans+Narrow'<?php if ($JAK_FORM_DATA["h_font"] == 'PT+Sans+Narrow'){ echo ' selected="selected"'; } ?>>PT Sans Narrow</option>
			<option value='PT+Sans+Caption'<?php if ($JAK_FORM_DATA["h_font"] == 'PT+Sans+Caption'){ echo ' selected="selected"'; } ?>>PT Sans Caption</option>
			<option value='PT+Serif'<?php if ($JAK_FORM_DATA["h_font"] == 'PT+Serif'){ echo ' selected="selected"'; } ?>>PT Serif</option>
			<option value='PT+Serif+Caption'<?php if ($JAK_FORM_DATA["h_font"] == 'PT+Serif+Caption'){ echo ' selected="selected"'; } ?>>PT Serif Caption</option>
			<option value='Puritan'<?php if ($JAK_FORM_DATA["h_font"] == 'Puritan'){ echo ' selected="selected"'; } ?>>Puritan</option>
			<option value='Quattrocento'<?php if ($JAK_FORM_DATA["h_font"] == 'Quattrocento'){ echo ' selected="selected"'; } ?>>Quattrocento</option>
			<option value='Raleway:100'<?php if ($JAK_FORM_DATA["h_font"] == 'Raleway:100'){ echo ' selected="selected"'; } ?>>Raleway</option>
			<option value='Reenie+Beanie'<?php if ($JAK_FORM_DATA["h_font"] == 'Reenie+Beanie'){ echo ' selected="selected"'; } ?>>Reenie Beanie</option>
			<option value='Rock+Salt'<?php if ($JAK_FORM_DATA["h_font"] == 'Rock+Salt'){ echo ' selected="selected"'; } ?>>Rock Salt</option>
			<option value='Schoolbell'<?php if ($JAK_FORM_DATA["h_font"] == 'Schoolbell'){ echo ' selected="selected"'; } ?>>Schoolbell</option>
			<option value='Slackey'<?php if ($JAK_FORM_DATA["h_font"] == 'Slackey'){ echo ' selected="selected"'; } ?>>Slackey</option>
			<option value='Sniglet:800'<?php if ($JAK_FORM_DATA["h_font"] == 'Sniglet:800'){ echo ' selected="selected"'; } ?>>Sniglet</option>
			<option value='Sunshiney'<?php if ($JAK_FORM_DATA["h_font"] == 'Sunshiney'){ echo ' selected="selected"'; } ?>>Sunshiney</option>
			<option value='Syncopate'<?php if ($JAK_FORM_DATA["h_font"] == 'Syncopate'){ echo ' selected="selected"'; } ?>>Syncopate</option>
			<option value='Tangerine'<?php if ($JAK_FORM_DATA["h_font"] == 'Tangerine'){ echo ' selected="selected"'; } ?>>Tangerine</option>
			<option value='Tinos'<?php if ($JAK_FORM_DATA["h_font"] == 'Tinos'){ echo ' selected="selected"'; } ?>>Tinos</option>
			<option value='UnifrakturCook'<?php if ($JAK_FORM_DATA["h_font"] == 'UnifrakturCook'){ echo ' selected="selected"'; } ?>>UnifrakturCook</option>
			<option value='UnifrakturMaguntia'<?php if ($JAK_FORM_DATA["h_font"] == 'UnifrakturMaguntia'){ echo ' selected="selected"'; } ?>>UnifrakturMaguntia</option>
			<option value='Unkempt'<?php if ($JAK_FORM_DATA["h_font"] == 'Unkempt'){ echo ' selected="selected"'; } ?>>Unkempt</option>
			<option value='VT323'<?php if ($JAK_FORM_DATA["h_font"] == 'VT323'){ echo ' selected="selected"'; } ?>>VT323</option>
			<option value='Vibur'<?php if ($JAK_FORM_DATA["h_font"] == 'Vibur'){ echo ' selected="selected"'; } ?>>Vibur</option>
			<option value='Vollkorn'<?php if ($JAK_FORM_DATA["h_font"] == 'Vollkorn'){ echo ' selected="selected"'; } ?>>Vollkorn</option>
			<option value='Yanone+Kaffeesatz'<?php if ($JAK_FORM_DATA["h_font"] == 'Yanone+Kaffeesatz'){ echo ' selected="selected"'; } ?>>Yanone Kaffeesatz</option>
		</optgroup>
	</select>
</td>
</tr>
<tr><td><?php echo $jkl["style_s5"];?></td>
<td><select name="cFont" id="cFont" class="form-control">
		<option value='<?php echo $JAK_FORM_DATA["h_font"];?>'<?php if ($JAK_FORM_DATA["c_font"] == $JAK_FORM_DATA["h_font"]){ echo ' selected="selected"'; } ?>><?php echo $JAK_FORM_DATA["h_font"];?></option>
		<option value='"Trebuchet MS", Helvetica, Garuda, sans-serif'<?php if ($JAK_FORM_DATA["c_font"] == '"Trebuchet MS", Helvetica, Garuda, sans-serif'){ echo ' selected="selected"'; } ?>>Trebuchet MS</option>
		<option value='Arial, Helvetica, sans-serif'<?php if ($JAK_FORM_DATA["c_font"] == 'Arial, Helvetica, sans-serif'){ echo ' selected="selected"'; } ?>>Arial</option>
		<option value='"Comic Sans MS", Monaco, "TSCu_Comic", cursive'<?php if ($JAK_FORM_DATA["c_font"] == '"Comic Sans MS", Monaco, "TSCu_Comic", cursive'){ echo ' selected="selected"'; } ?>>Comic Sans MS</option>
		<option value='Georgia, Times, "Century Schoolbook L", serif'<?php if ($JAK_FORM_DATA["c_font"] == 'Georgia, Times, "Century Schoolbook L", serif'){ echo ' selected="selected"'; } ?>>Georgia</option>
		<option value='Verdana, Geneva, "DejaVu Sans", sans-serif'<?php if ($JAK_FORM_DATA["c_font"] == 'Verdana, Geneva, "DejaVu Sans", sans-serif'){ echo ' selected="selected"'; } ?>>Verdana</option>
		<option value='Tahoma, Geneva, Kalimati, sans-serif'<?php if ($JAK_FORM_DATA["c_font"] == 'Tahoma, Geneva, Kalimati, sans-serif'){ echo ' selected="selected"'; } ?>>Tahoma</option>
		<option value='"Lucida Sans Unicode", "Lucida Grande", Garuda, sans-serif'<?php if ($JAK_FORM_DATA["c_font"] == '"Lucida Sans Unicode", "Lucida Grande", Garuda, sans-serif'){ echo ' selected="selected"'; } ?>>Lucida Sans</option>
		<option value='Calibri, "AppleGothic", "MgOpen Modata", sans-serif'<?php if ($JAK_FORM_DATA["c_font"] == 'Calibri, "AppleGothic", "MgOpen Modata", sans-serif'){ echo ' selected="selected"'; } ?>>Calibri</option>
		<option value='"Times New Roman", Times, "Nimbus Roman No9 L", serif'<?php if ($JAK_FORM_DATA["c_font"] == '"Times New Roman", Times, "Nimbus Roman No9 L", serif'){ echo ' selected="selected"'; } ?>>Times New Roman</option>
		<option value='"Courier New", Courier, "Nimbus Mono L", monospace'<?php if ($JAK_FORM_DATA["c_font"] == '"Courier New", Courier, "Nimbus Mono L", monospace'){ echo ' selected="selected"'; } ?>>Courier New</option>
	</select>
</td>
</tr>
</table>
</div>
</div>
<div class="box-footer">
	<a href="<?php echo JAK_rewrite::jakParseurl('widget');?>" class="btn btn-default"><?php echo $jkl["g103"];?></a>
	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
</div>
</div>

</form>

</div>
<div class="col-md-4">

	<div class="box box-success">
	  	<div class="box-header with-border">
	  		<i class="fa fa-comments"></i>
	    	<h3 class="box-title"><?php echo $jkl["style_s11"];?></h3>
	  	</div><!-- /.box-header -->
	  	<div class="box-body body-message-preview">

	  		<?php echo $jakgraphix["previewchat"];?>

		</div>
	</div>

</div>
<div class="col-md-4">

	<div class="box box-warning">
	  	<div class="box-header with-border">
	  		<i class="fa fa-send"></i>
	    	<h3 class="box-title"><?php echo $jkl["style_s14"];?></h3>
	  	</div><!-- /.box-header -->
	  	<div class="box-body body-message-preview">

	  		<?php echo $jakgraphix["previewcontact"];?>
	  		
	  	</div>

	</div>
</div>
		
<?php include_once 'footer.php';?>