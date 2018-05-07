"use strict";

var schoolID = getURLParameter("schoolID");
var studentID = getURLParameter("studentID");
var typeID = getURLParameter("typeID") || getURLParameter("reportType");
var speed = getURLParameter("speed") || 1000;

var longWest = -119.754263;
var longEast = -119.736166;
var longDiff = Math.abs(longWest - longEast);
var latNorth = 36.81675;
var latSouth = 36.808592;
var latDiff = Math.abs(latNorth - latSouth);
var reportMode = "me";
var userBuildingID = null;

var mapWidth = 2200;
var mapHeight = 1700;

var svgNS = "http://www.w3.org/2000/svg";
var svg = {};

var opacity = 1;

function initSVG() {
  svg = document.createElementNS(svgNS, "svg");
  svg.setAttribute("viewBox", "0 0 " + mapWidth + " " + mapHeight);
  // lawn
  var grass = document.createElementNS(svgNS, "polygon");
  grass.setAttribute(
    "points",
    "0,0 " + mapWidth + ",0 " + mapWidth + "," + mapHeight + " 0," + mapHeight
  );
  grass.setAttribute("style", "fill:#006600;stroke:#006600;stroke-width:1;");
  svg.appendChild(grass);
}

function getURLParameter(name) {
  return (
    decodeURIComponent(
      (new RegExp("[?|&]" + name + "=" + "([^&;]+?)(&|#|;|$)").exec(
        location.search
      ) || [null, ""])[1].replace(/\+/g, "%20")
    ) || null
  );
}

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

function sendReport(_buildingID) {

  let shooterBuildingID = null;

  if (reportMode === "me") {
    userBuildingID = _buildingID;
  }
  else {
    shooterBuildingID = _buildingID;
  }

  var reportURL =
    "https://fast.esns.life/sendreport.php?schoolID=" +
    schoolID +
    "&perpBuildingID=" +
    shooterBuildingID +
    "&userBuildingID=" +
    userBuildingID +
    "&typeID=" +
    typeID +
    "&studentID=" +
    studentID +
    "&redirect=" +
    0;

  getJSON(reportURL, function(err, data) {
    if (err !== null) {
      alert("Something went wrong: " + err);
    } else {
      console.log("Report submitted: " + schoolID + " at " + _buildingID);
    }
  });
}

function drawCircleFromLatLong(x, y, radius) {
  createCircle(x, y, radius * 5);
}

function getCircleColor(radius) {
  if (radius >= 100) {
    return "red";
  } else if (radius >= 50) {
    return "orange";
  } else {
    return "yellow";
  }
}

function minRadius(radius) {
  if (radius < 10) {
    return 10;
  }
  return radius;
}

function drawUserCicle() {
  if (userBuildingID === null) {
    return;
  }
  var maxX=0;
  var minX=10000;
  var maxY=0;
  var minY=10000;
  for (let i = 0; i<buildings.length; i++) {
    if (buildings.b === userBuildingID) {
      if (buildings.x < minX) {
        minX = buildings.x;
      }
      else if (buildings.x > maxX) {
        maxX=buildings.x;
      }
  
      if (buildings.y < minY) {
        minY = buildings.y;
      }
      else if (buildings.y > maxY) {
        maxY = buildings.y;
      }
    }  
  }

  var avgX = (maxX + minX) / 2;
  var avgY = (maxY + minY) / 2;

  
  createUserCircle(avgX, avgY);

}

function createCircle(x, y, radius) {
  var myCircle = document.createElementNS(svgNS, "circle");
  myCircle.setAttribute("cx", x);
  myCircle.setAttribute("cy", y);
  myCircle.setAttribute("r", minRadius(radius));
  myCircle.setAttribute("stroke", "black");
  myCircle.setAttribute("fill-opacity", "0.5");
  myCircle.setAttribute("fill", getCircleColor(radius));
  svg.appendChild(myCircle);
}

function createUserCircle(x, y) {
  var myCircle = document.createElementNS(svgNS, "circle");
  myCircle.setAttributeNS(svgNS, "cx", x);
  myCircle.setAttributeNS(svgNS, "cy", y);
  myCircle.setAttributeNS(svgNS, "r", 50);
  myCircle.setAttributeNS(svgNS, "stroke", "black");
  myCircle.setAttributeNS(svgNS, "fill-opacity", "0.5");
  myCircle.setAttributeNS(svgNS, "fill", "#000");
  svg.appendChild(myCircle);
  console.log('create user Circle');
}

