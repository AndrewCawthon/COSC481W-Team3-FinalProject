import { WebSocketServer } from "ws";
import { createTransport } from 'nodemailer';
const port = 18083; 
const server = new WebSocketServer({ port: port });
import pkg from "mssql";
const {sql} = pkg;

const config = {
    user: 'mainLogin', // better stored in an app setting such as process.env.DB_USER
    password: 'AdminUser42!', // better stored in an app setting such as process.env.DB_PASSWORD
    server: 'test-server-seniorproject.database.windows.net', // better stored in an app setting such as process.env.DB_SERVER
    port: 1433, // optional, defaults to 1433, better stored in an app setting such as process.env.DB_PORT
    database: 'test', // better stored in an app setting such as process.env.DB_NAME
    authentication: {
        type: 'default'
    },
    options: {
        encrypt: true
    }
}

function main() {
    server.on("connection", (socket) => {
        getDB(socket);
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
        case "set":
            setDB(json.message, socket);
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

// testing
var jsons = [
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

// sends all of the data from the manager requests db to the user
function getDB(socket) {
    // get data from database and set it to array

    socket.send(JSON.stringify({0: jsons})); 
}

// sets database using given json file
function setDB(data) {
    // replace data in database with what we get from client

    jsons = data;
}

async function connectAndQuery(request) {
    try {
        let pool = await sql.connect(config)
        let result1 = await pool.request()
            .query(request);
        console.dir(result1)
        pool.close();
    } catch (err) {
        console.log(err)
    }
}

main();