var ddhourDisplay = document.getElementById("ddhour");
var ddminDisplay = document.getElementById("ddminute");
var ddDayHalf = document.getElementById("ddDayHalf");
var ddDayCount = document.getElementById("ddDayCount");

const ddWIcons = ["ddSunny", "ddCloudy", "ddRainy"];
const ddWeatherConditions = ["Sunny", "Cloudy", "Rainy"];
const ddWeatherIcons = ddWIcons.map((id) => document.getElementById(id));

var ddTemp = document.getElementById("ddTemp");
var ddWeatherDesc = document.getElementById("ddWeatherDesc");

var hourCount = 9;
var minuteCount = 0;
var dayhalf = "AM";
var dayCount = 1;

var daySpeed = 1000;
var boolFast = false;

//These will be updated as attacks are implemented (currently hard coded) 0 is good 1 is medium 2 is bad
var ddServState = [0, 0, 0, 0];

var ddDayInterval;

var ddSystemMsg = { name: "systemAdmin", addr: "systemAdmin@noReply.com" };

//let person = prompt("Please enter your name");
let person = "you"
document.getElementById("ddUsername").innerText = person;
var fastForwardBtn = document.getElementById("ddFastFowardBtn");
function fastForward() {
    if (boolFast) {
        boolFast = false;
        daySpeed = 1000;
        fastForwardBtn.classList.remove("ddcolorRed");
    } else {
        boolFast = true;
        daySpeed = 50;
        fastForwardBtn.classList.add("ddcolorRed");
    }
    dayInt();
}
dayInt();

function dayInt() {
    clearInterval(ddDayInterval);
    ddDayInterval = setInterval(function () {
        minuteCount++;
        if (minuteCount == 60) {
            minuteCount = 0;
            hourCount++;
            if (hourCount == 12) {
                dayhalf = "PM";
            }
            if (hourCount == 13) {
                hourCount = 1;
            }
            if (hourCount == 5) {
                hourCount = 9;
                dayCount++;
                dayhalf = "AM";
                ddDisplayNewWeatherReport();
            }
        }
        ddSetDateAndTime();
    }, daySpeed);
}

function ddSetDateAndTime() {
    ddhourDisplay.innerText = hourCount;
    if (minuteCount < 10) {
        ddminDisplay.innerText = "0" + minuteCount;
    } else {
        ddminDisplay.innerText = minuteCount;
    }
    ddDayHalf.innerText = dayhalf;
    if (dayCount < 10) {
        ddDayCount.innerText = "00" + dayCount;
    } else if (dayCount < 100) {
        ddDayCount.innerText = "0" + dayCount;
    } else {
        ddDayCount.innerText = dayCount;
    }
}

ddDisplayNewWeatherReport();
function ddDisplayNewWeatherReport() {
    ddWeatherIcons.forEach((icon) => {
        if (icon.classList.contains("hide")) {
            icon.classList.remove("hide");
        }
    });
    ddTemp.innerText = Math.floor(Math.random() * (90 - 30 + 1)) + 30;
    let ddrandomWeather = Math.floor(Math.random() * 3);
    ddWeatherDesc.innerText = ddWeatherConditions[ddrandomWeather];
    ddWeatherIcons.forEach((icon, index) => {
        if (index != ddrandomWeather) {
            icon.classList.add("hide");
        }
    });
}

// Store the IDs of the elements in arrays
const circleIds = [
    "circleServer1",
    "circleServer2",
    "circleServer3",
    "circleServer4",
];
const runIds = ["runServer1", "runServer2", "runServer3", "runServer4"];
const dfIds = [
    "dataFlowServer1",
    "dataFlowServer2",
    "dataFlowServer3",
    "dataFlowServer4",
];
const scIds = [
    "sysCallsServer1",
    "sysCallsServer2",
    "sysCallsServer3",
    "sysCallsServer4",
];
const ipIds = ["IPServer1", "IPServer2", "IPServer3", "IPServer4"];
const serverIds = ["server1", "server2", "server3", "server4"];
const ddconnectionHP = [
    "connectionHP1",
    "connectionHP2",
    "connectionHP3",
    "connectionHP4",
];
const dddownloadSpeedHP = [
    "downloadSpeedHP1",
    "downloadSpeedHP2",
    "downloadSpeedHP3",
    "downloadSpeedHP4",
];
const dduploadSpeedHP = [
    "uploadSpeedHP1",
    "uploadSpeedHP2",
    "uploadSpeedHP3",
    "uploadSpeedHP4",
];

// Get the elements using loops
const servers = serverIds.map((id) => document.getElementById(id));
const circles = circleIds.map((id) => document.getElementById(id));
const runs = runIds.map((id) => document.getElementById(id));
const dfs = dfIds.map((id) => document.getElementById(id));
const scs = scIds.map((id) => document.getElementById(id));
const ips = ipIds.map((id) => document.getElementById(id));
const ddHPconnection = ddconnectionHP.map((id) => document.getElementById(id));
const ddHPdownloadSpeed = dddownloadSpeedHP.map((id) =>
    document.getElementById(id)
);
const ddHPuploadSpeed = dduploadSpeedHP.map((id) =>
    document.getElementById(id)
);

// Access the elements using loops
circles.forEach((circle) => circle.classList.add("off"));

var runCount = 1;
setInterval(function () {
    circles.forEach((circle) => circle.classList.toggle("off"));
    runs.forEach((run) => {
        switch (runCount) {
            case 1:
                run.innerText = "running.";
                break;
            case 2:
                run.innerText = "running..";
                break;
            case 3:
                run.innerText = "running...";
                break;
            default:
                run.innerText = "running";
        }
    });
    runCount = (runCount + 1) % 4;
}, 500);

var syscalls = [0, 0, 0, 0];
setInterval(function () {
    updateMonitor();
    const random_sys = Math.random() < 0.4;
    const random_ip = Math.random() < 0.2;
    const random_bit = Math.random() < 0.5;
    if (random_ip) {
        ips.forEach((ip) => (ip.innerText = generateRandomIP()));
    }
    if (random_sys) {
        for (let i = 0; i < scs.length; i++) {
            if (rand50()) {
                syscalls[i]++;
                scs[i].innerText = syscalls[i];
            }
        }
    }
    dfs.forEach((df, i) => {
        const bits = df.innerHTML;
        const newBit = random_bit ? "1" : "0";
        df.innerHTML = bits.substring(1) + newBit;
        if (i % 2 == 0) {
            df.innerHTML = dfs[0].innerHTML;
        } else {
            df.innerHTML = dfs[1].innerHTML;
        }
    });
}, 250);

function rand50() {
    return Math.random() < 0.5;
}

function generateRandomIP() {
    const IPAddresses = [
        "192.168.1.0",
        "192.132.9.1",
        "192.168.4.2",
        "192.168.1.3",
        "182.168.1.4",
        "154.17.1.0",
        "102.162.1.0",
        "192.18.10.0",
        "172.128.1.13",
    ];
    IP = IPAddresses[Math.floor(Math.random() * IPAddresses.length)];
    return IP;
}

//this is randomization for testing
servers.forEach((servers) => ddUpdateServer(servers));
setInterval(function () {
    servers.forEach((servers) => ddUpdateServer(servers));
}, 5000);

