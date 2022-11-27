$(document).ready(async () => {

    $("input").on("mousedown", e => {
        console.log(e);
    });

    const initAudio = async (at = undefined) => {
        if (document.getElementById("play-button").dataset.playing === "true" && !at) {
            if (audioCtx) {
                audioCtx.suspend();
                clearInterval(intervalListener);
                document.getElementById("play-button").dataset.playing = false;
                $("#play-button").attr("class", "fa fa-play");
            }
            return;
        }
        //  Create audio-related settings
        //const audioCtx = new (window.AudioContext || window.webkitAudioContext)();

        if (!audioCtx) {
            audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        }

        if (Object.keys(tracks).length === 0) {
            for (let e of resources) {

                const response = await fetch(e);
                const arrayBuffer = await response.arrayBuffer();
                const audioBuffer = await audioCtx.decodeAudioData(arrayBuffer);
                tracks[e] = audioBuffer;
            }
        }

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

            $("#audioProgress").prop("min", 0);
            $("#audioProgress").prop("max", buffers[e].buffer.duration);
            $(".time .time-end").text("HEY");

            buffers[e].connect(audioCtx.destination);
            trackConnected = true;

            const currentTime = at || buffers[e].context.currentTime;

            $("#audioProgress").val(currentTime).trigger("timeupdate");

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
                $("#audioProgress").val(buffers[e].context.currentTime).trigger("timeupdate");
            }, 1000);
        }

        document.getElementById("play-button").dataset.playing = true;
        $("#play-button").attr("class", "fa fa-pause");
    };

    $("#play-button").on("click", async () => { await initAudio(); });
    $("#audioProgress").on("change", async () => { await initAudio($("#audioProgress").val()); });

    //  Fetch lyrics
    let _data = await $.getJSON(lyricsURL);

    const align = () => {
        var a = $(".highlighted").height();
        var c = $(".content").height();
        var d = $(".highlighted").offset()?.top - $(".highlighted").parent().offset()?.top;
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

    $("#audioProgress").on('timeupdate', e => {
        var time = $("#audioProgress").val() * 1000;
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

    $(window).on("resize", function () {
        if ($(".lyrics").height() != lyricHeight) { //Either width changes so that a line may take up or use less vertical space or the window height changes, 2 in 1
            lyricHeight = $(".lyrics").height();
            align();
        }
    });

});