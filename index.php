<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/lork.php");
    include_once("layout/header.php");
?>

<body>
    <div width="100%" height="100%">
        <div id="score" class="score" <?php if(isset($_SESSION['score']) && $_SESSION['score']) { echo "style='visibility:visible;'"; } ?>>
            <div id="room" class="room">
                Room: <?php if(isset($_SESSION['room'])) { echo $_SESSION['room']; } ?>
            </div>
            <div id="points" class="points">
                Score: 0
            </div>
            <div id="scorecenter" class="scorecenter">
                <center><b>Lork v0.1</b></center>
            </div>
        </div>
        <div id="lork" class="lork">
            <?php if(!isset($_SESSION['score'])) { echo $txt->getText(); } ?>
        </div>
        <br />
        <div id="command" class="command">
            &gt;&nbsp;<input class="prompt" type="text" id="inprompt" name="inprompt" autocomplete="off" onkeypress="submitcommand(event);">
        </div>
    </div>
    <script language="javascript">
        document.getElementById("inprompt").focus();
    </script>
</body>

<?php
    include_once("layout/footer.php");
?>