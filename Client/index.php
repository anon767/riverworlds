<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Riverworlds</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/style.css">

        <script>
            function toggle(id) {
                if (document.getElementById) {
                    var mydiv = document.getElementById(id);
                    mydiv.style.display = (mydiv.style.display == 'block' ? 'none' : 'block');
                }
            }
        </script>
        <!-- Only Hide Lock -->
        <script>
            function hide(id) {
                if (document.getElementById) {
                    var mydiv = document.getElementById(id);
                    mydiv.style.display = (mydiv.style.display = 'none');
                }
            }
        </script>

    </head>
    <body style="overflow: hidden">
        <div class="lock" id="lock"
             onclick="toggle('lock'); hide('registration-page'); return false"></div>
        <div class="locker" id="login-page">
            <div class="form">
                <form class="login-form" method="POST" action="game.php">
                    <input type="text" maxlength=20 name="user" id="user" placeholder="username"/>
                    <input type="password" maxlength=20 name="password" id="pwd" placeholder="password"/>
                    <input type="hidden" name="rtype" value="0">
                    <button>login</button>
                    <p class="link" style="cursor: pointer"
                       onclick="hide('login-page'); toggle('registration-page'); return false">Registration</p>
                </form>
            </div>
        </div>

        <div class="locker" id="registration-page" style="display:none">
            <form method="post" action="game.php">
                <div class="form">
                    <h3>Registration</h3>
                    <input type="hidden" name="rtype" value="1">
                    <input name="username_register" id="username_register" type="text" maxlength="20" required pattern="[a-zA-Z0-9]{3,}" placeholder="username"/>
                    <input name="pw_register" id="pw_register" type="password" required pattern="{6,}" placeholder="passwort"/>
                    <input name="mail" id="mail" type="email" required placeholder="email"/>
                    <label>JobClass: <select name="class" id="jobclass">
                            <option value="mage">Mage</option>
                            <option value="knight">Knight</option>
                            <option value="paladin">Paladin</option>
                        </select></label>
                    <button>Sign up</button>
                    <!--VORLÄUFIG EIN LINK ZURÜCK ZUM LOGIN -->
                    <p class="link" style="cursor: pointer "
                       onclick="hide('registration-page'); toggle('login-page'); return false">zurück zum login</p>
                </div>
            </form>
        </div>

    </body>

</html>