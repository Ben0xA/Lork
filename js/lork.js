function submitcommand(event) {
	if(event.keyCode == 13) {
		var command = document.getElementById("inprompt");
		if(command != null) {
			var cmdvalue = command.value.substr(0, 45);
			if(cmdvalue != "") {
				var lork = document.getElementById("lork");
				switch(cmdvalue.toLowerCase()) {
					case "clear":
						if(lork != null) {
							lork.innerHTML = "<br />";	
						}
						lork.scrollTop = lork.scrollHeight; 
						command.value = "";
						command.focus();					
						break;
					default:
						var req = new XMLHttpRequest();
						var url = "command.php";		
						var params = "inprompt=" + cmdvalue;
						req.open("POST", url, true);

						req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						req.setRequestHeader("Content-length", params.length);
						req.setRequestHeader("Connection", "close");

						req.onreadystatechange = function() {
							if(req.readyState == 4 && req.status == 200) {
								if(lork != null) {
									var rspjson = jQuery.parseJSON(req.responseText);
									var BR = "<BR />";
									switch(rspjson.RESPONSE) {
										case "START":
											var score = document.getElementById("score");
											if(score != null) {
												score.style.visibility = "visible"
											}											
											lork.innerHTML = rspjson.DISPLAY;
											break;
										case "EXIT":
											var score = document.getElementById("score");
											if(score != null) {
												score.style.visibility = "hidden";
											}
											lork.innerHTML = rspjson.DISPLAY;
											break;
										default:
											lork.innerHTML += rspjson.BASE + rspjson.DISPLAY + BR;
											lork.scrollTop = lork.scrollHeight; 
											break;
									}
									var room = document.getElementById("room");
									if(room != null) {
										room.innerHTML = "Room: " + rspjson.ROOM;
									}
									var points = document.getElementById("points");
									if(points != null && rspjson.POINTS != null) {
										points.innerHTML = "Score: " + rspjson.POINTS;
									} 								
									command.value = "";
									command.focus();
								}							
							}
						}
						req.send(params);
						break;
				}
			}
		}
	}
}