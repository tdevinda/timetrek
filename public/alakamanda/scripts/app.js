var placeholder = "#unhold";
var cover = "#cover";
$("document").ready( function() {
	firebase.initializeApp(config);
	var provider = new firebase.auth.GoogleAuthProvider();

	firebase.auth().onAuthStateChanged(function(user) {
		if(user != null) {
			$(placeholder).html("<img class='uihold' src='"+ user.photoURL + "' />" + user.displayName 
				+ " has come all the way through time to Anuradhapura");
			record(user);
			$(cover).hide();
			getPortal(user.email, "/alakamanda", window.location.hash);
			
		}
		else {
			firebase.auth().signInWithRedirect(provider);
		}
	});


	firebase.auth().getRedirectResult();
});
function record(user) {
	firebase.database().ref("users/"+ user.uid + "/alakamanda").push({
		date: (new Date()).toString(),
		name: user.displayName,
		email: user.email
	});

	firebase.database().ref("users/" + user.uid + "/_details").update({
		name: user.displayName,
		email: user.email,
		photo: user.photoURL
	});
}

function getPortal(email, path, hash) {
	var pathchanged = "/"+ /([a-zA-Z]+)/g.exec(path)[0];

	$.ajax({
		type: "post",
		url: "https://io-2017-timetrek.appspot.com/bricks",
		// url: "http://localhost:8090/bricks",
		data: "e="+ email + "&p="+ path + "&a="+ hash,
		dataType: "json",
		success: function(data) {
			if(data.d != null) {
				$("#tmpart").html(data.d);
				$("#tmpart").show();
			}
		}
	});
}