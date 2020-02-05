<?php include_once 'header.php';?>

<div class="flex-sidebar-chat" style="display: none;">
	<div class="chat-tab">
		<a href="javascript:void(0)" data-chat="info" title="<?php echo $jkl['g40'];?>" class="btn-slidebar-info"><i class="fa fa-info"></i></a>
	</div>
	<div class="chat-tab">
		<a href="javascript:void(0)" data-chat="edit" title="<?php echo $jkl['g47'];?>" class="btn-slidebar-info"><i class="fa fa-edit"></i></a>
	</div>
	<div class="chat-tab">
		<a href="javascript:void(0)" data-chat="search" title="<?php echo $jkl['s5'];?>" class="btn-slidebar-info"><i class="fa fa-search"></i></a>
	</div>
	<div class="chat-tab">
		<a href="javascript:void(0)" data-chat="files" title="<?php echo $jkl['g51'];?>" class="btn-slidebar-info"><i class="fa fa-file-archive-o"></i></a>
	</div>
	<div class="chat-tab">
		<a href="javascript:void(0)" data-chat="starred" title="<?php echo $jkl['g275'];?>" class="btn-slidebar-info"><i class="fa fa-star"></i></a>
	</div>
	<div class="chat-tab">
		<a href="javascript:void(0)" data-chat="faq" title="<?php echo $jkl['g278'];?>" class="btn-slidebar-info"><i class="fa fa-lightbulb-o"></i></a>
	</div>
	<div class="chat-tab">
		<a href="javascript:void(0)" data-chat="history" title="<?php echo $jkl['m1'];?>" class="btn-slidebar-info"><i class="fa fa-comments-o"></i></a>
	</div>
</div>

<div class="main-chat-output">
	<!-- Operator transfer / Info div -->
	<div class="alert alert-info chat-inactive-container" id="transfer"><a href="#" class="alert-link main-sidebar-toggle d-md-none"><i class="fa fa-bars"></i></a> <?php echo $jkl['g79'];?></div>
	<div class="chat-active-container" style="display: none;">
		<section class="chat-header">
		    <h1><a href="#" class="main-sidebar-toggle d-md-none"><i class="fa fa-bars"></i></a> <span id="content-header-title"></span></h1>
		</section>
	
		<!-- chat output -->
		<div class="chat-wrapper">
			<div id="chatOutput" class="direct-chat-messages"></div>
		</div>
	
		<div class="chat-footer">

			<!--- Input form -->
			<form role="form" name="messageInput" id="MessageInput" action="javascript:sendInput(activeConvID);">
				
				<div class="form-group">
					<label class="sr-only" for="message"><?php echo $jkl["g135"];?></label>
					<div class="input-group">
						<div class="emoji-picker">
						    <div id="emoji"></div>
						</div>
						<textarea name="message" id="message" class="form-control" rows="1" placeholder="<?php echo $jkl["g135"];?>"></textarea>
						<?php if ($jakuser->getVar("files")) { ?>
						<div class="chat-upload">
							<span class="area fa fa-paperclip" id="cUploadDrop"></span>
						</div>
						<?php } ?>
					</div>
				</div>

				<div class="row chat-extra-input">
					<div class="col-4">

						<div class="form-group">
							<label class="sr-only" for="sendurl"><?php echo $jkl["g238"];?></label>
							<input type="text" id="sendurl" autocomplete="off" name="sendurl" placeholder="<?php echo $jkl["g238"];?>" class="form-control" />
						</div>
					</div>
					<div class="col-4">
					<?php if ($jakuser->getVar("responses") && isset($LC_RESPONSES) && is_array($LC_RESPONSES)) { ?>
					
						<div class="form-group">
							<label class="sr-only" for="response"><?php echo $jkl["g7"];?></label>
							  <select name="standard" id="response" class="selectpicker form-control" data-live-search="true" data-size="4"></select>
						</div>
					
					<?php } ?>
					</div>
					<div class="col-4">
					<?php if ($jakuser->getVar("files") && isset($LC_FILES) && is_array($LC_FILES)) { ?>

						<div class="input-group">
							<select name="files" id="files" class="selectpicker form-control" data-live-search="true" data-size="4">
								<option value="0"><?php echo $jkl["g8"];?></option>
						
							<?php foreach($LC_FILES as $f) { ?>
								<option value="<?php echo $f["id"];?>"><?php echo $f["name"];?></option>
							<?php } ?>
						
							</select>
							<span class="input-group-btn">
							<a id="sendFile" class="btn btn-success"><?php echo $jkl["g4"].' '.$jkl["g9"];?></a>
							</span>
						</div>
				
					<?php } ?>
					</div>
				</div>
				
				<input type="hidden" name="msgeditid" id="msgeditid">
				<input type="hidden" name="msgquoteid" id="msgquoteid">
				<input type="hidden" name="userID" id="userID" value="<?php echo $jakuser->getVar("id");?>">
				<input type="hidden" name="userName" id="userName" value="<?php echo $jakuser->getVar("username");?>">
				<input type="hidden" name="operatorName" id="operatorName" value="<?php echo $jakuser->getVar("name");?>">
				<input type="hidden" name="clientOnline" id="clientOnline" value="<?php echo $jakuser->getVar("useronlinelist");?>">
							
				</form>
				
				<div class="alert alert-info" id="client-left" style="display: none"><?php echo $jkl['g64'];?></div>

			</div>

		<!-- client info -->
		<div class="flex-client-info"></div>
	</div>
</div>

<?php include_once 'footer.php';?>