function ddUpdateServer(serv) {
    var servID = parseInt(serv.getAttribute("id").slice(-1)) - 1;
    var ddServerCondition = ddServState[servID];
    if (serv.classList.contains("error1")) {
        serv.classList.remove("error1");
        circles[servers.indexOf(serv)].classList.remove("Lighterror1");
    }
    if (serv.classList.contains("error2")) {
        serv.classList.remove("error2");
        circles[servers.indexOf(serv)].classList.remove("Lighterror2");
    }
    if (ddServerCondition == 1) {
        serv.classList.add("error1");
        circles[servers.indexOf(serv)].classList.add("Lighterror1");
    }
    if (ddServerCondition == 2) {
        serv.classList.add("error2");
        circles[servers.indexOf(serv)].classList.add("Lighterror2");
    }
}
function updateMonitor() {
    ddHPconnection.forEach((connSpeed) => {
        connSpeed.innerText = Math.floor(Math.random() * 101);
    });
    ddHPdownloadSpeed.forEach((downSpeed) => {
        downSpeed.innerHTML = Math.floor(Math.random() * 10001);
        +" KB/s";
    });
    ddHPuploadSpeed.forEach((upSpeed) => {
        upSpeed.innerHTML = Math.floor(Math.random() * 10001);
        +" KB/s";
    });
}

var ddOpenScreen = document.getElementById("ddOpenScreen");
const ddtabList = [
    "ddwebsitesList",
    "ddServerRoom",
    "ddcams",
    "ddreport",
    "ddMsg",
];
const ddTabs = ddtabList.map((id) => document.getElementById(id));
var placeholder;

function ddOpenTab(tab) {
    if (placeholder == tab) {
        ddOpenScreen.classList.remove("hide");
        placeholder = ddOpenScreen;
    } else {
        ddOpenScreen.classList.add("hide");
        ddTabs.forEach((tabs) => {
            if (!tabs.classList.contains("hide")) {
                tabs.classList.add("hide");
            }
        });
        ddTabs.forEach((tabs) => {
            if (tabs.classList.contains(tab)) {
                tabs.classList.remove("hide");
                placeholder = tab;
            }
        });
    }
}
// Define an array of objects with website information
const websites = [
    {
        name: "Website 1",
        domain: "www.website1.com",
        path: "/var/www/website1",
        ipAddress: "192.168.1.1",
        serverSoftware: "Apache",
        serverID: "Server 1",
        webStatus: 0,
    },
    {
        name: "Website 2",
        domain: "www.website2.com",
        path: "/var/www/website2",
        ipAddress: "192.168.1.2",
        serverSoftware: "Nginx",
        serverID: "Server 2",
        webStatus: 0,
    },
    {
        name: "Website 3",
        domain: "www.website3.com",
        path: "/var/www/website3",
        ipAddress: "192.168.1.3",
        serverSoftware: "Apache",
        serverID: "Server 3",
        webStatus: 0,
    },
    {
        name: "Website 4",
        domain: "www.website4.com",
        path: "/var/www/website4",
        ipAddress: "192.168.1.4",
        serverSoftware: "Apache",
        serverID: "Server 4",
        webStatus: 0,
    },
    {
        name: "Ben",
        domain: "www.ben.com",
        path: "/var/www/ben",
        ipAddress: "192.168.1.5",
        serverSoftware: "Apache",
        serverID: "Server 1",
        webStatus: 0,
    },
    {
        name: "Ryan",
        domain: "www.ryan.com",
        path: "/var/www/ryan",
        ipAddress: "192.168.1.6",
        serverSoftware: "Apache",
        serverID: "Server 3",
        webStatus: 0,
    },
    {
        name: "Jordan",
        domain: "www.jordan.com",
        path: "/var/www/ryan",
        ipAddress: "192.168.1.7",
        serverSoftware: "Apache",
        serverID: "Server 4",
        webStatus: 0,
    },
    {
        name: "Sean",
        domain: "www.sean.com",
        path: "/var/www/sean",
        ipAddress: "192.168.1.8",
        serverSoftware: "Apache",
        serverID: "Server 1",
        webStatus: 0,
    },
    {
        name: "Jacob",
        domain: "www.jacob.com",
        path: "/var/www/jacob",
        ipAddress: "192.168.1.9",
        serverSoftware: "Apache",
        serverID: "Server 3",
        webStatus: 0,
    },
];

// Get the tbody element of the table
const tbody = document.querySelector("#ddWebsitesTable tbody");
createWebsiteTable();
function createWebsiteTable() {
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
    for (let i = 0; i < websites.length; i++) {
        var color;
        if (i % 2 == 0) { color = "lightgrey"; }
        else { color = "white"; }

        const website = websites[i];
        const row = document.createElement("tr");
        row.style.backgroundColor = color;
        const statCell = document.createElement("td");
        statCell.classList.add('webDivCenter');
        const nameCell = document.createElement("td");
        const domainCell = document.createElement("td");
        const pathCell = document.createElement("td");
        const ipAddressCell = document.createElement("td");
        const serverSoftwareCell = document.createElement("td");
        const serverIDCell = document.createElement("td");
        const fileCell = document.createElement("td");

        const webStatcircle = document.createElement("div");
        webStatcircle.classList.add('ddWebStat');
        const ddWebStatcircleDesign = document.createElement("div");
        ddWebStatcircleDesign.classList.add('ddWebStatcircleDesign');
        webStatcircle.appendChild(ddWebStatcircleDesign);
        var webServState = ddServState[website.serverID.split('Server ')[1] - 1];
        if (website.webStatus == 0 && webServState == 0) { webStatcircle.classList.add('ddWebStatGood') }
        if (website.webStatus == 1 || webServState == 1 && website.webStatus != 2) { webStatcircle.classList.add('ddWebStatBad') }
        if (website.webStatus == 2 || webServState == 2) { webStatcircle.classList.add('ddWebStatTerrible') }
        statCell.appendChild(webStatcircle);

        nameCell.textContent = website.name;
        domainCell.textContent = website.domain;
        pathCell.textContent = website.path;
        ipAddressCell.textContent = website.ipAddress;
        serverSoftwareCell.textContent = website.serverSoftware;
        serverIDCell.textContent = website.serverID;
        fileCell.textContent = "\u{0001F4C1}";
        fileCell.classList.add("ddFile");
        fileCell.setAttribute("id", `file-${website.name}`);
        row.appendChild(statCell);
        row.appendChild(nameCell);
        row.appendChild(domainCell);
        row.appendChild(pathCell);
        row.appendChild(ipAddressCell);
        row.appendChild(serverSoftwareCell);
        row.appendChild(serverIDCell);
        row.appendChild(fileCell);
        tbody.appendChild(row);
    }
    ddAddFileListeners();
}
var ddWebFileList = document.getElementById('ddWebFilesList');
function ddAddFileListeners() {
    const files = document.querySelectorAll('.ddFile');
    files.forEach(file => {
        file.addEventListener('click', () => {
            document.getElementById('ddWebsitesTable').classList.add('hide');
            document.getElementById('ddWebFiles').classList.remove('hide');
            var ddWebNameFile = file.id.split('-');
            websites.forEach((websiteName) => {
                if (websiteName.name == ddWebNameFile[1]) {
                    webadderArray = websiteName.domain.split('.');
                    document.getElementById('ddWebFileName1').innerText = webadderArray[1];
                    document.getElementById('ddWebFileName2').innerText = webadderArray[1];
                    document.getElementById('ddWebFileName3').innerText = webadderArray[1];
                    document.getElementById('ddWebFileName4').innerText = webadderArray[1];
                    document.getElementById('ddWebFileName5').innerText = webadderArray[1];
                    if (ddMalwareArray.websiteDom == websiteName.domain) {
                        const ddWebFileMalwarelistItem = document.createElement("p");
                        ddWebFileMalwarelistItem.setAttribute("id", `ddmalwarefile`);
                        const ddWebFileMalwarefolder = document.createElement("span");
                        ddWebFileMalwarefolder.textContent = "\u{0001F4C1}";
                        const ddWebFileMalwarefolderName = document.createElement("span");
                        ddWebFileMalwarefolderName.textContent = ddMalwareArray.targetFile;
                        ddWebFileMalwarelistItem.appendChild(ddWebFileMalwarefolder);
                        ddWebFileMalwarelistItem.appendChild(ddWebFileMalwarefolderName);
                        ddWebFileList.appendChild(ddWebFileMalwarelistItem);
                    }
                }
            });
        });
    });
}
function ddBackToWebTable() {
    const elementsInsideBox = ddWebFileList.querySelectorAll("*");

    for (let i = 0; i < elementsInsideBox.length; i++) {
        const element = elementsInsideBox[i];
        if (element.id == "ddmalwarefile") {
            element.remove();
        }
    }
    document.getElementById('ddWebsitesTable').classList.remove('hide');
    document.getElementById('ddWebFiles').classList.add('hide');
}


