/* global createjs, tiles */

var MapEditor = function (stage, communication, mapid, tileset) {
    var dragTile, tileset;
    this.mapid = mapid;
    this.communication = communication;
    this.tileset = tileset;
    this.lines = [];
    this.dragTile = [];
    this.endEditor = function (stage, that) {

        $("#modal").hide();
        for (var i in that.lines) {
            stage.removeChild(that.lines[i]);
        }
        that.lines = [];
        if (that.dragTile.length > 0) {
            for (var i in that.dragTile) {
                stage.removeChild(that.dragTile[i]);
            }
            that.dragTile = [];
        }
        mapeditor = null;
        drawLayer();
    };
    this.openTileSet = function (stage, that) {
        $("#modal").html("<label><input id='delete' value='false' type='checkbox'>Delete</label><input id='walkable' value='false' type='checkbox' checked>Walkable</label> <label><select id='layer'><option value='0'>0</option><option value='1'>1</option></select>Layer</label><br><img id='tileSetImage' src='assets/" + that.tileset + ".png'>");
        $('#modal').dialog({
            autoOpen: true,
            height: 300,
            draggable: true,
            resizable: true,
            closeText: "",
            title: "TileSet",
            close: function () {
                that.endEditor(stage, that);
            }
        });
        $(".ui-dialog").show();
        $("#modal").show();
    };
    this.createGatter = function (stage) {
        var maxVertical = Math.floor(stage.canvas.height / 32);
        for (var i = 0; i < maxVertical; i++) {
            var line = new createjs.Shape();
            line.graphics.setStrokeStyle(0.7);
            line.graphics.beginStroke("lightgrey");
            line.graphics.moveTo(0, i * 32);
            line.graphics.lineTo(stage.maxwidth * 32, i * 32);
            this.lines.push(line);
            stage.addChild(line);
        }
        var maxHorizontal = Math.floor(stage.canvas.width / 32);
        for (var i = 0; i < maxHorizontal; i++) {
            var line = new createjs.Shape();
            line.graphics.setStrokeStyle(0.7);
            line.graphics.beginStroke("lightgrey");
            line.graphics.moveTo(i * 32, 0);
            line.graphics.lineTo(i * 32, stage.maxheight * 32);
            this.lines.push(line);
            stage.addChild(line);
        }
    };
    this.hoverEvent = function (evt) {
        var offsetx = -stage.x;
        var offsety = -stage.y;
        if (this.dragTile.length > 0) {
            for (var i in this.dragTile) {
                var Tile = this.dragTile[i];
                if (Tile.fix.length <= 0) {
                    Tile.fix = [Tile.x, Tile.y];
                }
                if (i === 0) {
                    Tile.x = evt.stageX + offsetx;
                    Tile.y = evt.stageY + offsety;
                } else {
                    Tile.x = evt.stageX - this.dragTile[0].fix[0] + Tile.fix[0] + offsetx;
                    Tile.y = evt.stageY - this.dragTile[0].fix[1] + Tile.fix[1] + offsety;
                }
            }
        }
    };
    this.pressEvent = function (evt) {
        evt.preventDefault();
        if (this.dragTile.length > 0 && evt.nativeEvent.which == 1) {
            for (var i in this.dragTile) {
                var dragTile = this.dragTile[i];
                dragTile.x = Math.floor(dragTile.x / 32) * 32;
                dragTile.y = Math.floor(dragTile.y / 32) * 32;
                this.communication.send({5: {"x": dragTile.x / 32, "y": dragTile.y / 32, "map": this.mapid, "w": dragTile.walkable, "sprite": this.tileset, "frame": dragTile.tileid, "layer": dragTile.layer}});
                var t = (new Tile(dragTile.x, dragTile.y, dragTile.tileid, this.tileset, stage, $("#walkable").is(":checked"), Math.floor(Math.random() * 100), $("#layer").val()));
                tiles.push(t);
            }

            if (this.dragTile.length == 1) {
                var t = (new Tile(0, 0, this.dragTile[0].tileid, this.tileset, stage, $("#walkable").is(":checked"), Math.floor(Math.random() * 100), $("#layer").val()))
                this.dragTile[0] = t;
                t.drawMe();
            } else {
                drawLayer();
                for (i in this.dragTile) {
                    this.dragTile[i].drawMe();
                }
            }
        } else if (evt.nativeEvent.which == 3) {

            this.rightClickEvent(evt);
        }
    };
    this.rightClickEvent = function (evt) {
        evt.preventDefault();
        var offsetx = -stage.x;
        var offsety = -stage.y;
        for (var tileid in tiles) {
            if ($("#delete").is(":checked")) {
                if (Math.floor((evt.stageX + offsetx) / 32) * 32 == tiles[tileid].x && Math.floor((evt.stageY + offsety) / 32) * 32 == tiles[tileid].y) {
                    stage.removeChild(tiles[tileid]);
                    this.communication.send({6: {"map": this.mapid, "id": tiles[tileid].rid}});
                    delete tiles[tileid];
                }
            } else {
                if (Math.floor((evt.stageX + offsetx) / 32) * 32 == tiles[tileid].x && Math.floor((evt.stageY + offsety) / 32) * 32 == tiles[tileid].y && (tiles[tileid].tileid.layer !== 0 || !tiles[tileid].walkable || tiles[tileid].tileid !== 0)) {
                    createjs.Tween.get(tiles[tileid], {loop: false}).to({alpha: 0.1}, 500).to({alpha: 1}, 50).call(function () {});
                    this.communication.send({14: {"map": this.mapid, "id": tiles[tileid].rid, "layer": $("#layer").val(), "walkable": ($("#walkable").is(":checked") ? 1 : 0)}});
                }
            }
        }
    };



    this.crop = function (evt, that) {
        var x = Math.round(evt.x / 32);
        var y = Math.round(evt.y / 32);
        var x2 = Math.round(evt.x2 / 32);
        var y2 = Math.round(evt.y2 / 32);

        for (var i in that.dragTile) {
            stage.removeChild(that.dragTile[i]);
        }
        that.dragTile = [];
        for (var i = x; i < x2; i++) {
            for (var j = y; j < y2; j++) {
                var t = new Tile(i * 32, j * 32, j * Math.floor($("#tileSetImage").width() / 32) + i, that.tileset, stage, $("#walkable").is(":checked"), 100, $("#layer").val());
                that.dragTile.push(t);
                t.drawMe();
            }
        }
    };
    stage.mouseMoveOutside = true;
    var self = this;
    stage.on("stagemousemove", function (evt) {
        self.hoverEvent(evt);
    });
    stage.on("stagemousedown", function (evt) {
        self.pressEvent(evt);
    });
    $(document).on("contextmenu", function (e) {
        e.preventDefault();
    });

    this.createGatter(stage);
    this.openTileSet(stage, self);
    $('#tileSetImage').Jcrop({
        onSelect: function (e) {
            self.crop(e, self);
        }
    });
    console.info("MapEditor intialized");
};
