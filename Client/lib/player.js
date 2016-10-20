/* global createjs, queue, players, mapgraph, meid, camera, MessageTypes, communication */

var Player = function (x, y, spriteset, stage, id, health, name) {
    var canvasO;
    var sprite = new createjs.SpriteSheet({
        "frames": {
            "width": 32,
            "regX": 0,
            "regY": 0,
            "height": 48,
            "count": 16
        },
        "animations": {
            "stop": 0,
            "m1": [4, 7, false, 0.2],
            "m0": [8, 11, false, 0.2],
            "m2": [0, 3, false, 0.2],
            "m3": [12, 15, false, 0.2]
        },
        "images": [queue.getResult(spriteset).src]
    });
    this.canvasO = new createjs.Container();
    this.canvasO.sprite = new createjs.Sprite(sprite, "stop");
    this.canvasO.speed = 2;
    this.canvasO.layer = 0;
    this.canvasO.name = name;
    this.canvasO.collide = function (x, y) {
        x = Math.floor((x + 31 / 2) / 32);
        y = Math.floor((y + 50) / 32);
        if (mapgraph[x] && mapgraph[x][y]) {
            return true;
        } else {
            return false;
        }
    };
    this.canvasO.moveTimeout = 0;
    this.canvasO.resetMoveTimeout = function () {
        this.moveTimeout = 0;
    };
    this.canvasO.sendMove = function (direction) {
        if (!this.moveTimeout) {
            var nextx = players[this.rid].x, nexty = players[this.rid].y;
            if (direction == 0) {
                nextx = players[this.rid].x + this.speed;
            } else if (direction == 1) {
                nextx = players[this.rid].x - this.speed;
            } else if (direction == 2) {
                nexty = players[this.rid].y + this.speed;
            } else if (direction == 3) {
                nexty = players[this.rid].y - this.speed;
            }
            if (this.collide(nextx, nexty)) {
                var send = {};
                this.moveTimeout = 1;
                send[MessageTypes.MOVE] = {"u": this.rid, "d": direction};
                communication.send(send);
            }
        } else if (this.moveTimeout) {
            setTimeout(function () {
                this.resetMoveTimeout();
            }.bind(this), 1000/60);
        }
    }
    this.canvasO.move = function (direction, delta) {
        if (players[this.rid].sprite.paused || players[this.rid].sprite._animation.name !== "m" + direction) {
            players[this.rid].sprite.gotoAndPlay("m" + direction);
        }
        var nextx = players[this.rid].x, nexty = players[this.rid].y;
        if (direction == 0) {
            nextx = players[this.rid].x + this.speed;
        } else if (direction == 1) {
            nextx = players[this.rid].x - this.speed;
        } else if (direction == 2) {
            nexty = players[this.rid].y + this.speed;
        } else if (direction == 3) {
            nexty = players[this.rid].y - this.speed;
        }
        if (this.collide(nextx, nexty)) {
            if (this.rid === meid) {
                camera.check(stage, direction);
            }
            players[this.rid].x = nextx;
            players[this.rid].y = nexty;
        }

    };
    this.canvasO.sprite.gotoAndStop(0);
    this.canvasO.rid = id;
    this.canvasO.x = x;
    this.canvasO.y = y;
    this.canvasO.health = health;
    this.canvasO.TextO = new createjs.Text(this.canvasO.name, "13px Arial", "#171369");
    this.canvasO.TextO.y -= 15;
    this.canvasO.addChild(this.canvasO.TextO);
    this.canvasO.addChild(this.canvasO.sprite);
    this.canvasO.drawMe = function () {
        stage.addChild(this);
    };
    return this.canvasO;
};