const canvas = document.getElementById("ddGraphCanvas");
const ctx = canvas.getContext("2d");

var data = [10, 15, 40, 35, 30, 32, 25, 27, 9, 20, 23]; // Example data
let maxDataPoints = 10; // Maximum number of data points to display
let interval = 1000; // Interval in milliseconds between updates
let x = 0; // Starting x-coordinate

var ddPowerConsumpstion = 0;
var ddGraphColor;
var Cm = 0;
var ddGraphInt;
var ddLogInt;
function updateLogStatus(serverId) {
    // Update the status div minus connections made
    var ddLogConnection = Math.floor(Math.random() * 101);
    document.getElementById("logConnection").innerHTML = ddLogConnection + "%";
    document.getElementById("logDownloadSpeed").innerHTML = speeds() + " KB/s";
    document.getElementById("logUploadSpeed").innerHTML = speeds() + " KB/s";

    // Array of sample data for each table cell
    const requestMethods = ["GET", "POST", "PUT", "DELETE"];
    const urls = ["/home", "/about", "/services", "/contact"];
    const statusCodes = ["200", "404", "500"];
    const systemCalls = ["450", "500", "600", "800"];

    // Function to generate a random integer between min and max (inclusive)
    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
    function speeds() {
        return Math.floor(Math.random() * 10001);
    }
    function finalIPvalue() {
        var first = Math.floor(Math.random() * 192);
        var second = Math.floor(Math.random() * 99);
        var third = Math.floor(Math.random() * 256);
        var ip = first + "." + second + "." + third;
        return ip;
    }
    function returnDate() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, "0");
        const day = String(today.getDate()).padStart(2, "0");
        return `${year}-${month}-${day}`;
    }
    function returnTime(i) {
        const now = new Date();
        return `${now.getHours()}:${now.getMinutes()}:${now.getSeconds() + i}`;
    }

    // Loop through each table row and generate (mostly) random data for each cell
    const table = document.getElementById("ddlogTable");
    const rows = table.getElementsByTagName("tr");
        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName("td");
            cells[0].textContent = returnDate();
            cells[1].textContent = returnTime(i);
            switch (ddDoSArray.attackerIP) {
                case null:
                    cells[2].textContent = finalIPvalue();
                    break;
                default:
                    if (serverId == ddDoSArray.serverNumber.split('Server ')[1]) {
                        cells[2].textContent = ddDoSArray.attackerIP;
                    }
                    else{
                        cells[2].textContent = finalIPvalue();
                    }
                    break;
            }
            cells[3].textContent =
                requestMethods[getRandomInt(0, requestMethods.length - 1)];
            cells[5].textContent = urls[getRandomInt(0, urls.length - 1)];
            cells[6].textContent =
                statusCodes[getRandomInt(0, statusCodes.length - 1)];
            cells[7].textContent = speeds() + " KB/s";
            cells[8].textContent = speeds() + " KB/s";
            cells[9].textContent =
                systemCalls[getRandomInt(0, systemCalls.length - 1)];
        }
        Cm = Cm + Math.floor(Math.random() * 4);
        document.getElementById("logConnectionsMade").innerHTML = Cm;
}

function ddOpenLogs(ddserverId) {
    const ddlogsTable = document.getElementById('ddlogTableContainer')
    while(ddlogsTable.firstChild){ddlogsTable.removeChild(ddlogsTable.firstChild)}
    makeLog();
    updateLogStatus(ddserverId);
    if (ddserverId == "back") {
        clearInterval(ddGraphInt);
        clearInterval(ddLogInt);
    } else {
        document.getElementById("ddServerRoom").classList.add("hide");
        document.getElementById("ddtaskbar").classList.add("hide");
        document.getElementById("ddServerLogs").classList.remove("hide");
        document.getElementById("ddservid").innerText = ddserverId;
        var logState = ddServState[ddserverId - 1];
        if (logState == 0) {
            ddGraphColor = "rgba(0, 255, 0, 0.2)";
            data = [10, 15, 40, 35, 30, 32, 25, 27, 9, 20, 23];
        }
        if (logState == 1) {
            ddGraphColor = "rgba(255, 255, 0, 0.2)";
            data = [60, 70, 65, 75, 70, 82, 95, 77, 94, 60, 55];
        }
        if (logState == 2) {
            ddGraphColor = "rgba(255, 0, 0, 0.2)";
            data = [110, 115, 140, 135, 130, 132, 125, 127, 109, 120, 123];
        }
        // Clear canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        // Draw graph
        ctx.beginPath();
        ctx.moveTo(0, canvas.height - data[0]);
        for (let i = 0; i < data.length; i++) {
            x += canvas.width / maxDataPoints;
            ctx.lineTo(x, canvas.height - data[i]);
        }
        ctx.lineTo(canvas.width, canvas.height);
        ctx.lineTo(0, canvas.height);
        ctx.fillStyle = ddGraphColor;
        ctx.fill();
        ctx.stroke();

        /*
        should update later so that instead of looking at ddDoSArray look at server status, can then check for
        different attack types.
        */
        switch (ddDoSArray.serverNumber) {
            case null:
                ddLogInt = setInterval(function() {
                    updateLogStatus(ddserverId);
                  }, 500);
                break;
            default:
                if (ddserverId == ddDoSArray.serverNumber.split('Server ')[1]) {
                    ddLogInt = setInterval(function() {
                      updateLogStatus(ddserverId);
                    }, 100);
                  } else {
                    ddLogInt = setInterval(function() {
                      updateLogStatus(ddserverId);
                    }, 500);
                  }
                break;
        }
        

        ddGraphInt = setInterval(() => {
            // Update data
            logState = ddServState[ddserverId - 1];
            ddCheckLogClassList(logState);
            data.shift();
            if (logState == 0) {
                ddGraphColor = "rgba(0, 255, 0, 0.2)";
                data.push(Math.floor(Math.random() * 50));
            }
            if (logState == 1) {
                ddGraphColor = "rgba(255, 255, 0, 0.2)";
                data.push(Math.floor(Math.random() * 50) + 50);
            }
            if (logState == 2) {
                ddGraphColor = "rgba(255, 0, 0, 0.2)";
                data.push(Math.floor(Math.random() * 50) + 100);
            }

            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            // Draw graph
            ctx.beginPath();
            ctx.moveTo(0, canvas.height - data[0]);
            for (let i = 0; i < data.length; i++) {
                x += canvas.width / maxDataPoints;
                ctx.lineTo(x, canvas.height - data[i]);
            }
            ctx.lineTo(canvas.width, canvas.height);
            ctx.lineTo(0, canvas.height);
            ctx.fillStyle = ddGraphColor;
            ctx.fill();
            ctx.stroke();

            // Reset x-coordinate if necessary
            //if (x > 11) {
            x = 0;
            //}
        }, interval);
    }
}
var ddCurrentLogColor = document.getElementById("ddServerLogs");
function ddCheckLogClassList(ddUpdateLogColor) {
    if (ddCurrentLogColor.classList.contains("ddLogYellow")) {
        ddCurrentLogColor.classList.remove("ddLogYellow");
    }
    if (ddCurrentLogColor.classList.contains("ddLogRed")) {
        ddCurrentLogColor.classList.remove("ddLogRed");
    }
    if (ddUpdateLogColor == 1) {
        ddCurrentLogColor.classList.add("ddLogYellow");
    }
    if (ddUpdateLogColor == 2) {
        ddCurrentLogColor.classList.add("ddLogRed");
    }
}
function ddlogBack() {
    document.getElementById("ddServerRoom").classList.remove("hide");
    document.getElementById("ddtaskbar").classList.remove("hide");
    document.getElementById("ddServerLogs").classList.add("hide");
    ddOpenLogs("back");
}

