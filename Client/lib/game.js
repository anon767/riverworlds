/* global createjs, MessageTypes */
var queue = new createjs.LoadQueue(false);
var stage = new createjs.Stage("stage");
var mapid = 1;
var mapgraph = [[]];
var tiles = [];
var meid = null;
var camera = null;
var communication = null;
var music = null;
var players = [];
var mapeditor = null;
var keys, keydown, keyup;
this.keys = [];
var layers = [];
function keydown(e) {
    if (!$("#speechtext").is(":focus")) {
        if (e.keyCode === 65 || e.keyCode === 68 || e.keyCode === 83 || e.keyCode === 87 || e.keyCode === 32
                || e.keyCode === 37 || e.keyCode === 38 || e.keyCode === 39 || e.keyCode === 40) {
            e.preventDefault();
            this.keys[e.keyCode] = true;
        }
    }
}

function keyup(e) {
    this.keys[e.keyCode] = false;
}
function checkKeys(delta) {
    if (typeof players[meid] !== "undefined") {
        if (keys[68] || keys[39]) { // right
            players[meid].sendMove(0);
        } else if (keys[65] || keys[37]) {
            players[meid].sendMove(1);
        } else if (keys[83] || keys[40]) {
            players[meid].sendMove(2);
        } else if (keys[87] || keys[38]) {
            players[meid].sendMove(3);
        }
    }
}
function buildLayer() {
    layers = [];
    for (var i in tiles) {
        if (!layers[tiles[i].layer]) {
            layers[tiles[i].layer] = [];
        }
        layers[tiles[i].layer].push(tiles[i]);
    }
}
function drawLayer() {
    buildMap();
    stage.removeAllChildren();
    buildLayer();
    for (var i in layers) {
        for (var j in layers[i]) {
            if (layers[i][j]) {
                layers[i][j].drawMe();
            }
            if (i == 0 && j == layers[0].length - 1) {
                for (var k in players) {
                    players[k].drawMe();
                }
            }
        }
    }
    if (mapeditor) {
        mapeditor.createGatter(stage);
    }
}
function buildMap() {
    for (var i in tiles) {
        if (!mapgraph[tiles[i].x / 32]) {
            mapgraph[tiles[i].x / 32] = [];
        }
        mapgraph[tiles[i].x / 32][tiles[i].y / 32] = tiles[i].walkable;
    }
}

