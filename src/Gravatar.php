<?php

namespace Uibar\Gravatar;

class Gravatar implements Contracts\GravatarInterface {

    /**
     * This function is used as a quick way for
     * the user to return the avatar url or the image.
     *
     * @param   string  $email      The email for which to fetch the avatar
     * @param   int     $size       The desired size of the avatar (in pixels [1-2048])
     * @param   string  $default    Default image set to use if avatar not found
     * @param   string  $rating     The maximum rating you want to allow [ g | pg | r | x ]
     * @param   bool    $image      The return should be a full image tag?
     * @param   array   $attributes Additional key=value pairs to include in the image tag
     *
     * @return  string  Contains either the url or the full image tag of the avatar
     */
    public function get($email, $size = 80, $default = 'mm', $rating = 'g', $image = false, $attributes = [])
    {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$size&d=$default&r=$rating";
        if ( $image ) {
            $url = '<img src="' . $url . '"';
            foreach ( $attributes as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }
}