function addMessage(ddMsgSender, ddDateMessage, ddwebsiteName, ddMessage) {
    const senderContainer = document.querySelector(".ddSenderContainer");
    const messageContainer = document.querySelector(".ddMessage");

    // Create a new sender box element
    const senderBox = document.createElement("div");
    senderBox.classList.add("ddDomainSender");

    // Add click event listener to the sender box
    senderBox.addEventListener("click", () => {
        if (messageContainer.classList.contains("hide")) {
            messageContainer.classList.remove("hide");
        }
        // Remove the active class from all sender boxes
        const activeSenders = document.querySelectorAll(".ddDomainSender.active");
        activeSenders.forEach((sender) => {
            sender.classList.remove("active");
        });

        // Add the active class to the clicked sender box
        senderBox.classList.add("active");

        // Remove all existing messages from the message container
        messageContainer.innerHTML = "";

        // Create a new message div element
        const messageWholeDiv = document.createElement("div");
        messageWholeDiv.classList.add("ddMessageDiv");

        // Add the message content to the message div
        const messageFromDiv = document.createElement("div");
        const messageSentDiv = document.createElement("div");
        const messageDomainDiv = document.createElement("div");
        //add \r\n in text everywhere You want for line-break (new line)
        messageFromDiv.textContent = "From: " + ddMsgSender + "\r\n";
        messageWholeDiv.appendChild(messageFromDiv);
        messageWholeDiv.appendChild(document.createElement("hr"));
        messageSentDiv.textContent = "Sent on: " + ddDateMessage + "\r\n";
        messageWholeDiv.appendChild(messageSentDiv);
        messageWholeDiv.appendChild(document.createElement("hr"));
        messageDomainDiv.textContent = "Website Domain: " + ddwebsiteName + "\r\n";
        messageWholeDiv.appendChild(messageDomainDiv);
        messageWholeDiv.appendChild(document.createElement("hr"));

        const messageDiv = document.createElement("div");
        messageDiv.textContent = ddMessage;
        messageWholeDiv.appendChild(messageDiv);

        // Add the message div to the message container
        messageContainer.appendChild(messageWholeDiv);
    });

    // Add the sender name and date to the sender box
    const senderNameDiv = document.createElement("div");
    senderNameDiv.classList.add("ddMessageSender");
    senderNameDiv.textContent = ddMsgSender;

    const messageDateDiv = document.createElement("div");
    messageDateDiv.classList.add("ddmessageDate");
    messageDateDiv.textContent = ddDateMessage;

    senderBox.appendChild(senderNameDiv);
    senderBox.appendChild(messageDateDiv);

    // Add the website name to the sender box
    const websiteNameDiv = document.createElement("div");
    websiteNameDiv.textContent = ddwebsiteName;
    senderBox.appendChild(websiteNameDiv);

    // Insert the sender box at the top of the sender container
    senderContainer.insertBefore(senderBox, senderContainer.firstChild);

    // Scroll the sender container to the top
    senderContainer.scrollTop = 0;
    // Scroll the sender container to the bottom
    //senderContainer.scrollTop = senderContainer.scrollHeight;
}

addMessage(
    "staff",
    `Day 001 9:00 AM`,
    "www.staff.com",
    `Welcome To Data Defenders! staff`
);

function intMsg() {
    var name = ["Ryan", "Ben", "Jacob", "Jordan", "Sean"];
    var web = [
        "www.ryan.com",
        "www.ben.com",
        "www.jacob.com",
        "www.jordan.com",
        "www.sean.com",
    ];
    let randomIndex = Math.floor(Math.random() * 5);

    var msgEx = [
        "I am having network Problems",
        "I cant seem to open files",
        "URGENT my computer is very slow",
        "Thanks for the help",
        "Can you help me? join the voice call",
    ];
    let randomMsg = Math.floor(Math.random() * 5);
    var minMsg = minuteCount;
    var dayMsg = dayCount;
    if (minuteCount < 10) {
        minMsg = "0" + minuteCount;
    }
    if (dayCount < 10) {
        dayMsg = "00" + dayCount;
    } else if (dayCount < 100) {
        dayMsg = "0" + dayCount;
    }
    addMessage(
        name[randomIndex],
        `Day ${dayMsg} ${hourCount}:${minMsg} ${dayhalf}`,
        web[randomIndex],
        msgEx[randomMsg]
    );
}

// new content
// Info Book on/off
function displayInfoBooklet() {
    document.getElementById("ddInfoBook").classList.toggle("hide");
}
function displayddNotes() {
    document.getElementById("ddNotes").classList.toggle("hide");
  }
  
  function makeDraggable(elmnt) {
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  
    elmnt.querySelector(".ddDraggable").onmousedown = dragMouseDown;
  
    function dragMouseDown(e) {
      e = e || window.event;
      e.preventDefault();
      pos3 = e.clientX;
      pos4 = e.clientY;
      document.onmouseup = closeDragElement;
      document.onmousemove = elementDrag;
    }
  
    function elementDrag(e) {
      e = e || window.event;
      e.preventDefault();
      pos1 = pos3 - e.clientX;
      pos2 = pos4 - e.clientY;
      pos3 = e.clientX;
      pos4 = e.clientY;
      elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
      elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
      if (elmnt.offsetTop < 350) {
        elmnt.style.top = "350px";
    } else if (elmnt.offsetTop > window.innerHeight+250) {
        //elmnt.style.top = "950px";;
        elmnt.style.top= (window.innerHeight+250)+"px"
    }
    if (elmnt.offsetLeft < 0) {
        elmnt.style.left = "0px";
    } else if (elmnt.offsetLeft > window.innerWidth+100) {
        elmnt.style.left = (window.innerWidth+100)+"px"
    }
    }
  
    function closeDragElement() {
      document.onmouseup = null;
      document.onmousemove = null;
    }
  }
  
  function startDrag() {
    var notes = document.querySelector("#ddNotes");
    var notes = document.querySelector("#ddInfoBook");
    notes.style.zIndex = 10;
  }
  
  makeDraggable(document.getElementById("ddNotes"));
  makeDraggable(document.getElementById("ddInfoBook"));

var current_page = 1;

//book turn page
function turnPageUp() {
    if (current_page < 5) {
        document.getElementById("C" + current_page).classList.add("hide");
        current_page++;
        document.getElementById("C" + current_page).classList.remove("hide");
    }
}

function turnPageDown() {
    if (current_page > 1) {
        document.getElementById("C" + current_page).classList.add("hide");
        current_page--;
        document.getElementById("C" + current_page).classList.remove("hide");
    }
}

//Add money
var money = 0;
document.getElementById("ddMoney").innerText = money;

function changeMoney() {
    var temp = 0;
    ddServState.forEach(function (element) {
        if (element == 0) {
            temp += 5000;
        }
        if (element == 2) {
            temp -= 362;
        }
    });
    money += temp;
    document.getElementById("ddMoney").innerText = money;
}

setInterval(changeMoney, 1000);

var ddAttackArray = [
    {
        TypeOfAttack: null,
        attackID: 0,
    },
    {
        TypeOfAttack: null,
        attackID: 1,
    },
    {
        TypeOfAttack: null,
        attackID: 2,
    },
];

var ddAttackCount = 0;

function dd_generateAttack() {
    if (ddAttackArray.length < 2) {
        //randomize possible attacks (DoS is only attack, will change later)
        //update attack array
        const chooseAttack = Math.random() < 0.5;
        if (chooseAttack) { dd_createDoS(ddAttackArray[ddAttackCount].attackID); }
        else { dd_createMalware(ddAttackArray[ddAttackCount].attackID); }
    }
}

