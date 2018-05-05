'use strict';

var schoolID = getURLParameter('schoolID');
var studentID = getURLParameter('studentID');
var typeID = getURLParameter('typeID') || getURLParameter('reportType');

var svgNS = "http://www.w3.org/2000/svg";
var svg = document.createElementNS(svgNS, "svg");
svg.setAttribute("viewBox", "0 0 2200 1700");
// lawn
var grass = document.createElementNS(svgNS, "polygon");
grass.setAttributeNS(svgNS, "points", "0,0 2200,0 2200,1700 0,1700");
grass.setAttributeNS(svgNS, "style", "fill:#006600;stroke:#006600;stroke-width:1;");
svg.appendChild(grass);



function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
}



var getJSON = function (url, callback) {
  if (typeof url !== 'undefined' && url.includes('https')) {
	var xhr = new XMLHttpRequest();
	xhr.open('GET', url, true);
	xhr.responseType = 'json';
	xhr.onload = function () {
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



function sendReport(_buildingID) {
	var reportURL = 'https://fast.esns.life/sendreport.php?schoolID=' + schoolID + '&perpBuildingID=' + _buildingID + '&userBuildingID=' + 
	_buildingID + '&typeID=' + typeID + "&studentID=" + studentID + "&redirect=" + 0;

	console.log(schoolID + ' at ' + _buildingID);
	console.log(reportURL);
	getJSON(reportURL, function (err, data) {
		if (err !== null) {
				alert('Something went wrong: ' + err);
		} else {
				console.log('Report submitted.');
			}
		});
}

// <circle cx="50" cy="50" r="40" stroke="black" stroke-width="3" fill="red" />
function createCircle(x,y,radius) {
	var myCircle = document.createElementNS(svgNS, "circle");
	myCircle.setAttributeNS(svgNS, "cx", x);
	myCircle.setAttributeNS(svgNS, "cy", y);
	myCircle.setAttributeNS(svgNS, "r", radius);
	myCircle.setAttributeNS(svgNS, "stroke", "black");
	myCircle.setAttributeNS(svgNS, "fill-opacity", "0.5");
	myCircle.setAttributeNS(svgNS, "fill", "red");
	svg.appendChild(myCircle);
	console.log('make circle');
}

function createPoly(bgcolor, _points, buildingID) {
	var link = document.createElementNS("http://www.w3.org/2000/svg", "a");
	link.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', '#');
	link.setAttributeNS(svgNS, 'onclick', 'sendReport('+buildingID+')');
	svg.appendChild(link);

  var myPoly = document.createElementNS(svgNS, "polygon");
  myPoly.setAttributeNS(svgNS, "points", _points);
  myPoly.setAttributeNS(svgNS, "style", "fill:" + bgcolor + ";stroke:black;stroke-width:1;");
  link.appendChild(myPoly);
}

createCircle(600,600,200);

getJSON('https://fast.esns.life/services/getallstructuredimensions_api.php?schoolID=' + schoolID,
  function (err, data) {
	if (err !== null) {
	  	alert('Something went wrong: ' + err);
	} else {
			var points = '';

			for (let i = 0; i < data.length; i++) {
				points += data[i].w + ',' + data[i].h + ' ';

				// end poly
				if (data[i].e === '1') {
					createPoly('#d9d9d9', points, data[i].b);
					points = '';
				}
			}
			

			var XMLS = new XMLSerializer();
			var svgStr =  XMLS.serializeToString(svg);
			var svgStr2 = svgStr.replace(/ns\d+:/g, '');
			document.getElementById("mapcontainer").innerHTML = svgStr2;
			console.log(svgStr2);
		}
	});

	
	
	