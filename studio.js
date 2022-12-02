class AudioManager {
    HTMLElement = null;
    audioBuffers = [];
    audioContext = null;
    activeBufferSourceNodes = [];
    audioUpdateInterval = null;

    async getAudioBufferFromURL(URL) {
        if (URL) {
            const response = await fetch(URL);
            const arrayBuffer = await response.arrayBuffer();
            return arrayBuffer;
        } else {
            throw new Error("URL for resource cannot be an empty string");
        }
    }

    copyBuffer(original) {
        const copy = new ArrayBuffer(original.byteLength);
        new Uint8Array(copy).set(new Uint8Array(original));
        return copy;
    }

    play(at = null, registerCallback = null) {
        if (this.audioBuffers.length) {

            if (!this.activeBufferSourceNodes.length || this.audioContext.state !== "suspended" || at) {

                at = Number(at);

                if (this.audioUpdateInterval) {
                    clearInterval(this.audioUpdateInterval);
                    this.audioUpdateInterval = null;
                }

                if (this.activeBufferSourceNodes.length) {
                    this.activeBufferSourceNodes.forEach(audio => audio.stop());
                    this.activeBufferSourceNodes = [];
                }

                this.audioContext = new AudioContext();

                Promise.all(this.audioBuffers.map(buffer => this.audioContext.decodeAudioData(this.copyBuffer(buffer))))
                    .then(buffers => {
                        for (const buffer of buffers) {
                            const sourceNode = new AudioBufferSourceNode(this.audioContext, { buffer });
                            sourceNode.connect(this.audioContext.destination);

                            if (at) {
                                sourceNode.start(0, at);
                            } else {
                                sourceNode.start();
                            }

                            this.activeBufferSourceNodes.push(sourceNode);
                        }

                        $("#audioProgress").prop("max", this.activeBufferSourceNodes[0].buffer.duration);
                        $(".time .time-current").text("TODO");
                        $(".time .time-end").text("TODO");

                        this.audioUpdateInterval = setInterval(() => {
                            if (registerCallback && "function" === typeof registerCallback) {
                                registerCallback(this.audioContext.currentTime + at);
                            }
                        }, 1000);
                    });
            } else {
                this.audioContext.resume();
            }

            $("#play-button").data("playing", true);
            $("#play-button").attr("class", "fa fa-pause");
        }
    }

    pause() {
        if (this.audioContext.state === "running") {
            this.audioContext.suspend();
            $("#play-button").data("playing", false);
            $("#play-button").attr("class", "fa fa-play");
        }
    }

    /**
     * 
     * @param {HTMLElement} element HTML Media Element to load audio from
     * @returns 
     */
    constructor(trackURLs, callbackOnReady = null, element = null) {
        /** This is executed everytime an instance is tried to perform  **/
        /** This is executed everytime an instance is tried to perform  **/

        //  An instance already exists (Singleton)
        if (typeof AudioManager.instance === "object") {
            return AudioManager.instance;
        }

        /** This is executed just on the first instance  **/
        this.audioContext = new window.AudioContext();

        //  Load all tracks and then notify ready state
        Promise.all(trackURLs.map(e => this.getAudioBufferFromURL(e)))
            .then(buffers => {
                this.audioBuffers = buffers;

                if (callbackOnReady && "function" === typeof callbackOnReady) {
                    callbackOnReady();
                }
            })

        //  An HTML Media Element was provided
        if (element) {
            //  TODO:   Handle loading Audio Context from <audio /> or media HTML Element
        }

        AudioManager.instance = this;
        return this;
        /** This is executed just on the first instance  **/
    }
}

$(document).ready(async () => {

    const audioManager = new AudioManager(resources, () => { });

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

    const updateBarTime = t => $("#audioProgress").val(t).trigger("timeupdate", [t])

    $("#play-button").on("click", () => {
        if (($("#play-button").data("playing")) === true) {
            audioManager.pause();
        } else {
            audioManager.play(null, updateBarTime);
        }
    });

    const updateLyrics = (time) => {
        var past = _data["lyrics"].filter(function (item) {
            return item.time < time;
        });
        if (_data["lyrics"][past.length] != currentLine) {
            currentLine = _data["lyrics"][past.length];
            $(".lyrics div").removeClass("highlighted");
            $(`.lyrics div:nth-child(${past.length})`).addClass("highlighted"); //Text might take up more lines, do before realigning
            align();
        }
    }

    $("#audioProgress")
        .on('timeupdate', (_, data) => {
            var time = data * 1000;
            var past = _data["lyrics"].filter(function (item) {
                return item.time < time;
            });
            if (_data["lyrics"][past.length] != currentLine) {
                currentLine = _data["lyrics"][past.length];
                $(".lyrics div").removeClass("highlighted");
                $(`.lyrics div:nth-child(${past.length})`).addClass("highlighted"); //Text might take up more lines, do before realigning
                align();
            }
        })
        .on("change", async () => { audioManager.play($("#audioProgress").val(), updateBarTime); })
        .on("input", e => updateLyrics(e.target.value * 1000)); //  TODO:   Don't trigger lyric update when this event occurs
        //  TODO:   Set range max value before user has to click on play...

    $(window).on("resize", function () {
        if ($(".lyrics").height() != lyricHeight) { //Either width changes so that a line may take up or use less vertical space or the window height changes, 2 in 1
            lyricHeight = $(".lyrics").height();
            align();
        }
    });

});