function dd_solvedAttack() {
    ddAttackCount--;
}

var ddDoSArray =
{
    attackID: null,
    attackerIP: null,
    websiteDom: null,
    serverNumber: null,
};


function dd_createDoS() {
    if (ddAttackCount != 2 && ddDoSArray.attackID == null) {
        ddDoSArray.attackID = ddAttackCount;
        var ddAttackedWebsite = websites[Math.floor(Math.random() * websites.length)];
        ddDoSArray.websiteDom = ddAttackedWebsite.domain;
        ddDoSArray.serverNumber = ddAttackedWebsite.serverID;

        var first = Math.floor(Math.random() * 192);
        var second = Math.floor(Math.random() * 99);
        var third = Math.floor(Math.random() * 256);
        var ip = first + "." + second + "." + third;
        ddDoSArray.attackerIP = ip;

        var serverChangeid = ddDoSArray.serverNumber.split('Server ')[1];
        ddAttackedWebsite.webStatus = 1
        ddServState[serverChangeid - 1] = 1
        createWebsiteTable();
        ddAttackCount++;
        console.log(ddDoSArray)
        //update website table for all websites connected to down server
        //in effected server display random attacker IP and website IP
        //send message from all people in using effected server that it is running slow
    }
}

const ddComplaintsDoS = [
    "I can't access my website at all!",
    "My website is incredibly slow!",
    "My website keeps going down for short periods of time!",
    "I keep getting error messages when I try to access my website!",
    "My customers are complaining that my website is unusable!",
    "My website has been down for hours, what's going on?!",
    "I'm losing money because my website isn't working properly!",
    "My website is under attack and I don't know what to do!",
    "I'm getting flooded with requests and my website can't handle it!",
    "I think I'm being targeted by a DDoS attack!"
];

var ddMalwareArray = {
    attackID: null,
    websiteDom: null,
    serverNumber: null,
    targetFile: null,
};
function dd_createMalware() {
    if (ddAttackCount != 2 && ddMalwareArray.attackID == null) {
        ddMalwareArray.attackID = ddAttackCount;
        var ddAttackedWebsite = websites[Math.floor(Math.random() * websites.length)];
        ddMalwareArray.websiteDom = ddAttackedWebsite.domain;
        ddMalwareArray.serverNumber = ddAttackedWebsite.serverID;
        ddMalwareArray.targetFile = malwareFiles[Math.floor(Math.random() * malwareFiles.length)];
        var serverChangeid = ddMalwareArray.serverNumber.split('Server ')[1];
        ddAttackedWebsite.webStatus = 2
        ddServState[serverChangeid - 1] = 1
        console.log(ddMalwareArray)
        createWebsiteTable();
        ddAttackCount++;
        websites.forEach((website) => {
            if (ddAttackedWebsite.domain == website.domain) {
                addMessage(
                    website.name,
                    ddReturnDayAndTime(),
                    website.domain,
                    ddpopUpAds[Math.floor(Math.random() * ddpopUpAds.length)]
                );
            }
            else if (website.serverID.split('Server ')[1] == serverChangeid) {
                addMessage(
                    website.name,
                    ddReturnDayAndTime(),
                    website.domain,
                    ddWebsiteRunningSlow[Math.floor(Math.random() * ddWebsiteRunningSlow.length)]
                );
            }
        });
    }
}
function ddReturnDayAndTime() {
    var minMsg = minuteCount;
    var dayMsg = dayCount;
    if (minuteCount < 10) {
        minMsg = "0" + minuteCount;
    }
    if (dayCount < 10) {
        dayMsg = "00" + dayCount;
    } else if (dayCount < 100) {
        dayMsg = "0" + dayCount;
    }
    return `Day ${dayMsg} ${hourCount}:${minMsg} ${dayhalf}`;
}

var malwareFiles = ["secure.jar", "setup.exe", "keygen.exe", "patch.exe", "virus.exe", "trojan.exe", "ransomware.exe",
    "spyware.exe", "adware.exe", "rootkit.exe", "backdoor.exe", "exploit.doc", "payload.exe", "worm.exe", "exploit.js", "exploit.php", "exploit.asp"];
const ddWebsiteRunningSlow = [
    "My website is taking forever to load",
    "Why is my website so slow?",
    "I'm experiencing slow website performance",
    "My website is crawling along",
    "Is anyone else having trouble with my slow website?",
    "Why does my website load so slowly?",
    "My website is lagging",
    "My website is sluggish",
    "My website is dragging its feet",
    "What's causing my website to be so slow?",
    "My website is moving at a snail's pace",
    "My website is struggling to load",
    "I'm frustrated with how slow my website is",
    "My website is really dragging",
    "Why is my website taking so long to load?",
    "My website's speed is unacceptable",
    "My website is moving like molasses",
    "My website is barely loading",
    "Why is my website's performance so poor?",
    "My website's speed is a major problem"
];
const ddpopUpAds = [
    "My website is being bombarded with pop-up ads",
    "Why are there so many pop-up ads on my website?",
    "My website is inundated with annoying pop-up ads",
    "I can't use my website because of all the pop-up ads",
    "My website is plagued by pop-up ads",
    "Why is my website suddenly showing so many pop-up ads?",
    "I'm seeing too many pop-up ads on my website",
    "My website is being overrun by pop-up ads",
    "I'm fed up with the constant pop-up ads on my website",
    "My website is practically unusable because of the pop-up ads",
    "Why are there so many intrusive pop-up ads on my website?",
    "My website is littered with pop-up ads",
    "I'm getting bombarded with pop-up ads on my website",
    "My website is experiencing a pop-up ad epidemic",
    "I'm frustrated with the overwhelming amount of pop-up ads on my website",
    "My website is being hijacked by pop-up ads",
    "Why is my website displaying so many annoying pop-up ads?",
    "My website is completely overrun with pop-up ads",
    "I'm about ready to abandon my website because of the pop-up ads",
    "My website is making it impossible to get anything done with all the pop-up ads"
];

var ddReportFormContainer = document.getElementById('ddReportFormContainer');
var malQuestionArray = []

