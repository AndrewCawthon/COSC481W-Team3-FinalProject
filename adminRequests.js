var table;
var jsons;

// gets the proper files from the database on page load 
function onload() {
    // using test data for now
    jsons = [
        {
            name: "Nathan Zimmer",
            details: "day x to day y for vacation or something",
            status: 1
        },
        {
            name: "Nathan Zimmer",
            details: "because I don't want to work",
            status: 0
        }
    ];
}

// sets the table that we will be using for the time off requests
function setTable(tableName) {
    table = document.getElementById(tableName);
}

// takes a list of json files (formatted: name, details, status[0(undecided) or 1(approved) or 2(denied)]) and adds them to the table. Adds event listeners to the buttons
function addRow() {
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


        // if status is null, we need to choose a status
        if (json.status == 0) {
            addButton(row, "approve", "approve" + counter, onApprove);

            addButton(row, "deny", "deny" + counter++, onDeny);
        }
        // if status has already been chosen we can undo it
        else {
            addButton(row, "undo", "undo" + counter++, onUndo);
        }

        // adding this row to the table
        table.appendChild(row);
    });
}

function onApprove(event) {
    // deleting approve button 
    let button = event.currentTarget;
    let index = parseInt(button.id.at(-1));
    let row = button.parentNode;
    button.remove();

    // deleting deny button
    document.getElementById("deny" + index).remove();

    // adding undo button
    undo = addButton(row, "undo", "undo" + index, onUndo);

    // updating json file
    jsons[index].oldStatus = 0;
    jsons[index].status = 1;
}

function onDeny(event) {
    // deleting deny button 
    let button = event.currentTarget;
    let index = parseInt(button.id.at(-1));
    let row = button.parentNode;
    button.remove();

    // deleting deny button
    document.getElementById("approve" + index).remove();

    // adding undo button
    undo = addButton(row, "undo", "undo" + index, onUndo);

    // updating json file
    jsons[index].oldStatus = 0;
    jsons[index].status = 2;
}

function onUndo(event) {
    // deleting undo button 
    let button = event.currentTarget;
    let index = parseInt(button.id.at(-1));
    let row = button.parentNode;
    button.remove();

    // adding approve button
    addButton(row, "approve", "approve" + index, onApprove);

    // adding deny button
    addButton(row, "deny", "deny" + index, onDeny);

    // updating json file
    jsons[index].oldStatus = jsons[index].status;
    jsons[index].status = 0;
}

// adds a button with the specified params
function addButton(row, text, id, listener) {
    let button = document.createElement("button");
    button.id = id;
    button.type = "button";
    button.textContent = text;
    row.appendChild(button);

    button.addEventListener("click", listener);
    return button;
}

// submits all of the json files to the database
function onSubmit() {
    console.log("submitted");
}

onload();