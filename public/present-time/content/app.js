var placeholder = "#unhold";
var cover = "#cover";
$("document").ready( function() {
	firebase.initializeApp(config);
	var provider = new firebase.auth.GoogleAuthProvider();

	firebase.auth().onAuthStateChanged(function(user) {
		if(user != null) {
			$(placeholder).html("<img class='uihold' src='"+ user.photoURL + "' />" + user.displayName + " has won!");
			record(user);
			$(cover).hide();
			getURL(user.email, window.location.hash);

		}
		else {
			firebase.auth().signInWithRedirect(provider);
		}
	});

	firebase.auth().getRedirectResult();

	$("#showmore").click(function() {
		$("#landing").show();
	});
});

function record(user) {
	firebase.database().ref("users/"+ user.uid + "/win").push({
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

function getURL(email, hash) {
	$.ajax({
		type: "post",
		url: "https://io-2017-timetrek.appspot.com/present",
		// url: "http://localhost:8090/present",
		data: "e="+ email + "&a="+ hash,
		dataType: "json",
		success: function(data) {
			if(data.s == 403) {
				$(".formurl").html(data.b);
			} else {
				$(".formurl").html("<p style='color: red'>Wrong key! Portal worked. But your clothes didn't make it</p>");
			}
		}
	});
}

