jQuery.extend({
  getQueryParameters : function(str) {
	  return (str || document.location.search).replace(/(^\?)/,'').split("&").map(function(n){return n = n.split("="),this[n[0]] = n[1],this}.bind({}))[0];
  }
});

$(function() {
	var QueryString = $.getQueryParameters();
	console.log(QueryString);
	if(QueryString.payment === "success"){
		$("#modal-response-body").html('<i class="fa fa-check" style="color:green"></i> Thank\'s! you\'ll get your paper roll in a while.');
		$("#modal-response").modal("show");
	}
	else if(QueryString.payment === "failure"){
		$("#modal-response-body").html('<i class="fa fa-times" style="color:red"></i> Sorry, couldn\'t process your order.');
		$("#modal-response").modal("show");
	}

	$.get("checkout.php?tocken",function(clientToken){
		braintree.setup(clientToken, "dropin", {
			container: "payment-form"
		});
	});	
});