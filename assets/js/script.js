var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;

$(document).click(function (click) {
    var target = $(click.target);
    if (!target.hasClass("item") && !target.hasClass("optionsButton")) {
        hideOptionsMenu();
    }
});

$(window).scroll(function () {
    hideOptionsMenu();
});

$(document).on("change", "select.playlist", function () {
    var select = $(this);
    var playlistId = select.val();
    var songId = select.prev(".songId").val();

    $.post("addons/handlers/ajax/addToPlaylist.php", {
        playlistId: playlistId,
        songId: songId
    }).done(function (error) {
        hideOptionsMenu();
        select.val("");
        x0p('Success', 'Successfully added to playlist', 'info');
        console.log(error);
    });

});

function menuUp() {
    if (screen.width < 980) {

        document.getElementById("menu-items").classList.toggle("height");

    } else {
    }
}

$(window).bind("popstate", function () {
    openPage(location.href);
});

function updateEmail(emailClass) {
    var emailValue = $("." + emailClass).val();

    $.post("addons/handlers/ajax/updateEmail.php", {
        email: emailValue,
        username: userLoggedIn
    }).done(function (response) {
        $("." + emailClass).nextAll(".message").text(response);
    });
}

function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2) {
    var oldPassword = $("." + oldPasswordClass).val();
    var newPassword1 = $("." + newPasswordClass1).val();
    var newPassword2 = $("." + newPasswordClass2).val();

    $.post("addons/handlers/ajax/updatePassword.php", {
        oldPassword: oldPassword,
        newPassword1: newPassword1,
        newPassword2: newPassword2,
        username: userLoggedIn
    }).done(function (response) {
        $("." + oldPasswordClass).nextAll(".message").text(response);
    });
}

function removeFromPlaylist(button, playlistId) {
    var songId = $(button).prevAll('.songId').val();

    $.post("addons/handlers/ajax/removeFromPlaylist.php", {
        playlistId: playlistId,
        songId: songId
    }).done(function (error) {

        openPage("playlist.php?id=" + playlistId);
        console.log(error);
    });
}

function logout() {
    $.post("addons/handlers/ajax/logout.php", function () {
        location.reload();
    });
}

function openPage(url) {

    if (timer != null) {
        clearTimeout(timer);
    }

    if (url.indexOf("?") == -1) {
        url = url + "?";
    }

    var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
    $("#mainContent").load(encodedUrl);
    $("body").scrollTop(0);
    history.pushState(null, null, url);

}

function createPlaylist() {
    var popup;
    x0p('Enter a Name for you Playlist', null, 'input',
        function (button, text) {
            popup = text;
            if (button == 'info') {
                if (popup != "") {

                    $.post("addons/handlers/ajax/createPlaylist.php", {
                        name: popup,
                        username: userLoggedIn
                    }).done(function () {

                        openPage("yourMusic.php");
                        x0p('Congratulations',
                            'Your playlist "' + text + '" is ready!',
                            'ok', false);
                    });

                } else {
                    x0p('Cancelled',
                        'You didn\'t enter a name',
                        'error', false);
                }

            }
            if (button == 'cancel') {
                x0p('Cancelled',
                    'You didn\'t create a playlist!',
                    'error', false);
            }
        });
}

function deletePlaylist(playlistId) {
    var promptVar;
    x0p('Confirmation', 'Are you sure?', 'warning', function (button, text) {
        if (button == 'warning') {
            $.post("addons/handlers/ajax/deletePlaylist.php", {
                playlistId: playlistId
            }).done(function () {

                openPage("yourMusic.php");
            });
        }
    });
}

function hideOptionsMenu() {
    var menu = $(".optionsMenu");
    if (menu.css("display") != "none") {
        menu.css("display", "none");
    }
}

function showOptionsMenu(button) {
    var songId = $(button).prevAll('.songId').val();

    var menu = $(".optionsMenu");
    var menuWidth = menu.width();

    menu.find(".songId").val(songId);

    var scrollTop = $(window).scrollTop();
    var elementOffset = $(button).offset().top;

    var top = elementOffset - scrollTop;
    var left = $(button).position().left;

    menu.css({
        "top": top + "px",
        "left": left - menuWidth + "px",
        "display": "inline"
    });
}


function formatTime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60); //Rounds down
    var seconds = time - (minutes * 60);

    var extraZero = (seconds < 10) ? "0" : "";

    return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

    var progress = audio.currentTime / audio.duration * 100;
    $(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
}

function playFirstSong() {
    setTrack(tempPlaylist[0], tempPlaylist, true);
}

function Audio() {

    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("ended", function () {
        nextSong();
    });

    this.audio.addEventListener("canplay", function () {
        //'this' refers to the object that the event was called on
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    this.audio.addEventListener("timeupdate", function () {
        if (this.duration) {
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange", function () {
        updateVolumeProgressBar(this);
    });

    this.setTrack = function (track) {
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }

    this.play = function () {
        this.audio.play();
    }

    this.pause = function () {
        this.audio.pause();
    }

    this.setTime = function (seconds) {
        this.audio.currentTime = seconds;
    }

}
