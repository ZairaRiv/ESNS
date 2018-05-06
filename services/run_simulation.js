"use strict";

var schoolID = 0
var studentID = 0
var typeID = 0
var consoleText = [];

var getJSON = function(url, callback) {
	if (typeof url !== "undefined" && url.includes("https")) {
		var xhr = new XMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.responseType = "json";
		xhr.onload = function() {
			var status = xhr.status;
			if (status === 200) {
				callback(null, xhr.response);
			} else {
				callback(status, xhr.response);
			}
		};
		xhr.send();
	}
};

var gatherReports;
var reportList = [1015,1015,1015,1015,1015,1015,1015,256,256,256,279,256,256,279,255,255,1015,1015,256,256,279,255,255,279,279,256,1015,1015,1015,1015,256,256,279,256,256,278,278,278,278,252,252,252,233,233,252,278,279,279,233,252,252,278,233,233,279,278,252,252,231,231,231,230,230,230,231,231,231,230,230,230,230,252,264,264,233,278,278,252,252,252,231,230,230,230,230,261,261,202,202,202,202,202,261,261,202,202,230,231,230,202,202,202,201,201,270,270,202,203,203,262,202,262,202,230,202,202,202,226,226,226,201,201,270,270,201,270,270,201,201,202,201,270,270,201,201,270,270,272,272,270,201,272,272,272,272,272,270,201,270,272,272,272,270,272,226,226,226,273,273,273,273,273,273,273,226,226,226,272,272,272,270,273,273,273,273,273,273,226,226,226,273,225,225,225,225,225,225,225,225,225,200,200,275,200,282,225,225,225,200,200,282,282,225,200,200,200,275,275,275,282,282,282,282,225,225,200,275,200,200,200,282,282,282,225,200,200,275,275,275,275,200,200,282,282,282,225,225,200,275,200,282,282,225,273,273,200,200,282,282,282,282,282,282,282,282,282,282,282];
var idx = 0;


function reportQuadrupler() {
	var reportMegaList = [];
	for (let j=0; j<reportList.length; j++) {
		for (let i=0; i<3; i++) {
			let idx = j+i;
			if (idx>reportList.length-1) {
				idx=reportList.length-1;
			}
			reportMegaList.push(reportList[idx]);
		}
	}
	reportList=reportMegaList;
}

function sendReports() {
	var _buildingID = reportList[idx++];
	if (idx==reportList.length) {
		clearInterval(gatherReports);
	}

	var reportURL =
		"https://fast.esns.life/sendreport.php?schoolID=0" +
		"&perpBuildingID=" +
		_buildingID +
		"&userBuildingID=" +
		_buildingID +
		"&typeID=0" +
		"&studentID=0" +
		"&redirect=0";

	getJSON(reportURL, function(err, data) {
		if (err !== null) {
			alert("Something went wrong: " + err);
		} else {
			writeConsole("Report submitted for buildingID " + _buildingID);
		}
	});
}

function startShooting() {
	reportQuadrupler();
	gatherReports = setInterval(sendReports, 50);
}

function clearReports() {
	idx = 0;
	var clearURL="https://fast.esns.life/services/deletereports_api.php";
	getJSON(clearURL, function(err, data) {
		console.log("Reports cleared");
	});
	clearConsole();
}

function stopSimulation() {
	writeConsole('Simulation cancelled.')
	clearInterval(gatherReports);
}

function clearConsole() {
	consoleText = [];
	consoleToWeb();
}

function writeConsole(txt) {
	consoleText.push(txt + "<br>");
	if (consoleText.length>40) {
		consoleText.shift();
	}
	consoleToWeb();
}

function consoleToWeb() {	
	var html = document.body.innerHTML;
	var newHTML = html;

	document.body.innerHTML = newHTML;

	var text = "";
	for (let i=0; i<consoleText.length; i++) {
		text += consoleText[i];
	}

	document.getElementById("simulationConsole").innerHTML = text;
}