function callBack(s) {
    if (s[MessageTypes.MAP]) { //retrieve Map
        for (var tile in s[MessageTypes.MAP]) {
            tile = s[MessageTypes.MAP][tile];
            tiles.push(new Tile(tile['x'] * 32,
                    tile['y'] * 32,
                    tile['frame'],
                    tile['sprite'],
                    stage,
                    tile['w'],
                    tile['id'],
                    tile['layer']));
        }
        buildMap();
        if (stage.children.length > 1) {
            drawLayer();
        }
    } else if (s[MessageTypes.INITIAL]) {
        var player = s[MessageTypes.INITIAL];
        players[player['id']] = (new Player(player['x'],
                player['y'],
                player['sprite'],
                stage,
                player['id'],
                player['h'],
                player['name']));
        drawLayer();
        meid = player['id'];
        if (!camera) {
            camera = new Camera();
        }
        camera.initialPositioning(stage);
    } else if (s[MessageTypes.REQUESTMAPCHANGE]) {
        if (s[MessageTypes.REQUESTMAPCHANGE]['granted'] == 1) {
            mapeditor = new MapEditor(stage,
                    communication,
                    mapid,
                    "default_tile");
        }
    } else if (s[MessageTypes.GETMAPID]) {
        $("#mapName").html(s[MessageTypes.GETMAPID]['name']);
        mapid = s[MessageTypes.GETMAPID]['id'];
        stage.maxheight = s[MessageTypes.GETMAPID]['height'];
        stage.maxwidth = s[MessageTypes.GETMAPID]['width'];
    } else if (s[MessageTypes.PLAYER]) {
        var player = s[MessageTypes.PLAYER];
        if (players[player['id']]) {
            stage.removeChild(players[player['id']]);
        }
        players[player['id']] = (new Player(player['x'],
                player['y'],
                player['sprite'],
                stage,
                player['id'],
                player['h'],
                player['name']));
        drawLayer();
    } else if (s[MessageTypes.MOVE]) {
        if (players[s[MessageTypes.MOVE]['u']]) {
            players[s[MessageTypes.MOVE]['u']].move(s[MessageTypes.MOVE]['d'], 0);
        } else {
            var send = {};
            send[MessageTypes.REQUESTREFRESH] = {};
            communication.send(send);
        }
    } else if (s[MessageTypes.KICK]) {
        alert(s[MessageTypes.KICK]['message']);
        location.href = "index.php";
    } else if (s[MessageTypes.LEFT]) {
        stage.removeChild(players[s[MessageTypes.LEFT]['id']]);
        delete players[s[MessageTypes.LEFT]['id']];
    } else if (s[MessageTypes.CHANGEMAP]) {
        layers = [];
        tiles = [];
        players = [];
        //alert(s[MessageTypes.CHANGEMAP]["message"]);
        //communication.send({17: {}});
    } else if (s[MessageTypes.MESSAGE]) {
        alert(s[MessageTypes.MESSAGE]['message']);
    } else if (s[MessageTypes.TALK]) {
        var talkingPlayer = players[s[MessageTypes.TALK]['p']];
        new SpeechBubble(talkingPlayer, s[MessageTypes.TALK]['t'], talkingPlayer.x, talkingPlayer.y);
    }
}

function ticker(event) {
    if (meid) {
        checkKeys(event.delta);
    }
    stage.update();
}

$(document).ready(function () {
    $("#speechbox").hide();
    $("#modal").html('<img src="assets/loading.gif" width=50% height=50%>');
    var modal = $('#modal').dialog({
        autoOpen: true,
        height: 300,
        draggable: true,
        resizable: true,
        closeText: "",
        title: "Loading"
    });
    $("#modal").show();
    createjs.Sound.alternateExtensions = ["mp3"];
    queue.installPlugin(createjs.Sound);
    queue.loadFile({id: "background", src: "assets/background.ogg"});
    queue.loadManifest([
        {id: "default", src: "assets/default.png"},
        {id: "mage", src: "assets/mage.png"},
        {id: "knight", src: "assets/knight.png"},
        {id: "paladin", src: "assets/paladin.png"},
        {id: "default_tile", src: "assets/default_tile.png"},
        {id: "speechbubble", src: "assets/bubble.png"}
    ]);
    queue.on("complete", handleComplete, this);
    function handleComplete() {
        createjs.Ticker.timingMode = createjs.Ticker.RAF_SYNCHED;
        createjs.Ticker.setFPS(60); //smooth performance
        createjs.Ticker.on("tick", ticker);
        $(window).keydown(function (e) {
            keydown(e);
        });
        $(window).keyup(function (e) {
            keyup(e);
        });
        communication = new Communication(callBack);
        $("#editor_button").click(function (e) {
            var send = {};
            send[MessageTypes.REQUESTMAPCHANGE] = {};
            communication.send(send);
        });

        $("#speechform").submit(function (e) {
            e.preventDefault();
            if ($("#speechtext").val().length > 1) {
                var send = {};
                send[MessageTypes.TALK] = {t: $("#speechtext").val(), p: meid};
                $("#speechtext").val("");
                $("#speechtext").blur();
                $("#stage").focus();
                communication.send(send);
            }
        });
        music = createjs.Sound.play("background");
        music.volume = 0.1;
        $("#mute").click(function (e) {
            if (music.volume > 0) {
                music.volume = 0;
            } else {
                music.volume = 0.1;
            }
        });
        $(".ui-dialog").hide();
        $("#speechbox").show();
    }
}
);