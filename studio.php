<?php
    $song = array(
        "title" => "Arquitecto Divino",
        "artist" => "Heraldos del Rey",
        "lyrics" => "content/lyrics.json",
        "tracks" => array("content/tenor2.mp3")
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
                <a 
                    class="song"
                    href="">
                    <?= $song["title"] ?>
                </a>
                <a 
                    class="artist" 
                    href="">
                    <?= $song["artist"] ?>
                </a>
            </div>
            <div class="bottom">
                <video controls="" _autoplay="" name="media">
                    <source src="<?= $song["tracks"][0] ?>"
                        type="audio/mpeg">
                </video>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/less"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sass.js/0.9.2/sass.min.js"
        integrity="sha512-mA5b7w9mZvGLWgjIqp9KhWNzkkZ/H3gC4Ua6GOn9m/xl1UF4ghH8GsriKvAYxLsxoKvn6NdebW7kZ6iGB3CGSg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script async>
        console.clear();
        $.getJSON('<?= $song["lyrics"] ?>', _data => {
            var currentLine = "";
            function align() {
                var a = $(".highlighted").height();
                var c = $(".content").height();
                var d = $(".highlighted").offset().top - $(".highlighted").parent().offset().top;
                var e = d + (a / 2) - (c / 2);
                $(".content").animate(
                    { scrollTop: e + "px" }, { easing: "swing", duration: 250 }
                );
            }

            var lyricHeight = $(".lyrics").height();
            $(window).on("resize", function () {
                if ($(".lyrics").height() != lyricHeight) { //Either width changes so that a line may take up or use less vertical space or the window height changes, 2 in 1
                    lyricHeight = $(".lyrics").height();
                    align();
                }
            });

            $(document).ready(function async() {
                $("video").on('timeupdate', function (e) {
                    var time = this.currentTime * 1000;
                    var past = _data["lyrics"].filter(function (item) {
                        return item.time < time;
                    });
                    if (_data["lyrics"][past.length] != currentLine) {
                        currentLine = _data["lyrics"][past.length];
                        $(".lyrics div").removeClass("highlighted");
                        $(`.lyrics div:nth-child(${past.length})`).addClass("highlighted"); //Text might take up more lines, do before realigning
                        align();
                    }
                });
            });

            generate();

            function generate() {
                var html = "";
                for (var i = 0; i < _data["lyrics"].length; i++) {
                    html += "<div";
                    if (i == 0) {
                        html += ` class="highlighted"`;
                        currentLine = 0;
                    }
                    if (_data["lyrics"][i]["note"]) {
                        html += ` note="${_data["lyrics"][i]["note"]}"`;
                    }
                    html += ">";
                    html += _data["lyrics"][i]["line"] == "" ? "•" : _data["lyrics"][i]["line"];
                    html += "</div>"
                }
                $(".lyrics").html(html);
                align();
            }
        });
    </script>
</body>

</html>