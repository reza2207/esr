let ipAddress = window.location.hostname;
 
if (ipAddress == "::1") {
    ipAddress = "localhost"
}
const port = "3000";
const socketIoAddress = `http://${ipAddress}:${port}`;
const socket = io(socketIoAddress);