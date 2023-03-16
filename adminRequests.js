var table;

// sets the table that we will be using for the time off requests
function setTable(tableName) {
    table = document.getElementById(tableName);
}

// takes a list of json files (formatted: name, details, status[approved/denied/empty]) 
function addRow() {

    let jsons = [
        {
            name: "Nathan Zimmer",
            details: "day x to day y for vacation or something",
            status: "approved"
        },
        {
            name: "Nathan Zimmer",
            details: "because I don't want to work"
        }
    ];

    let counter = 0;
    jsons.forEach(json => {
        // creating new row element
        let row = document.createElement("tr"); 
        row.id = "row" + counter;

        // appending name and details to the row
        let name = document.createElement("td");
        name.id = "name" + counter;
        name.textContent = json.name;
        let details = document.createElement("td");
        details.id = "details" + counter;
        details.textContent = json.details;
        row.appendChild(name);
        row.appendChild(details);


        // deciding if we have undo button or not
        if (json.status == undefined) {
            let approve = document.createElement("button");
            approve.id = "approve" + counter;
            approve.type = "button";
            approve.textContent = "approve";
            row.appendChild(approve);
            approve.addEventListener("click", onApprove);

            let deny = document.createElement("button");
            deny.id = "deny" + counter++;
            deny.type = "button";
            deny.textContent = "deny";
            row.appendChild(deny);
            deny.addEventListener("click", onDeny);
        }
        else {
            let undo = document.createElement("button");
            undo.id = "undo" + counter++;
            undo.type = "button";
            undo.textContent = "undo";
            row.appendChild(undo);
            undo.addEventListener("click", onUndo);
        }

        // adding this row to the table
        table.appendChild(row);
    });
}

function onApprove(event) {
    console.log("approved!");
}

function onDeny(event) {
    console.log("denied ):");
}

function onUndo(event) {
    console.log("undone");
    
}