var socket;
const webSocketLocation = "ws:Localhost:18083";

// sends JSON containing input to server and clears input field
function onSubmit() {
    let inputField = document.getElementById("ClientInput");
    json = JSON.stringify({
        command: "echo",
        message: inputField.value
    })
    console.log(`message to server: ${json}`);
    socket.send(json);
    inputField.value = "";    
}

function start() {
    socket = new WebSocket(webSocketLocation);

    socket.onopen = () => {
        console.log(`Connected to server on ${webSocketLocation}`);
    }

    // sets ouput field when a message is recieved
    socket.onmessage = ({data}) => {
        let json = JSON.parse(data);
        let output = document.getElementById("ServerOutput");
        output.value = json.message;
        console.log(`message from server: ${data}`)
    };

    // attempts reconnection once every second when connection to the server is lost
    socket.onclose = ({data}) => {
        console.log(`Connecion has been closed with message: ${data}. Attempting reconnect`); // currently server does not say anything to clients when it shuts down
        setTimeout(() => { start() }, 1000);
    };
}

start();