function createDoSForm() {
    document.getElementById('ddReportType').classList.add('hide');
    ddReportFormContainer.classList.remove('hide');
    document.getElementById('ddDeleteReportForm').classList.remove('hide');

    const ddForm = document.createElement('form');
    ddForm.classList.add('ddReportform');

    const ddReportheader = document.createElement('h1');
    ddReportheader.classList.add('ddreportHeader')
    ddReportheader.textContent = 'Denial of Service Report Form';
    ddForm.appendChild(ddReportheader);
    ddForm.appendChild(document.createElement('hr'));
    const websiteLabel = document.createElement('label');
    websiteLabel.textContent = 'Website Domain:';
    const websiteInput = document.createElement('input');
    websiteInput.type = 'text';
    websiteInput.name = 'website-domain';
    websiteInput.required = true;
    websiteLabel.appendChild(websiteInput);
    ddForm.appendChild(websiteLabel);
    ddForm.appendChild(document.createElement('br'));

    const serverLabel = document.createElement('label');
    serverLabel.textContent = 'Affected Server ID:';
    const serverSelect = document.createElement('select');
    serverSelect.name = 'affected-server-id';
    serverSelect.required = true;
    const option1 = document.createElement('option');
    option1.value = '1';
    option1.textContent = 'Server 1';
    serverSelect.appendChild(option1);
    const option2 = document.createElement('option');
    option2.value = '2';
    option2.textContent = 'Server 2';
    serverSelect.appendChild(option2);
    const option3 = document.createElement('option');
    option3.value = '3';
    option3.textContent = 'Server 3';
    serverSelect.appendChild(option3);
    const option4 = document.createElement('option');
    option4.value = '4';
    option4.textContent = 'Server 4';
    serverSelect.appendChild(option4);
    serverLabel.appendChild(serverSelect);
    ddForm.appendChild(serverLabel);
    ddForm.appendChild(document.createElement('br'));
    ddForm.appendChild(document.createElement('br'));

    const DoDAttackerLabel = document.createElement('label');
    DoDAttackerLabel.textContent = 'Attacker IP Address:';
    const attackerDoSIPInput = document.createElement('input');
    attackerDoSIPInput.type = 'text';
    attackerDoSIPInput.name = 'malware-file-name';
    attackerDoSIPInput.required = true;
    DoDAttackerLabel.appendChild(attackerDoSIPInput);
    ddForm.appendChild(DoDAttackerLabel);
    ddForm.appendChild(document.createElement('br'));

    const fixLabel = document.createElement('label');
    fixLabel.textContent = 'Suggested Fix:';

    const randomNumCorrect = Math.floor(Math.random() * 4);

    var ddReportQuestionArray = []
    var ddReportQIndex = 0

    for (let i = 0; i <= randomNumCorrect; i++) {
        ddReportQuestionArray[i] = { response: ddCorrectDoSResponses[Math.floor(Math.random() * ddCorrectDoSResponses.length)], correct: true }
        ddReportQIndex++;
    }
    while (ddReportQuestionArray.length <= 3) {
        ddReportQuestionArray[ddReportQIndex] = { response: ddWrongDoSResponses[Math.floor(Math.random() * ddWrongDoSResponses.length)], correct: false }
        ddReportQIndex++
    }

    ddReportQuestionArray = ddReportQuestionArray.sort(() => Math.random() - .5);
    console.log(ddReportQuestionArray)

    const checkbox1 = document.createElement('input');
    checkbox1.type = 'checkbox';
    checkbox1.name = 'fix-option-1';
    const label1 = document.createElement('label');
    checkbox1.value = ddReportQuestionArray[0].correct;
    label1.textContent = 'Option 1';
    label1.appendChild(checkbox1);
    const suggest1 = document.createElement('span');
    suggest1.innerText = ddReportQuestionArray[0].response;
    label1.appendChild(suggest1);

    const checkbox2 = document.createElement('input');
    checkbox2.type = 'checkbox';
    checkbox2.name = 'fix-option-2';
    const label2 = document.createElement('label');
    label2.textContent = 'Option 2';
    checkbox2.value = ddReportQuestionArray[1].correct;
    label2.appendChild(checkbox2);
    const suggest2 = document.createElement('span');
    suggest2.innerText = ddReportQuestionArray[1].response;
    label2.appendChild(suggest2);

    const checkbox3 = document.createElement('input');
    checkbox3.type = 'checkbox';
    checkbox3.name = 'fix-option-3';
    const label3 = document.createElement('label');
    label3.textContent = 'Option 3';
    checkbox3.value = ddReportQuestionArray[2].correct;
    label3.appendChild(checkbox3);
    const suggest3 = document.createElement('span');
    suggest3.innerText = ddReportQuestionArray[2].response;
    label3.appendChild(suggest3);

    const checkbox4 = document.createElement('input');
    checkbox4.type = 'checkbox';
    checkbox4.name = 'fix-option-4';
    const label4 = document.createElement('label');
    label4.textContent = 'Option 4';
    checkbox4.value = ddReportQuestionArray[3].correct;
    label4.appendChild(checkbox4);
    const suggest4 = document.createElement('span');
    suggest4.innerText = ddReportQuestionArray[3].response;
    label4.appendChild(suggest4);

    fixLabel.appendChild(document.createElement('hr'));
    fixLabel.appendChild(label1);
    fixLabel.appendChild(document.createElement('hr'));
    fixLabel.appendChild(label2);
    fixLabel.appendChild(document.createElement('hr'));
    fixLabel.appendChild(label3);
    fixLabel.appendChild(document.createElement('hr'));
    fixLabel.appendChild(label4);
    fixLabel.appendChild(document.createElement('hr'));
    ddForm.appendChild(fixLabel);
    ddForm.appendChild(document.createElement('br'));
    // create the signature input field and add it to the form
    const signatureLabel = document.createElement('label');
    signatureLabel.textContent = 'Signature:';
    const signatureInput = document.createElement('input');
    signatureInput.type = 'text';
    signatureInput.name = 'signature';
    signatureInput.required = true;
    signatureLabel.appendChild(signatureInput);
    ddForm.appendChild(signatureLabel);
    const submitButton = document.createElement('button');
    submitButton.type = 'submit';
    submitButton.textContent = 'Report';
    submitButton.classList.add('ddMalSubmit');
    const malSubmit = document.createElement('div');
    malSubmit.classList.add('ddreportSumbit')
    malSubmit.appendChild(submitButton);
    ddForm.appendChild(malSubmit);



    // add the form to the document
    ddReportFormContainer.appendChild(ddForm);

    ddForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const websiteDomain = websiteInput.value;
        const affectedServerId = serverSelect.value;
        const ddAttackerIP = attackerDoSIPInput.value;
        var ddDoSCheckboxArray = [false, false, false, false];
        var ddMalnumcorrect = 0;
        if (checkbox1.checked) {
            ddDoSCheckboxArray[0] = true;
        }
        if (checkbox2.checked) {
            ddDoSCheckboxArray[1] = true;
        }
        if (checkbox3.checked) {
            ddDoSCheckboxArray[2] = true;
        }
        if (checkbox4.checked) {
            ddDoSCheckboxArray[3] = true;
        }

        for (let i = 0; i <= 3; i++) {
            if (ddDoSCheckboxArray[i] == ddReportQuestionArray[i].correct) {
                ddMalnumcorrect++;
            }
        }
        var malPercent = (ddMalnumcorrect / 4) * 100
        console.log(ddMalnumcorrect)

        const signature = signatureInput.value;

        // Do something with the form data here

        if (ddDoSArray.attackID != null) {
            if (ddDoSArray.serverNumber.split('Server ')[1] == affectedServerId) {
                if (ddDoSArray.websiteDom == websiteDomain) {
                    if (ddDoSArray.attackerIP == ddAttackerIP) {
                        var ddMalResetWebsiteID = ddDoSArray.websiteDom
                        websites.forEach((website) => {
                            if (website.domain == ddMalResetWebsiteID) {
                                var serverStatIndex = website.serverID.split('Server ')[1];
                                website.webStatus = 0
                                ddServState[serverStatIndex - 1] = 0;
                                ddAttackCount--;
                            }
                        });
                        ddDoSArray.attackID = null;
                        ddDoSArray.websiteDom = null;
                        ddDoSArray.serverNumber = null;
                        ddDoSArray.targetFile = null;
                        createWebsiteTable();
                    }
                    else {
                        addMessage(
                            ddSystemMsg.name,
                            ddReturnDayAndTime(),
                            ddSystemMsg.addr,
                            "There is no attacker with that ID")
                    }
                }
                else {
                    addMessage(
                        ddSystemMsg.name,
                        ddReturnDayAndTime(),
                        ddSystemMsg.addr,
                        "incorrect website domain")
                }
            }
            else {
                addMessage(
                    ddSystemMsg.name,
                    ddReturnDayAndTime(),
                    ddSystemMsg.addr,
                    "incorrect server id")
            }
        }
        else {
            addMessage(
                ddSystemMsg.name,
                ddReturnDayAndTime(),
                ddSystemMsg.addr,
                "there are no DoS attacks")
        }
        ddForm.reset();
        removeReportForm();
    });
}

