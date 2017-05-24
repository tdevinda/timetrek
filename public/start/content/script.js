$("document").ready(function(){

	var v = parseInt(Math.random() * 1000) % 255;
	$(".calibration").css('padding-left', ((v / 255) * 100) + "%");
	$("#volts").html(v +" Amperes");
	$(".voltage").click(function(){
		var amp = getAmp();


		$(".pointer").animate({
			'padding-left': ((amp / 255) * 100) + "%"
		}, 1000);
	});

	$("#power").click(function() {
	
		if(v == getAmp()) {
			var chars = 'f4122f0076926525654a647d699079226176626261616e506431619772316167ee2323';
			var boxes = "";
			for(var i =4;i< (chars.length - 6);i+=4) {
				var current = parseInt(chars.substring(i, i+2), 16);
				boxes += getBoxes(current);
			}

			$("#controllers").html(boxes);
		} else {
			$("#controllers").html("");
		}
	});


});

function getAmp() {
	var amp = 0;
		
	for(var i=0;i < 8;i++) {
		if($("#c" + (i + 1)).is(":checked")) {
			amp += Math.pow(2, (7 - i));
		}
	}

	return amp;

}


function getBoxes(value) {
	var output = "";
	for(var i=7;i>=0;i--) {
		var currentBox = '';
		if((value & Math.pow(2,i)) > 0) {
			currentBox = 'checked';
		}
		
		output += '<input type="checkbox" '+ currentBox +' />';
	}

	return output;
}