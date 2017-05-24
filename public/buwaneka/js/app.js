var placeholder = "#unhold";
var cover = "#cover";
$("document").ready( function() {
	firebase.initializeApp(config);
	var provider = new firebase.auth.GoogleAuthProvider();

	firebase.auth().onAuthStateChanged(function(user) {
		if(user != null) {
			$(placeholder).html("<img class='uihold' src='"+ user.photoURL + "' />" + user.displayName + "'s time is now at Yapahuwa");
			record(user);
			$(cover).hide();
			fetch(user.email, window.location.pathname, window.location.hash);
			getPortal(user.email, window.location.pathname, window.location.hash);
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
	firebase.database().ref("users/"+ user.uid + "/buwaneka").push({
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

function fetch(email, path, hash) {
	
	var pathchanged = "/"+ /([a-zA-Z]+)/g.exec(path)[0];
	// alert(email+ " "+ pathchanged + " "+ hash);
	$.ajax({
		type: "post",
		url: "https://io-2017-timetrek.appspot.com",
		// url: "http://localhost:8090",
		data: "e="+ email + "&p="+ pathchanged + "&a="+ hash,
		dataType: "json",
		success: function(data) {
			if(data.q == "a" || data.q == "c") {
				$("#landing").html(data.c);
			} else if(data.q == "b" || data.q == "d") {
				$("#landnig").html(data.c);
			}
		}
	});
}

function getPortal(email,path,hash) {
	var pathchanged = "/"+ /([a-zA-Z]+)/g.exec(path)[0];

	$.ajax({
		type: "post",
		// url: "https://io-2017-timetrek.appspot.com/bricks",
		url: "http://localhost:8090/bricks",
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
