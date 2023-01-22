import { WebSocketServer } from "ws";

const port = 18083; 
const server = new WebSocketServer({ port: port });

function main() {
    server.on("connection", (socket) => {
        console.log(`Connected to client`);

        socket.onmessage = ({data}) => {
            // receive a JSON message from the client
            let json = JSON.parse(data);
            console.log(`Message from client: ${data}`);
    
            // echos the message back to the client
            console.log(`Message to client: ${data}`);
            socket.send(JSON.stringify({
                message: json.message
            }));
        };

        socket.onclose = () => {
            console.log("Client has disconnected");
        };
    });
}

main();