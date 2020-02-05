<?php if ($jakwidget['h_font'] != "NonGoogle") { ?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=<?php echo $jakwidget['h_font'];?>:regular,italic,bold,bolditalic" type="text/css">
<?php } ?>

<style id="cFontStyles" type="text/css">
body, .navbar-brand, h1, h2, h3, h4, h5, h6 { font-family: '<?php echo ($jakwidget['h_font'] == $jakwidget['c_font'] ? str_replace("+", " ", $jakwidget['h_font']) : $jakwidget['c_font']);?>', sans-serif; }

<?php if ($jakwidget['h_colour'] != '#494949') { ?>

.navbar-brand { color: <?php echo $jakwidget['h_colour'];?>; }

<?php } if (isset($jakwidget['body_colour']) && $jakwidget['body_colour'] != '') { ?>

.jrc_chat_form_slide:hover, .live-chat-profile-container:hover { background: <?php echo $jakwidget['body_colour'];?> !important; }

<?php } if ($jakwidget['h_colour'] != '#494949') { ?>

h1, h2, h3, h4, h5, h6 { color: <?php echo $jakwidget['h_colour'];?>; }

<?php } if ($jakwidget['c_colour'] != '#494949') { ?>

body { color: <?php echo $jakwidget['c_colour'];?>; }

<?php } if ($jakwidget['time_colour'] != '#999999') { ?>

.chat-timestamp { color: <?php echo $jakwidget['time_colour'];?>; }

<?php } if ($jakwidget['link_colour'] != '#007ff5') { ?>

a { color: <?php echo $jakwidget['link_colour'];?>; }

<?php } ?>
</style>