function createPoly(bgcolor, _points, buildingID) {
  var link = document.createElementNS("http://www.w3.org/2000/svg", "a");
  link.setAttribute("xlink:href", "#");
  link.setAttribute("onclick", "sendReport(" + buildingID + ")");
  svg.appendChild(link);

  var myPoly = document.createElementNS(svgNS, "polygon");
  myPoly.setAttribute("points", _points);
  myPoly.setAttribute(
    "style",
    "fill:" + bgcolor + ";stroke:black;stroke-width:1;fill-opacity:" + opacity
  );
  link.appendChild(myPoly);
}

var alreadyChecking = false;

function checkReports() {
  alreadyChecking = true;
  getJSON(
    "https://fast.esns.life/services/getcompiledreports_api.php?schoolID=" +
      schoolID,
    function(err, data) {
      if (err !== null) {
        alert("Something went wrong: " + err);
      } else {
        initSVG();
        if (typeof data[0] !== "undefined") {
          initSVG();
          // we draw the buildings below...
          opacity = 1;
          drawBuildings();

          // ... the circles ..
          for (var i = 0; i < data.length; i++) {
            drawCircleFromLatLong(data[i].x, data[i].y, data[i].c);
          }
          // ..and above
          opacity = 0;
          drawBuildings();
          drawUserCicle();
          drawMap();
        } else {
          opacity = 1;
          drawBuildings();
          drawMap();
          console.log("No data");
        }

        alreadyChecking = false;
      }
    }
  );
}

function drawMap() {
  //var html = document.body.innerHTML;
  //var newHTML = html;

  var XMLS = new XMLSerializer();
  var svgStr = XMLS.serializeToString(svg);
  var svgStr2 = svgStr.replace(/ns\d+:/g, "");
  svgStr2 = svgStr2.replace(/:ns188284/g, "");
  //document.body.innerHTML = newHTML;

  document.getElementById("mapcontainer").innerHTML = svgStr2;
}

function drawBuildings() {
  var points = "";

  // w = width h = height - these are corners of the buildings
  for (var i = 0; i < buildings.length; i++) {
    points += buildings[i].w + "," + buildings[i].h + " ";

    // end poly e== 1 means endpoint
    if (buildings[i].e === "1") {
      createPoly("#d9d9d9", points, buildings[i].b);
      points = "";
    }
  }
}


function reportMyLocation() {
  console.log("here");
  document.getElementById("myloc").style.background = "dodgerblue";
  document.getElementById("sholoc").style.background = "grey";
  reportMode = "me";
}

function reportShooterLocation() {
  document.getElementById("sholoc").style.background = "red";
  document.getElementById("myloc").style.background = "grey";
  reportMode="shooter";
}

function safe() {
  document.getElementById("safe").style.background = "dodgerblue";
  document.getElementById("notsafe").style.background = "grey";
  getJSON(
    "https://fast.esns.life/services/safetyreport_api.php?studentID=" +
      studentID +
      "&safety=1",
    function(err, data) {
      if (err !== null) {
        alert("Something went wrong: " + err);
      } else {
        console.log("Reported as SAFE.");
      }
    }
  );
}

function notSafe() {
  document.getElementById("safe").style.background = "grey";
  document.getElementById("notsafe").style.background = "red";
  getJSON(
    "https://fast.esns.life/services/safetyreport_api.php?studentID=" +
      studentID +
      "&safety=0",
    function(err, data) {
      if (err !== null) {
        alert("Something went wrong: " + err);
      } else {
        console.log("Reported as NOT SAFE.");
      }
    }
  );
}

var buildings = {};

// default run mode
reportMyLocation();
getJSON(
  "https://fast.esns.life/services/getallstructuredimensions_api.php?schoolID=" +
    schoolID,
  function(err, data) {
    if (err !== null) {
      alert("Something went wrong: " + err);
    } else {
      buildings = data;
      checkReports();
      var gatherReports = setInterval(checkReports, speed);
    }
  }
);
