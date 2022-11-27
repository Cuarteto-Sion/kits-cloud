<?php
$song = array(
    "title" => "Arquitecto Divino",
    "artist" => "Heraldos del Rey",
    "lyrics" => "content/lyrics.json",
    "tracks" => array("content/tenor2.mp3", "content/_221117124309.mp3")
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $song["title"] ?></title>
    <link rel="stylesheet/less" type="text/less" href="lab2.less" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="content">
        <div class="lyrics"></div>
    </div>

    <div class="player">
        <div class="right">
            <div class="top">
                <a class="song" href="">
                    <?= $song["title"] ?>
                </a>
                <a class="artist" href="">
                    <?= $song["artist"] ?>
                </a>
            </div>
            <div class="bottom">
                <!--<video controls="" _autoplay="" name="media" id="mediaElement">
                    <source src="<?= $song["tracks"][0] ?>" type="audio/mpeg">
                </video>-->
                <div class="audio-progress">
                    <input id="audioProgress" type="range" min="0" value="0">
                    <div class="time">
                        <span class="time-current">00:00</span>
                        <span class="time-end">10:00</span>        
                    </div>
                </div>
                <div class="audio-actions">
                    <i id="play-button" data-playing="false" class="fa fa-play"></i>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/less"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sass.js/0.9.2/sass.min.js" integrity="sha512-mA5b7w9mZvGLWgjIqp9KhWNzkkZ/H3gC4Ua6GOn9m/xl1UF4ghH8GsriKvAYxLsxoKvn6NdebW7kZ6iGB3CGSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        let audioCtx = null;
        let mediaElement = null;
        let source = null;
        let tracks = {};
        let trackSource = null;
        let trackConnected = false;
        let intervalListener = null;
        let buffers = {};
        let resources;
        <?= "resources = ['" . join("', '", $song["tracks"]) . "'];" ?>
        <?= "const lyricsURL = '" . $song["lyrics"] . "';" ?>
    </script>

    <script src="studio.js"></script>

    <script>
        $("#range").on("change", e => {
            console.log( e.target.value );
        });
    </script>
</body>

</html>