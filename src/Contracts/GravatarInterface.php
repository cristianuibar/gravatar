<?php

namespace Uibar\Gravatar\Contracts;

interface GravatarInterface
{
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
    public function get($email, $size, $default, $rating, $image, $attributes);
}
