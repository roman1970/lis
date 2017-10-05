<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function(){

        new jPlayerPlaylist({
            jPlayer: "#jquery_jplayer_1",
            cssSelectorAncestor: "#jp_container_1"
        }, [

            <?php  foreach ($songs as $song):  ?>
            {  
                mp3:'http://37.192.187.83:10080<?=addslashes($song->link)?>',
                title: '<?=addslashes($song->title)?>'
            },
            <?php endforeach; ?>
          
        ], {
            swfPath: "../../dist/jplayer",
            supplied: "mp3",
            wmode: "window",
            useStateClassSkin: true,
            autoBlur: false,
            smoothPlayBar: true,
            keyEnabled: true
        });
    });
    //]]>
</script>
<style>
    .jp-audio {
        width: 100%;
    }
    img{
        width: 80%;
    }
    .center, h3{
        text-align: center;
        color: rgb(255, 215, 0);
        font-size: 30px;

    }
    .albom_txt{
        font-size: 17px;
    }
   /* @ToDo media */
    .jp-audio .jp-controls {
        width: 380px;
        padding: 20px 20px 0 50px;
    }

    .jp-toggles {
        left: 50px;
        top: 65px;
        width: 130px;
    }

    .jp-audio .jp-type-playlist .jp-time-holder {
        left: 50px;
        width: 130px;
        top: 80px;
    }
    .jp-audio .jp-type-playlist .jp-progress {
        left: 50px;
        top: 65px;
        width: 130px;
    }
    .jp-volume-controls {
        position: absolute;
        top: 102px;
        left: 50px;
        width: 200px;
    }


    .jp-audio .jp-interface {
        height: 150px;
    }

    .jp-audio .jp-type-playlist .jp-toggles {
        left: 100px;
        top: 125px;
    }
</style>
<div class="center">
    <?php if($source->cover) : ?>
        <hr>
        <img src="<?=$source->cover?>"/>

    <?php endif; ?>
    <hr>
    <p class="albom_txt">
        <img src="css/blank.gif" class="flag flag-<?=$source->author->country->iso_code?>" alt="" />
        <?=$source->author->name?></p> <hr>
    <p class="albom_txt"><?=$source->title?></p> <hr>
</div>

<div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
    <div class="jp-type-playlist">
        <div class="jp-gui jp-interface">
            <div class="jp-controls">
                <button class="jp-previous" role="button" tabindex="0">previous</button>
                <button class="jp-play" role="button" tabindex="0">play</button>
                <button class="jp-next" role="button" tabindex="0">next</button>
                <button class="jp-stop" role="button" tabindex="0">stop</button>
            </div>
            <div class="jp-progress">
                <div class="jp-seek-bar">
                    <div class="jp-play-bar"></div>
                </div>
            </div>
            <div>
                <div class="jp-volume-controls">
                    <button class="jp-mute" role="button" tabindex="0">mute</button>
                    <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                    <div class="jp-volume-bar">
                        <div class="jp-volume-bar-value"></div>
                    </div>
                </div>

                <div class="jp-time-holder">
                    <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                    <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                </div>
                <div class="jp-toggles">
                    <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                    <button class="jp-shuffle" role="button" tabindex="0">shuffle</button>
                </div>
            </div>

        </div>
        <div class="jp-playlist">
            <ul>
                <li>&nbsp;</li>
            </ul>
        </div>
        <div class="jp-no-solution">
            <span>Update Required</span>
            To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
        </div>
    </div>
</div>