function createMalwareForm() {
    document.getElementById('ddReportType').classList.add('hide');
    ddReportFormContainer.classList.remove('hide');
    document.getElementById('ddDeleteReportForm').classList.remove('hide');

    const ddForm = document.createElement('form');
    ddForm.classList.add('ddReportform');

    const ddReportheader = document.createElement('h1');
    ddReportheader.classList.add('ddreportHeader')
    ddReportheader.textContent = 'Malware Report Form';
    ddForm.appendChild(ddReportheader);
    ddForm.appendChild(document.createElement('hr'));
    const websiteLabel = document.createElement('label');
    websiteLabel.textContent = 'Website Domain:';
    const websiteInput = document.createElement('input');
    websiteInput.type = 'text';
    websiteInput.name = 'website-domain';
    websiteInput.required = true;
    websiteLabel.appendChild(websiteInput);
    ddForm.appendChild(websiteLabel);
    ddForm.appendChild(document.createElement('br'));

    const serverLabel = document.createElement('label');
    serverLabel.textContent = 'Affected Server ID:';
    const serverSelect = document.createElement('select');
    serverSelect.name = 'affected-server-id';
    serverSelect.required = true;
    const option1 = document.createElement('option');
    option1.value = '1';
    option1.textContent = 'Server 1';
    serverSelect.appendChild(option1);
    const option2 = document.createElement('option');
    option2.value = '2';
    option2.textContent = 'Server 2';
    serverSelect.appendChild(option2);
    const option3 = document.createElement('option');
    option3.value = '3';
    option3.textContent = 'Server 3';
    serverSelect.appendChild(option3);
    const option4 = document.createElement('option');
    option4.value = '4';
    option4.textContent = 'Server 4';
    serverSelect.appendChild(option4);
    serverLabel.appendChild(serverSelect);
    ddForm.appendChild(serverLabel);
    ddForm.appendChild(document.createElement('br'));
    ddForm.appendChild(document.createElement('br'));

    const malwareLabel = document.createElement('label');
    malwareLabel.textContent = 'Malware File Name:';
    const malwareInput = document.createElement('input');
    malwareInput.type = 'text';
    malwareInput.name = 'malware-file-name';
    malwareInput.required = true;
    malwareLabel.appendChild(malwareInput);
    ddForm.appendChild(malwareLabel);
    ddForm.appendChild(document.createElement('br'));

    const fixLabel = document.createElement('label');
    fixLabel.textContent = 'Suggested Fix:';

    const randomNumCorrect = Math.floor(Math.random() * 4);

    var malQuestionArray = []
    var ddMalQIndex = 0

    for (let i = 0; i <= randomNumCorrect; i++) {
        malQuestionArray[i] = { response: ddCorrectMalwareResponses[Math.floor(Math.random() * ddCorrectMalwareResponses.length)], correct: true }
        ddMalQIndex++;
    }
    while (malQuestionArray.length <= 3) {
        malQuestionArray[ddMalQIndex] = { response: ddWrongMalwareResponses[Math.floor(Math.random() * ddWrongMalwareResponses.length)], correct: false }
        ddMalQIndex++
    }

    malQuestionArray = malQuestionArray.sort(() => Math.random() - .5);
    console.log(malQuestionArray)

    const checkbox1 = document.createElement('input');
    checkbox1.type = 'checkbox';
    checkbox1.name = 'fix-option-1';
    const label1 = document.createElement('label');
    checkbox1.value = malQuestionArray[0].correct;
    label1.textContent = 'Option 1';
    label1.appendChild(checkbox1);
    const suggest1 = document.createElement('span');
    suggest1.innerText = malQuestionArray[0].response;
    label1.appendChild(suggest1);

    const checkbox2 = document.createElement('input');
    checkbox2.type = 'checkbox';
    checkbox2.name = 'fix-option-2';
    const label2 = document.createElement('label');
    label2.textContent = 'Option 2';
    checkbox2.value = malQuestionArray[1].correct;
    label2.appendChild(checkbox2);
    const suggest2 = document.createElement('span');
    suggest2.innerText = malQuestionArray[1].response;
    label2.appendChild(suggest2);

    const checkbox3 = document.createElement('input');
    checkbox3.type = 'checkbox';
    checkbox3.name = 'fix-option-3';
    const label3 = document.createElement('label');
    label3.textContent = 'Option 3';
    checkbox3.value = malQuestionArray[2].correct;
    label3.appendChild(checkbox3);
    const suggest3 = document.createElement('span');
    suggest3.innerText = malQuestionArray[2].response;
    label3.appendChild(suggest3);

    const checkbox4 = document.createElement('input');
    checkbox4.type = 'checkbox';
    checkbox4.name = 'fix-option-4';
    const label4 = document.createElement('label');
    label4.textContent = 'Option 4';
    checkbox4.value = malQuestionArray[3].correct;
    label4.appendChild(checkbox4);
    const suggest4 = document.createElement('span');
    suggest4.innerText = malQuestionArray[3].response;
    label4.appendChild(suggest4);

    fixLabel.appendChild(document.createElement('hr'));
    fixLabel.appendChild(label1);
    fixLabel.appendChild(document.createElement('hr'));
    fixLabel.appendChild(label2);
    fixLabel.appendChild(document.createElement('hr'));
    fixLabel.appendChild(label3);
    fixLabel.appendChild(document.createElement('hr'));
    fixLabel.appendChild(label4);
    fixLabel.appendChild(document.createElement('hr'));
    ddForm.appendChild(fixLabel);
    ddForm.appendChild(document.createElement('br'));
    // create the signature input field and add it to the form
    const signatureLabel = document.createElement('label');
    signatureLabel.textContent = 'Signature:';
    const signatureInput = document.createElement('input');
    signatureInput.type = 'text';
    signatureInput.name = 'signature';
    signatureInput.required = true;
    signatureLabel.appendChild(signatureInput);
    ddForm.appendChild(signatureLabel);
    const submitButton = document.createElement('button');
    submitButton.type = 'submit';
    submitButton.textContent = 'Report';
    submitButton.classList.add('ddMalSubmit');
    const malSubmit = document.createElement('div');
    malSubmit.classList.add('ddreportSumbit')
    malSubmit.appendChild(submitButton);
    ddForm.appendChild(malSubmit);



    // add the form to the document
    ddReportFormContainer.appendChild(ddForm);

    ddForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const websiteDomain = websiteInput.value;
        const affectedServerId = serverSelect.value;
        const malwareFileName = malwareInput.value;
        var ddMalCheckboxArray = [false, false, false, false];
        var ddMalnumcorrect = 0;
        if (checkbox1.checked) {
            ddMalCheckboxArray[0] = true;
        }
        if (checkbox2.checked) {
            ddMalCheckboxArray[1] = true;
        }
        if (checkbox3.checked) {
            ddMalCheckboxArray[2] = true;
        }
        if (checkbox4.checked) {
            ddMalCheckboxArray[3] = true;
        }

        for (let i = 0; i <= 3; i++) {
            if (ddMalCheckboxArray[i] == malQuestionArray[i].correct) {
                ddMalnumcorrect++;
            }
        }
        var malPercent = (ddMalnumcorrect / 4) * 100
        //console.log(ddMalnumcorrect)

        const signature = signatureInput.value;

        // Do something with the form data here
        // console.log("inputted:")
        // console.log("Website Domain: " + websiteDomain)
        // console.log("Affected Server: " + affectedServerId)
        // console.log("Malware File Name: " + malwareFileName)
        // console.log("Percentage Correct: " + malPercent)
        // console.log("Signature: " + signature)

        if (ddMalwareArray.attackID != null) {
            if (ddMalwareArray.serverNumber.split('Server ')[1] == affectedServerId) {
                if (ddMalwareArray.websiteDom == websiteDomain) {
                    if (ddMalwareArray.targetFile == malwareFileName) {
                        var ddMalResetWebsiteID = ddMalwareArray.websiteDom
                        websites.forEach((website) => {
                            if (website.domain == ddMalResetWebsiteID) {
                                var serverStatIndex = website.serverID.split('Server ')[1];
                                website.webStatus = 0
                                ddServState[serverStatIndex - 1] = 0;
                                ddAttackCount--;
                            }
                        });
                        ddMalwareArray.attackID = null;
                        ddMalwareArray.websiteDom = null;
                        ddMalwareArray.serverNumber = null;
                        ddMalwareArray.targetFile = null;
                        createWebsiteTable();
                    }
                    else {
                        addMessage(
                            ddSystemMsg.name,
                            ddReturnDayAndTime(),
                            ddSystemMsg.addr,
                            "There is no Malware File with that File Name")
                    }
                }
                else {
                    addMessage(
                        ddSystemMsg.name,
                        ddReturnDayAndTime(),
                        ddSystemMsg.addr,
                        "incorrect website domain")
                }
            }
            else {
                addMessage(
                    ddSystemMsg.name,
                    ddReturnDayAndTime(),
                    ddSystemMsg.addr,
                    "incorrect server id")
            }
        }
        else {
            addMessage(
                ddSystemMsg.name,
                ddReturnDayAndTime(),
                ddSystemMsg.addr,
                "there are no malware attacks")
        }
        ddForm.reset();
        removeReportForm();
    });
}
function removeReportForm() {
    while (ddReportFormContainer.firstChild) {
        ddReportFormContainer.removeChild(ddReportFormContainer.firstChild);
    }
    document.getElementById('ddReportType').classList.remove('hide');
    ddReportFormContainer.classList.add('hide');
    document.getElementById('ddDeleteReportForm').classList.add('hide');
}
const ddCorrectDoSResponses = ["Identify the source of the attack and block traffic from that source.",
    "Configure firewalls and routers to drop packets associated with the attack.",
    "Limit the impact of the attack by reducing the traffic to critical systems.",
    "Monitor traffic patterns to detect and mitigate the attack in real-time.",
    "Work with upstream service providers to filter traffic before it reaches your network.",
    "Use rate-limiting or traffic-shaping to limit the impact of the attack.",
    "Deploy additional servers or network capacity to handle the increased traffic.",
    "Implement access control lists (ACLs) to block traffic from known bad sources.",
    "Distribute traffic across multiple servers to reduce the impact of the attack.",
    "Use content distribution networks (CDNs) to absorb traffic and protect critical systems.",
    "Enable network flow analysis to identify the attack and its source.",
    "Implement intrusion detection and prevention systems (IDPS) to detect and block attacks.",
    "Work with law enforcement to identify and prosecute attackers.",
    "Perform a post-incident analysis to identify vulnerabilities and improve defenses.",
    "Create a plan for responding to future attacks based on lessons learned.",
    "Communicate with customers and stakeholders to keep them informed of the situation.",
    "Establish communication channels with key partners to coordinate responses.",
    "Implement redundancy and failover mechanisms to ensure business continuity.",
    "Train employees and stakeholders on proper incident response procedures.",
    "Deploy anti-DDoS services or appliances to mitigate the impact of the attack."];

