/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.8.1                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

var answerconv="false";var rllinput=rlsbint=livechat3_popup_window=null;var utyping="false";var title=document.title;var message='';var attSource='';var working=livetype=false;var scrollchat=loadchat=winIsActive=muted=show_notifiy=true;var jrc_lang="en";var uid=$('#userID').val();var usrname=$('#userName').val();var conv=$('#convID').val();var ulastmsgid=0;document.addEventListener('visibilitychange',handleVisibilityChange,false);$(document).ready(function(){$("#message").on("keyup",function(e){if(e.which!=13&&utyping=="false"){userTyping()}if($(this).val().length==0){if(!$.trim($(this).val()))userNotTyping()}if(e.keyCode!=13)livepreview($(this).val())});$("#message").on("keypress",function(e){if(e.keyCode==13&&!e.shiftKey){e.preventDefault();sendInput()}});$("#sendMessage").on("click",function(e){e.preventDefault();sendInput()});loadInput();sseJAK(5000);if(livechat3_popup_window)livechat3_popup_window.onbeforeunload=function(){livechat3_popup_window=null}});function handleVisibilityChange(){if(document.visibilityState=="hidden"){sessionStorage.umsgid=ulastmsgid;if(rlsbint){clearInterval(rlsbint);rlsbint=null}}else{ulastmsgid=sessionStorage.umsgid;scrollchat=true;loadInput();sseJAK(5000)}}function sseJAK(timer){setChecker();if(!rlsbint)rlsbint=setInterval(function(){setChecker()},timer)}function sendInput(){if(working)return false;working=true;if(rlsbint){clearInterval(rlsbint);rlsbint=null}$("#sendMessage i").removeClass("fa-paper-plane-o").addClass("fa-spinner fa-pulse");$('#msgError').removeClass("is-invalid");var messageC=$('#message').val();var message=encodeURIComponent(messageC);var request=$.ajax({url:ls.main_url+'include/insert.php',type:"POST",data:"conv="+conv+"&msg="+message+"&userid="+uid+"&name="+usrname+"&lang="+jrc_lang,dataType:"json",cache:false});request.done(function(msg){if(msg.status==1){loadchat=true;scrollchat=true;show_notifiy=true;if(msg.html){if(msg.selfmsg){$("#groupmsg"+ulastmsgid).after(msg.html)}else{$("#jrc_chat_output").append(msg.html)}ulastmsgid=msg.lastid;scrollBottom()}$('#message').val("");document.title=title;answerconv="false";utyping="false"}else{loadchat=true;$('#msgError').addClass("is-invalid");scrollBottom();answerconv="false"}$("#sendMessage i").removeClass("fa-spinner fa-pulse").addClass("fa-paper-plane-o");working=false});sseJAK(3000)}function loadInput(){loadchat=true;getInput()}function getInput(){if(loadchat){var request=$.ajax({url:ls.main_url+'include/retrieve.php',type:"GET",data:"convid="+conv+"&userid="+uid+"&lang="+jrc_lang+"&lastid="+ulastmsgid,dataType:"json",cache:false});request.done(function(msg){if(msg.status){if(msg.redirecturl){if(parent.postMessage){parent.postMessage('redirecturl::'+msg.redirecturl,ls.main_url)}}$("#jrc_chat_output").append(msg.html).css("background-image","none");ulastmsgid=msg.lastid}if(scrollchat){scrollBottom()}loadchat=false})}}function userTyping(){utyping="true";var request=$.ajax({url:ls.main_url+'include/typing.php',type:"POST",data:"conv="+conv+"&status=1",dataType:"json",cache:false})}function userNotTyping(){utyping="false";var request=$.ajax({url:ls.main_url+'include/typing.php',type:"POST",data:"conv="+conv+"&status=0",dataType:"json",cache:false})}function livepreview(text){if(livetype)return false;livetype=true;var message=encodeURIComponent(text);var request=$.ajax({url:ls.main_url+'include/livepreview.php',type:"POST",data:"conv="+conv+"&text="+message,dataType:"json",cache:false});request.done(function(msg){livetype=false})}function setChecker(){var request=$.ajax({url:ls.main_url+'include/inform.php',type:"GET",data:"uid="+uid+"&slide="+ls.ls_slide+"&lang="+jrc_lang+"&active="+winIsActive,dataType:"json",cache:false});request.done(function(msg){handlemsg(msg)})}function handlemsg(msg){if(msg.redirect_c){if(rlsbint){clearInterval(rlsbint);rlsbint=null}window.location=msg.redirect_c}else if(msg.redirect_cu){if(msg.redirect_cu){if(parent.postMessage){parent.postMessage('redirecturl::'+msg.redirect_cu,msg.baseurl);return true}}}else{if(msg.operator){$('#operator_connected').fadeIn();$('#oname').html(msg.operator);$('#oimage').attr("src",msg.oimage)}if(msg.knockknock){if(msg.pushnotify==1&&Notification.permission==='granted'){dNotifyNew(title,msg.knockknock)}else{alert(msg.knockknock)}if(muted)playSound(ls.ls_sound+'.webm',ls.ls_sound+'.mp3')}if(msg.newmsg==1){document.title=ls.ls_submit;scrollchat=true;loadInput();if(answerconv=="false"){if(msg.pushnotify==1)dNotifyNew(title,msg.newmsgtxt);if(muted)playSound(ls.ls_sound+'.webm',ls.ls_sound+'.mp3')}}else{document.title=title}if(msg.files==1){$('#client-chat-upload').fadeIn()}else if(msg.files==0){$('#client-chat-upload').fadeOut()}if(msg.typing!=0){$('#jrc_typing').html(msg.typing).fadeIn().fadeOut().fadeIn()}else{$('#jrc_typing').fadeOut("fast").html("")}if(msg.delmsg){$('#postid_'+msg.delmsg+', #msg'+msg.delmsg).toggle()}if(msg.msgedit){$('#msg'+msg.msgedit).html(msg.editmsg);$('#edited_'+msg.msgedit).html(msg.showedit)}if(msg.datac==1)location.reload()}}function soundOff(){if(muted){$('#soundoff').html('<i class="fa fa-volume-off"></i>');muted=0}else{$('#soundoff').html('<i class="fa fa-volume-up"></i>');muted=1}return true}function scrollBottom(){$('#jrc_chat_output').animate({scrollTop:$('#jrc_chat_output')[0].scrollHeight},300);scrollchat=false}function playSound(soundfile,soundfile2,soundfile3){var sound=new Howl({src:[ls.main_url+soundfile2,ls.main_url+soundfile3,ls.main_url+soundfile]});sound.play();answerconv="true"}function dNotifyNew(title,msg){dNotify(title,{body:msg,icon:ls.main_url+"img/logo.png",onclick:function(e){},onclose:function(e){},ondenied:function(e){console.log("Desktop Notifcations denied, please check within your browser settings.")}});show_notifiy=false;return true}function getHiddenProp(){var prefixes=['webkit','moz','ms','o'];if('hidden'in document)return'hidden';for(var i=0;i<prefixes.length;i++){if((prefixes[i]+'Hidden')in document)return prefixes[i]+'Hidden'}return null}function isHidden(){var prop=getHiddenProp();if(!prop)return false;return document[prop]}