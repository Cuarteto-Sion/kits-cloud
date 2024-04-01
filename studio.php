<?php
$song = array(
    "title" => "Obra en mi",
    "artist" => "Prueba de Letra",
    "lyrics" => "content/PUBLICADOS/.lyrics.json",
    "tracks" => array(
        "content/PUBLICADOS/Transformados/SOPRANO - Transformados_sesión.mp3",
        "content/PUBLICADOS/Transformados/ALTO - Transformados_sesión.mp3",
        "content/PUBLICADOS/Transformados/TENOR - Transformados_sesión.mp3",
        "content/PUBLICADOS/Transformados/BASS - Transformados_sesión.mp3",
    )
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
</head>

<body>
    <div class="content">
        <div class="lyrics"></div>
    </div>

    <div class="player">
        <div class="left"></div>
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
                <video controls name="media" id="mediaElement" playsinline>
                    <source src="<?= $song["tracks"][0] ?>" type="audio/mpeg">
                </video>
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
</body>

</html>