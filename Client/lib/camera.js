/* global meid, players, stage */

var Camera = function () {
    this.check = function (stage, direction) {
        var playerx = Math.floor(players[meid].x / 32) * 32;
        var playery = Math.floor(players[meid].y / 32) * 32;
        var width = stage.canvas.width;
        var height = stage.canvas.height;
        var mapwidth = stage.maxwidth * 32;
        var mapheight = stage.maxheight * 32;
        if (direction == 0 && width < mapwidth && playerx >= width / 2 && Math.abs(stage.x) <= (mapwidth - width)) {
            stage.x -= 5;
        } else
        if (direction == 1 && width < mapwidth && stage.x < 0) {
            stage.x += 2;
        } else
        if (direction == 2 && height < mapheight && playery >= height / 2 && Math.abs(stage.y) <= (mapheight - height)) {
            stage.y -= 5;
        } else
        if (direction == 3 && height < mapheight && Math.abs(stage.y) > (0) && stage.y <= 0) {
            stage.y += 2;
        }
    };
    this.initialPositioning = function (stage) {
        stage.x = 0;
        stage.y = 0;
        var mapwidth = stage.maxwidth * 32;
        var mapheight = stage.maxheight * 32;
        var width = stage.canvas.width;
        var height = stage.canvas.height;
        stage.x -= Math.abs(players[meid].x) > width ? Math.max(Math.abs(width - players[meid].x), mapwidth - width) : 0;
        stage.y -= Math.abs(players[meid].y) > height ? Math.max(Math.abs(height - players[meid].y), mapheight - height) : 0;
    };
};