const ddWrongDoSResponses = [
    "Ignore the attack, it will stop on its own.",
    "Pay the attacker to stop the attack.",
    "Shut down your entire network to stop the attack.",
    "Blame your internet service provider for the attack.",
    "Delete important system files to stop the attack.",
    "Give in to the attacker's demands.",
    "Just wait it out and hope for the best.",
    "Do nothing and hope the attack doesn't get worse.",
    "Start blocking all incoming traffic to your network.",
    "Try to negotiate with the attacker to stop the attack.",
    "Disable all firewalls and security measures to stop the attack.",
    "Call the attacker's bluff and threaten legal action.",
    "Assume the attack is a false positive and ignore it.",
    "Blame your users for causing the attack.",
    "Delete your entire network and start over.",
    "Reboot your servers repeatedly to stop the attack.",
    "Wait for the attacker to get bored and move on.",
    "Disconnect your network from the internet to stop the attack.",
    "Engage in a hacking counter-attack against the attacker.",
    "Delete all logs and evidence of the attack to cover it up."]

const ddCorrectMalwareResponses = [
    "Disconnect from the internet immediately.",
    "Identify the type of malware and conduct research on it.",
    "Use antivirus or anti-malware software to scan your system.",
    "Remove any infected files or programs.",
    "Change all of your passwords.",
    "Back up important files and data.",
    "Update your operating system and software.",
    "Disable any unnecessary services or applications.",
    "Use a firewall to block unauthorized access.",
    "Enable automatic updates for your antivirus or anti-malware software.",
    "Install security patches for your operating system and software.",
    "Run a deep scan of your system to find any hidden malware.",
    "Check your system for any unauthorized changes or modifications.",
    "Verify the integrity of your system files and restore any corrupted files.",
    "Limit user privileges to prevent malware from spreading.",
    "Use secure connections and protocols when accessing the internet.",
    "Implement two-factor authentication for added security.",
    "Train employees on safe browsing and email practices.",
    "Monitor your system for any suspicious activity.",
    "Consider hiring a professional to assist with malware removal and system recovery."
];
const ddWrongMalwareResponses = ["Ignore it, it will go away on its own.",
    "Just delete all your files and start over.",
    "Give your credit card information to the attacker to make them go away.",
    "Pay the ransom demanded by the attacker.", "Call the police and report the attack.",
    "Just unplug your computer and the malware will disappear.",
    "Download more antivirus software to fix the problem.",
    "Disable your firewall to allow the malware to access your system and fix it.",
    "Enter your personal information into a pop-up ad to remove the malware.",
    "Delete System32 to remove the malware.",
    "Call a tech support number you found online and give them remote access to your computer.",
    "Just ignore the strange messages and emails you're receiving.",
    "Try to negotiate with the attacker to let you keep some of your files.",
    "Just restart your computer and the malware will be gone.",
    "Open and click on all suspicious links and attachments to see what happens.",
    "Try to manually delete the malware files from your system.",
    "Install more toolbars and plugins to fix the problem.",
    "Just keep using your computer as normal and hope for the best.",
    "Delete your antivirus software to remove the conflict with the malware.",
    "Tell all your friends and family to click on the same link that infected you to see if they get the same problem."];

// Make new log
function makeLog()
{
// Create the container div
const containerDiv = document.getElementById('ddlogTableContainer');

// Create the table
const table = document.createElement('table');
table.id = 'ddlogTable';
table.classList.add('ddlogTable');

// Create the table head
const tableHead = document.createElement('thead');
const tableHeadRow = document.createElement('tr');
const tableHeadCells = [
  'Date',
  'Time',
  'IP Address',
  'Request Method',
  'Website IP',
  'URL',
  'Status Code',
  'Download Speed',
  'Upload Speed',
  'System Calls',
];

// Append table head cells to the table head row
tableHeadCells.forEach((cellText) => {
  const tableHeadCell = document.createElement('th');
  tableHeadCell.textContent = cellText;
  tableHeadRow.appendChild(tableHeadCell);
});

// Append the table head row to the table head
tableHead.appendChild(tableHeadRow);

// Create the table body
const tableBody = document.createElement('tbody');

// Create the table body rows and cells
const tableBodyRows = [
  {
    id: 'logRow1',
    values: [
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
    ],
  },
  {
    id: 'logRow2',
    values: [
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
    ],
  },
  {
    id: 'logRow3',
    values: [
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
    ],
  },
  {
    id: 'logRow4',
    values: [
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
    ],
  },
  {
    id: 'logRow5',
    values: [
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
    ]
  }
];

// Append table body rows to the table body
tableBodyRows.forEach((row) => {
  const tableBodyRow = document.createElement('tr');
  tableBodyRow.id = row.id;

  // Append table body cells to the table body row
  row.values.forEach((cellText) => {
    const tableBodyCell = document.createElement('td');
    tableBodyCell.textContent = cellText;
    tableBodyRow.appendChild(tableBodyCell);
  });

  // Append the table body row to the table body
  tableBody.appendChild(tableBodyRow);
});

// Append the table head and body to the table
table.appendChild(tableHead);
table.appendChild(tableBody);

// Append the table to the container div
containerDiv.appendChild(table);

// Append the container div to the document body
}
