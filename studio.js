$(document).ready(async () => {

    $("#mediaElement").on("play", async () => {
        //  Create audio-related settings
        //const audioCtx = new (window.AudioContext || window.webkitAudioContext)();

        if (!audioCtx) {
            audioCtx = new AudioContext();
        }

        mediaElement = document.getElementById("mediaElement");

        if (!source) {
            source = audioCtx.createMediaElementSource(mediaElement);
        }

        if( Object.keys(tracks).length === 0 ) {
            for (let e of resources) {

                const response = await fetch(e);
                const arrayBuffer = await response.arrayBuffer();
                const audioBuffer = await audioCtx.decodeAudioData(arrayBuffer);
                tracks[e] = audioBuffer;
            }
        }

        const currentTime = document.getElementById("mediaElement").currentTime;

        for (let e of Object.keys(tracks)) {
            if (audioCtx.state === "suspended") {
                audioCtx.resume();
            }

            if (buffers[e]) {
                buffers[e].disconnect();
                buffers[e].stop(0);
                buffers[e] = null;
            }

            buffers[e] = new AudioBufferSourceNode(audioCtx, {
                buffer: tracks[e]
            });

            buffers[e].connect(audioCtx.destination);
            trackConnected = true;

            if (currentTime > 0) {
                buffers[e].start(0, currentTime);
            } else {
                buffers[e].start();
            }

            if (intervalListener) {
                clearInterval(intervalListener);
                intervalListener = null;
            }

            intervalListener = window.setInterval(() => {
                document.getElementById("mediaElement").currentTime = document.getElementById("mediaElement").currentTime + 1;
            }, 1000);

        }
    });

    //  Fetch lyrics
    let _data = await $.getJSON(lyricsURL);

    const align = () => {
        var a = $(".highlighted").height();
        var c = $(".content").height();
        var d = $(".highlighted").offset().top - $(".highlighted").parent().offset().top;
        var e = d + (a / 2) - (c / 2);
        $(".content").animate({
            scrollTop: e + "px"
        }, {
            easing: "swing",
            duration: 250
        });
    };

    (function generate() {
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
    })();

    var currentLine = "";

    var lyricHeight = $(".lyrics").height();

    $("video").on('timeupdate', function(e) {
        var time = this.currentTime * 1000;
        var past = _data["lyrics"].filter(function(item) {
            return item.time < time;
        });
        if (_data["lyrics"][past.length] != currentLine) {
            currentLine = _data["lyrics"][past.length];
            $(".lyrics div").removeClass("highlighted");
            $(`.lyrics div:nth-child(${past.length})`).addClass("highlighted"); //Text might take up more lines, do before realigning
            align();
        }
    });

    $(window).on("resize", function() {
        if ($(".lyrics").height() != lyricHeight) { //Either width changes so that a line may take up or use less vertical space or the window height changes, 2 in 1
            lyricHeight = $(".lyrics").height();
            align();
        }
    });

});