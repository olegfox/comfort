<?php

namespace Aslan\StoreBundle\Controller;

class VideoParser {

    static $defaultVideo;

    private static function getYoutubeVideo($url) {
        $url = "http://www.youtube.com/oembed?url=" . urlencode($url) . "&format=json";
        $r = file_get_contents($url);
        $video = json_decode($r);

        if (isset($video->title)) {
            $video->html = preg_replace('/height="\d+/', 'height="auto', $video->html);
            $video->html = preg_replace('/width=\"\d+/', 'width="100%', $video->html);
            $video->html = str_replace("feature=oembed", "feature=oembed&autoplay=1", $video->html);
            return $video;
        } else {
            return false;
        }
    }

    private static function getVimeoVideo($url) {
        $url = "http://vimeo.com/api/oembed.json?url=" . urlencode($url) . "&width=720&height=439";
        $r = file_get_contents($url);
        $video = json_decode($r);

        if (isset($video->title)) {
            $video->html = preg_replace('/height="\d+/', 'height="auto', $video->html);
            $video->html = preg_replace('/width=\"\d+/', 'width="100%', $video->html);
            $video->html = str_replace("feature=oembed", "feature=oembed&autoplay=1", $video->html);
            return $video;
        } else {
            return false;
        }
    }

    public static function getVideo($url) {
        $video = array(
            "html" => "<a href=\".htmlspecialchars($url).\">" . $url . "</a>", // Значение по умолчанию, в случае если сервис не определен
            "title" => ""
        );

        self::$defaultVideo = $video;

        if (strpos($url, "youtube.com") !== false) {
            $video = self::getYoutubeVideo($url);
        }

        if (strpos($url, "vimeo.com") !== false) {
            $video = self::getVimeoVideo($url);
        }

        return $video;
    }

}

?>