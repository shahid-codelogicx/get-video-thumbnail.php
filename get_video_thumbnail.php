<?php

$link ="https://www.youtube.com/watch?v=fBNHHVu5Njo";
//$link = "https://vimeo.com/400975331"; //"https://player.vimeo.com/video/235746460";

$thumbnail = get_video_thumbnail($link);
echo $thumbnail;

function get_video_thumbnail( $src ) {

	$url_pieces = explode('/', $src);
	
	if ( $url_pieces[2] == 'vimeo.com' ) { // If Vimeo
        
		  $id = $url_pieces[3];
		  $hash = unserialize(file_get_contents('https://vimeo.com/api/v2/video/' . $id . '.php'));
    
    /**
     * Image Quality. 
     * @High quality thumbnail: [thumbnail_large]
     * @Medium quality thumbnail: [thumbnail_medium]
     * @Low quality thumbnail: [thumbnail_small]
     */
            
		  $thumbnail = $hash[0]['thumbnail_large'];

	}
  elseif ( $url_pieces[2] == 'www.youtube.com' ) { // If Youtube
  
      $extract_id = explode('=', $url_pieces[3]);
      $id = $extract_id[1];
    /**
     * Image Quality.
     * @Maximum quality thumbnail: maxresdefault.jpg
     * @High quality thumbnail: hqdefault.jpg
     * @Medium quality thumbnail: mqdefault.jpg
     * @Low quality thumbnail: sddefault.jpg
    */
    
		  $thumbnail = 'https://img.youtube.com/vi/' . $id . '/hqdefault.jpg';

	}

	return $thumbnail;

}

?>
