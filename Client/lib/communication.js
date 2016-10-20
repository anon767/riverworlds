
function Communication(Eventcallback) {
    var socket, send;
    this.socket = new WebSocket('ws://127.0.0.1:8080');

    this.socket.onopen = function () {
        gameCallBack();
    };
    this.socket.onmessage = function (s) {
        if (s) {
            Eventcallback(JSON.parse(s.data));
        }
    };
    this.socket.onclose = function () {
        document.href = "index.php";
    };
    this.send = function (data) {
        this.socket.send(JSON.stringify(data));
    };
}
;
