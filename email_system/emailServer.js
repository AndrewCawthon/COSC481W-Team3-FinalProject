// Author: Nathan Zimmer
// nodejs webserver that sends email notifcations to workers when their time off is approved or denied
import { WebSocketServer } from "ws";
import { createTransport } from 'nodemailer';

const port = 18083; 
const server = new WebSocketServer({ port: port });

// starts server and waits for connections
function main() {
    server.on("connection", (socket) => {
        console.log(`Connected to client`);

        socket.onmessage = ({data}) => {
            // receive a JSON message from the client
            let json = JSON.parse(data);
            console.log(`Message from client: ${data}`);
    
            // processes message
            callFunction(json, socket);
        };

        socket.onclose = () => {
            console.log("Client has disconnected");
        };
    });
}

// calls specified function based on JSON message
function callFunction(json, socket) {
    switch (json.command) {
        case "echo":
            echo(json.message, socket);
            break;
        case "mail":
            send(json);
            break;
    }
}

// echos the message back to the client
function echo(message, socket) {
    let json = JSON.stringify({
        message: message    
    });
    console.log(`Message to client: ${json}`);
    socket.send(json);
}

// sends email 
function send(json) {
    var transporter = createTransport({
        service: 'gmail',
        auth: {
            user: 'mcdondalds1234@gmail.com',
            pass: 'huhqrearzdiafbbl'
        }
    });

    let mail = {
        from: 'mcdondalds1234@gmail.com',
        to: json.to,
        subject: json.subject,
        text: json.body
      };

    transporter.sendMail(mail, function(error, info){
        if (error) {
            console.log(error);
        } else {
            console.log('Email sent: ' + info.response);
        }
    });    
}

main();