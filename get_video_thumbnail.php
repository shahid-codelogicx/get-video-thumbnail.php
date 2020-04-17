<?php

$link ="https://www.youtube.com/watch?v=fBNHHVu5Njo";
//$link = "https://vimeo.com/400975331"; //"https://player.vimeo.com/video/235746460";

$thumbnail = get_video_thumbnail($link);
echo $thumbnail;

function get_video_thumbnail( $src ) {

	$url_pieces = explode('/', $src);
	
	if ( $url_pieces[2] == 'player.vimeo.com' || $url_pieces[2] == 'vimeo.com') { // If Vimeo
        
	    preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $src, $match);
	    $vimeo_id = $match[3];
            $hash = unserialize(file_get_contents('https://vimeo.com/api/v2/video/' . $vimeo_id . '.php'));
    
	    /**
	     * Image Quality. 
	     * @High quality thumbnail: [thumbnail_large]
	     * @Medium quality thumbnail: [thumbnail_medium]
	     * @Low quality thumbnail: [thumbnail_small]
	     */
            
	    $thumbnail = $hash[0]['thumbnail_large'];

        }elseif ( $url_pieces[2] == 'www.youtube.com' ||  $url_pieces[2] == 'youtu.be') { // If Youtube
    
           // Here is a sample of the URLs this regex matches: (there can be more content after the given URL that will be ignored)

	   // http://youtu.be/dQw4w9WgXcQ
	   // http://www.youtube.com/embed/dQw4w9WgXcQ
	   // http://www.youtube.com/watch?v=dQw4w9WgXcQ
	   // http://www.youtube.com/?v=dQw4w9WgXcQ
	   // http://www.youtube.com/v/dQw4w9WgXcQ
	   // http://www.youtube.com/e/dQw4w9WgXcQ
	   // http://www.youtube.com/user/username#p/u/11/dQw4w9WgXcQ
	   // http://www.youtube.com/sandalsResorts#p/c/54B8C800269D7C1B/0/dQw4w9WgXcQ
	   // http://www.youtube.com/watch?feature=player_embedded&v=dQw4w9WgXcQ
	   // http://www.youtube.com/?feature=player_embedded&v=dQw4w9WgXcQ

	   // It also works on the youtube-nocookie.com URL with the same above options.
	   // It will also pull the ID from the URL in an embed code (both iframe and object tags)

           preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $src, $match);
           $youtube_id = $match[1];
	   /**
	     * Image Quality.
	     * @Maximum quality thumbnail: maxresdefault.jpg
	     * @High quality thumbnail: hqdefault.jpg
	     * @Medium quality thumbnail: mqdefault.jpg
	     * @Low quality thumbnail: sddefault.jpg
	   */
    
	   $thumbnail = "https://img.youtube.com/vi/$youtube_id/hqdefault.jpg";

	}

	return $thumbnail;

}

?>
