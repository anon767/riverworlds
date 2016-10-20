<html>
    <head>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/style.css">
        <title>Riverworld</title>
    </head><body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><div id="mapName"></div></a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Map</a></li>
                        <li><a id="editor_button" href="#">Editor</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container">
            <div class="stage">
                <canvas id="stage" height="400" width="1200" style=" left: 0px; top: 0px;"></canvas>
            </div>
        </div>
        <script
            src="//code.jquery.com/jquery-1.12.3.min.js"
            integrity="sha256-aaODHAgvwQW1bFOGXMeX+pC4PZIPsvn2h1sArYOhgXQ="
        crossorigin="anonymous"></script>
        <script src="//code.jquery.com/ui/1.12.0-rc.2/jquery-ui.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="//code.createjs.com/tweenjs-0.6.2.min.js"></script> 
        <script src="//code.createjs.com/preloadjs-0.6.2.min.js"></script>
        <script src="//code.createjs.com/easeljs-0.8.2.min.js"></script>
        <script src="//code.createjs.com/soundjs-0.6.2.min.js"></script>
        <script src="lib/MessageTypes.js"></script>
        <script src="lib/SpeechBubble.js"></script>
        <script src="lib/ScaleBitmap.js"></script>
        <script src="lib/jcrop.js"></script>
        <script src="lib/communication.js"></script>
        <script src="lib/tile.js"></script>
        <script src="lib/mapeditor.js"></script>
        <script src="lib/player.js"></script>
        <script src="lib/camera.js"></script>
        <script src="lib/game.js"></script>
        <script>
            function gameCallBack() {
<?PHP
if (isset($_POST)) {
    if (isset($_POST['rtype']) && $_POST['rtype'] == 0) {
        echo "var username = \"" . $_POST['user'] . "\";";
        echo "var pwd = \"" . md5($_POST['password']) . "\";";
        echo "communication.send({0:{u:username,p:pwd}});";
    } else if (isset($_POST['rtype']) && $_POST['rtype'] == 1) {
        echo "var username = \"" . $_POST['username_register'] . "\";";
        echo "var pwd = \"" . md5($_POST['pw_register']) . "\";";
        echo "var mail = \"" . $_POST['mail'] . "\";";
        echo "var sprite = \"" . $_POST['class'] . "\";";
        echo "communication.send({1:{e:mail,u:username,p:pwd,s:sprite}});";
    } else {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}
?>
            }
        </script>
        <div id="speechbox"><form action="" id="speechform"><input type="text" id="speechtext" placeholder="talk..."><input type="submit" value="send">
                <div id="messageChronic"></div>
            </form>
            <button id="mute">mute</button></div>
        <div id="modal" style='overflow:auto;display:none'></div>
    </body>
</html>