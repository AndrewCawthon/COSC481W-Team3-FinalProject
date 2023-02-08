const weekRef = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
const workHours = 24;

var week1 = [JSON.stringify({
                name: "Nathan",
                day: "Monday",
                startShift: "0",
                endShift: "0",
                type: "register"
            }),
            JSON.stringify({
                name: "Nathan",
                day: "Tuesday",
                startShift: "8",
                endShift: "15",
                type: "register"
            }),
            JSON.stringify({
                name: "Someone",
                day: "Friday",
                startShift: "13",
                endShift: "20",
                type: "burger"
            }),
            JSON.stringify({
                name: "Nathan",
                day: "Friday",
                startShift: "15",
                endShift: "22",
                type: "register"
            })];


var week2 = [JSON.stringify({
    name: "Nathan",
    day: "Tuesday",
    startShift: "0",
    endShift: "8"
})];

// creates header html elements and gives them ids. Each day's id is from the above list
function createHeader() {
    var table = document.getElementById("cal");
    
    let row = document.createElement("tr"); 
    row.appendChild(document.createElement("th")); 
    
    for (let i = 0; i < 7; i++) {

        let day = document.createElement("th");
        day.id = weekRef[i];
        let time = document.createTextNode("test");
        day.appendChild(time);
        row.appendChild(day);
    }

    table.appendChild(row);
}

// creates the rows 
function createRows() {
    var table = document.getElementById("cal");

    for (let i = 0; i < workHours; i ++) {

        // creating time column
        let row = document.createElement("tr"); 
        let hour = document.createElement("td");
        
        let stdTime = "";
        i++;
        if (i == 0) {
            stdTime = "12:00am"
        }
        else if (i < 12) {
            stdTime = i + ":00am"
        }
        else if (i == 12) {
            stdTime = "12:00pm"
        }
        else {
            stdTime = (i - 12) + ":00pm"
        }
        i--;

        let time = document.createTextNode(stdTime);
        row.appendChild(hour);
        hour.appendChild(time);
        
        // styling
        hour.style.border = "0px";
        hour.style.paddingRight = "10px";
        hour.style.float = "right";

        // creating one row for each hour of each day. row ids are formatted "Day:hour" ex: "Sunday:0", "Monday:23", "Thursday:15"
        for (let j = 0; j < 7; j++) {
            let day = document.createElement("td");
            day.id = weekRef[j] + ":" + i;
            //let text = document.createTextNode(weekRef[j] + ":" + i);
            let text = document.createTextNode("");
            day.appendChild(text);
            row.appendChild(day);
        }
        table.appendChild(row);
    }
    updateRows(week1);
}

// loads correct dates into headers depending on whether we are looking at this week or next week
function updateHeader(thisWeek) {
    let dateToday = new Date();
    let dayToday = dateToday.getDay();

    if (!thisWeek) {
        dayToday -= 7;
    }

    for (let i = 0; i < 7; i++) {
        let date = new Date();
        day = document.getElementById(weekRef[i]);
        date.setDate(date.getDate() - (dayToday - i));
        let parsedDate = `${date.getMonth()}/${date.getDate()}`;
        day.textContent = `(${parsedDate}) ${weekRef[i]}`;

        if (dayToday < 0) {
            day.style.borderColor = null;
            day.style.backgroundColor = null;
            day.style.borderWidth = null;
        }
        if (dayToday == i) {
            day.style.borderColor = "#5050FF";
            day.style.backgroundColor = "#F0F0FF";
            day.style.borderWidth = "3px";
        }
    }
}

function updateRows(jsons) {
    jsons.forEach(i => {
        let json = JSON.parse(i);
        let working = false;
        for (let i = 0; i < 7; i++) {
            for (let j = 0; j < workHours; j++) {
                let id = `${weekRef[i]}:${j}`;
                let hour = document.getElementById(id);
                
                if (j == json.startShift) {
                    working = true;
                }
                if (j-1 == json.endShift) {
                    working = false;
                }

                if (weekRef[i] == json.day && working) {
                    hour.textContent += `, ${json.name} - ${json.type}`;
                    if (hour.textContent.substring(0,2) == ", ") {
                        hour.textContent = hour.textContent.substring(2);
                    }
                    hour.style.backgroundColor = "#F0F0FF";
                }
            }
        }
    });
}

function clearCal() {
    for (let i = 0; i < 7; i++) {
        for (let j = 0; j < workHours; j++) {
            let id = `${weekRef[i]}:${j}`;
            let hour = document.getElementById(id);

            hour.textContent = "";
            hour.style.backgroundColor = "#FFFFFF";
        }
    }
}

// changes button and updates table
var thisWeek = true;
function changeWeek() {
    thisWeek = !thisWeek;
    let button = document.getElementById("weekButton");

    let json;
    if (!thisWeek) {
        button.style.float = "left";
        button.textContent = "<- This Week";
        clearCal();
        updateRows(week2);
    }
    else {
        button.style.float = "right";
        button.textContent = "Next Week ->";
        clearCal();
        updateRows(week1);
    }
    updateHeader(thisWeek);
}