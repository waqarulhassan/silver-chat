<div class="navbar navbar-default">
	<div class="container">
    	<div class="navbar-header">
        	<a class="navbar-brand" href="<?php echo $_SERVER['REQUEST_URI'];?>"><?php echo $jkl["g"];?> - <?php echo JAK_TITLE;?></a>
    	</div>
	</div>
</div>

<!--- Container -->
<div class="container">
	
	<div class="row">
		<div class="col-sm-8">
		
			<!--- Chat output -->
			<div class="direct-chat-<?php echo $jakwidget['theme_colour'];?>">
				<div id="jrc_chat_output" class="direct-chat-messages"></div>
			</div>
			
			<div id="client_input_container">
			<!-- Client Input -->
				<form action="javascript:sendInput();" name="messageInput" id="MessageInput">
					
					<div class="form-group" id="msgError">
						<div class="input-group">
							<div class="emoji-picker">
								<div id="emoji"></div>
							</div>
							<textarea name="message" id="message" rows="2" class="form-control"></textarea>
						</div>
					</div>
					<button name="sendMSG" id="sendMessage" class="btn btn-primary btn-block"><i class="fa fa-paper-plane-o"></i> <?php echo $jkl["g11"];?></button>
					
					<input type="hidden" name="userID" id="userID" value="<?php echo $_SESSION['jrc_userid'];?>">
					<input type="hidden" name="userName" id="userName" value="<?php echo $_SESSION['jrc_name'];?>">
					<input type="hidden" name="convID" id="convID" value="<?php echo $_SESSION['convid'];?>">
					
				</form>
				
				<div id="jak_update"></div>
			
			</div>

			<?php if (isset($jakhs['copyright']) && !empty($jakhs['copyright'])) echo '<div class="copyright text-center">'.$jakhs['copyright'].'</div>';?>
			
		</div>
		<div class="col-sm-4 sidebar">
			
			<!-- show most content only if operator is connected -->
			<div id="operator_connected">
			
			<!-- Display Operator Image -->
			<p id="oname"></p>

			<!-- Display Operator Image -->
			<p><img src="<?php echo BASE_URL.JAK_FILES_DIRECTORY;?>/standard.jpg" id="oimage" class="img-thumbnail img-fluid" alt="avatar"></p>
			
			<!-- Operator is typing -->
			<p id="jrc_typing"></p>
			
			<hr>
			
			<div id="client-chat-upload">
			<form class="dropzone small" id="cUploadDrop" action="uploader/uploader.php" enctype="multipart/form-data">
			  <div class="fallback">
			    <input name="file" type="file" multiple />
			  </div>
			  <input type="hidden" name="convID" value="<?php echo $_SESSION['convid'];?>">
			  <input type="hidden" name="base_url" value="<?php echo BASE_URL;?>">
			</form>
			<hr>
			</div>
			
			<form class="jak_form" action="<?php echo $parseurl;?>" method="post">
			
			<?php if (JAK_CRATING && !$jakwidget['feedback']) { ?>
			
			<!-- Rate Conversation -->
			<?php if (JAK_CRATING) { ?>
					<div class="form-group">
					    <label class="control-label" for="vote5"><?php echo $jkl["g23"];?></label>
					    <div id="star-container">
					    	<i class="fa fa-star fa-2x star star-checked" id="star-1"></i>
					    	<i class="fa fa-star fa-2x star star-checked" id="star-2"></i>
					    	<i class="fa fa-star fa-2x star star-checked" id="star-3"></i>
					    	<i class="fa fa-star fa-2x star star-checked" id="star-4"></i>
					    	<i class="fa fa-star fa-2x star star-checked" id="star-5"></i>
					    </div>
					    <input type="hidden" name="fbvote" id="fbvote" value="5">
					</div>
			<?php } ?>
				
			<hr>
			
			<?php } ?>
			
			<!-- Close Window -->
			<p><a href="javascript:void(0)" class="btn btn-sm btn-secondary" id="soundoff" onclick="soundOff();"><i class="fa fa-volume-up"></i></a> <a href="<?php echo $chatdetailspop;?>" class="btn btn-sm btn-secondary"><i class="fa fa-pencil"></i> <?php echo $jkl["g85"];?></a></p>

			<p><button type="submit" class="btn btn-danger btn-sm btn-confirm btn-confirm" data-title="<?php echo addslashes($jkl["g15"]);?>" data-text="<?php echo addslashes($jkl["g40"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g72"]);?>" data-cbtn="<?php echo addslashes($jkl["g73"]);?>"><i class="fa fa-power-off"></i> <?php echo $jkl["g15"];?></button></p>
			
			</form>
			
		</div>
		
		</div>
	</div>
</div>