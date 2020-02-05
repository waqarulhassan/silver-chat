<div class="modal-header">
	<h4 class="modal-title"><?php echo JAK_TITLE;?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>  
</div>
<div class="modal-body">
<div class="padded-box">

<div id="contact-container">
<form id="cNotes" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">

	 <div class="form-group">
	    <label for="note"><?php echo $jkl["g181"];?></label>
		<textarea name="note" id="note" rows="5" class="form-control"><?php echo $getnote;?></textarea>
	</div>
	
	<button type="submit" id="formsubmit" class="btn btn-primary btn-block"><?php echo $jkl["g38"];?></button>
	
	<input type="hidden" name="convid" value="<?php if (is_numeric($page1)) { echo $page1; } else { echo $page2;}?>">
</form>
</div>

</div>

</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $jkl["g180"];?></button>
	</div>

<script type="text/javascript" src="<?php echo BASE_URL;?>js/notes.js"></script>