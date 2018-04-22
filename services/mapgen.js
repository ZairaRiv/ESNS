'use strict';

var schoolID = getURLParameter('schoolID');
var svgNS = "http://www.w3.org/2000/svg";
var svg = document.createElementNS(svgNS, "svg");
svg.setAttribute("width", "2200");
svg.setAttribute("height", "1700");
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

function createPoly(bgcolor, _points, buildingID) {
  var reportURL = 'https://fast.esns.life/makereport.php?schoolID=' + schoolID + '&buildingID=' + buildingID;
  var myPoly = document.createElementNS(svgNS, "polygon");
  myPoly.setAttributeNS(svgNS, "points", _points);
  myPoly.setAttributeNS(svgNS, "style", "fill:" + bgcolor + ";stroke:black;stroke-width:1;");
  myPoly.setAttributeNS(svgNS, 'href', reportURL);
  svg.appendChild(myPoly);
}

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
	  console.log(svgStr2);
	  document.getElementById("mapcontainer").innerHTML = svgStr2;
	}
  });