<?php if ($jakhs['hostactive'] && $jakwidget['validtill'] < strtotime("+30 day")) { ?>
<script src="https://checkout.stripe.com/checkout.js"></script>
<?php } ?>

<!-- JavaScript for select all -->
<script type="text/javascript">

<?php if ($jakhs['hostactive'] && $jakwidget['validtill'] < strtotime("+30 day")) { ?>
$('#stripe').on('click', function(e) {

	$(this).find(".jak-loadbtn").addClass("fa fa-spinner fa-spin");

	var amount = $("#month").val();

	var stripe_amount = amount*100;

	e.preventDefault();
	var handler = StripeCheckout.configure({
		key: '<?php echo $sett["stripepublic"];?>',
		image: 'payment/img/stripe_logo.png',
		locale: 'auto',
		token: function(token) {
			// You can access the token ID with `token.id`.
			// Get the token ID to your server-side code for use.
			$("#stripeToken").val(token.id);
			$("#stripeEmail").val(token.email);
			var utok = $("input#stripeToken").val();
			var uemail = $("input#stripeEmail").val();

			if (!utok){ 
				return false; 
			} else {
						        		
				$.ajax({
					url: "<?php echo $_SERVER['REQUEST_URI'];?>",
					type: "POST",
					data: "check=paymember&paidhow=stripe&token="+utok+"&email="+uemail+"&amount="+amount,
					dataType: "json",
					cache: false
				}).done(function(data) {

					if (data.status == 1) {
						$.notify({message: data.infomsg}, {type:'success'});
						$('#expiredmsg').hide();
						$('#memberdate').html(data.date);
					} else {
						$.notify({message: data.infomsg}, {type:'danger'});
					}

				});

			}
		}
	});

	// Open Checkout with further options:
	handler.open({
		name: '<?php echo JAK_TITLE;?>',
		description: '<?php echo $jkl["g295"];?>',
		email: '<?php echo $jakuser->getVar("email");?>',
		amount: parseInt(stripe_amount),
		currency: '<?php echo strtolower($sett["currency"]);?>',
		closed: function () {
			$.notify({message: '<?php echo stripcslashes($jkl['g297']);?>'}, {type:'danger'});
			$("#stripe").find(".jak-loadbtn").removeClass("fa fa-spinner fa-spin");
        }
	});
});

$('#paypal').on('click', function(e) {

	e.preventDefault();

	$(this).find(".jak-loadbtn").addClass("fa fa-spinner fa-spin");

	var amount = $("#month").val();

	$.ajax({
		url: "<?php echo $_SERVER['REQUEST_URI'];?>",
		type: "POST",
		data: "check=paymember&paidhow=paypal&amount="+amount,
		dataType: "json",
		cache: false
	}).done(function(data) {
							        			
		if (data.status == 1) {
			$("#paypal_form").html(data.content);
			$('#gateway_form').submit();
		} else {
			$("#paypal").find(".jak-loadbtn").removeClass("fa fa-spinner fa-spin");
			$.notify({message: data.infomsg}, {type:'danger'});
		}
	});

});
<?php } ?>
ls.main_url = "<?php echo BASE_URL_ADMIN;?>";
ls.orig_main_url = "<?php echo BASE_URL_ORIG;?>";
ls.main_lang = "<?php echo JAK_LANG;?>";
</script>