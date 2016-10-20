/* global createjs, queue */

var SpeechBubble = function (stage, message, x, y) {
    this.container = new createjs.Container();
    this.sb = new createjs.ScaleBitmap(queue.getResult("speechbubble").src, new createjs.Rectangle(10, 10, 5, 10));
    this.sb.setDrawSize(message.length * 3 + 100 | 0, message.length + 60 | 0);
    this.remove = function () {
        stage.removeChild(this.container);
    };
    this.container.x = -(message.length * 3 + 100) + 15;
    this.container.y = -50;
    this.text = new createjs.Text(message, "10px Arial", "black");
    this.text.x += 25 / 2;
    this.text.y += 25 / 2;
    this.container.addChild(this.sb, this.text);
    stage.addChild(this.container);
    $("#messageChronic").prepend("<p>" + stage.name + " : " + message + "</p>");
    if ($("#messageChronic").html().length > 1000) {
        $("#messageChronic").html("");
    }
    createjs.Tween.get(this.container).wait(1000).to({alpha: 0}, 1000 + message.length).call(this.remove);
    return this.container;
};