/* global createjs, queue */

var Tile = function (x, y, tileid, tileset, stage, walkable, id, layer) {
    var canvasO;
    var sprite = new createjs.SpriteSheet({
        "frames": {
            "width": 32,
            "regX": 0,
            "regY": 0,
            "height": 32,
            "count": Math.floor((queue.getResult(tileset).height / 32 * queue.getResult(tileset).width / 32))
        },
        "images": [queue.getResult(tileset).src]
    });
    this.canvasO = new createjs.Sprite(sprite, tileid);
    this.canvasO.rid = id;
    this.canvasO.layer = layer;
    this.canvasO.tileid = tileid;
    //this.canvasO.gotoAndStop(tileid);
    this.canvasO.walkable = walkable;
    this.canvasO.mystage = stage;
    this.canvasO.x = x;
    this.canvasO.fix = [];
    this.canvasO.mouseEnabled = false;
    this.canvasO.width = 32;
    this.canvasO.height = 32;
    this.canvasO.tickEnabled = false;
    //this.canvasO.cache(-this.canvasO.width, -this.canvasO.height, this.canvasO.width * 2, this.canvasO.height * 2); //cache this shit, unless its moveable later we dont have to update cache
    this.canvasO.y = y;
    this.canvasO.snapToPixel = true;
    this.canvasO.drawMe = function () {
        stage.addChild(this);
    };
    return this.canvasO;
};

