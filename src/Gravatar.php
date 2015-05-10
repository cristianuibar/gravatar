<?php namespace Uibar\Gravatar;

class Gravatar implements Contracts\GravatarInterface
{

    const AVATAR_BASE_URL = 'gravatar.com/avatar/';

    protected $email = NULL;

    protected $size = 80;

    protected $defaultGravatar = 'mm';

    protected $rating = 'g';

    protected $image = FALSE;

    protected $attributes = [];

    /**
     * This function is used as a quick way for
     * the user to return the avatar url or the image.
     *
     * @param   string $email The email for which to fetch the avatar
     * @param   int $size The desired size of the avatar (in pixels [1-2048])
     * @param   string $defaultGravatar Default image set to use if avatar not found
     * @param   string $rating The maximum rating you want to allow [ g | pg | r | x ]
     * @param   bool $image The return should be a full image tag?
     * @param   array $attributes Additional key=value pairs to include in the image tag
     *
     * @return  string  Contains either the url or the full image tag of the avatar
     *
     * @throws EmptyEmailException
     */
    public function get($email, $size = 80, $defaultGravatar = 'mm', $rating = 'g', $image = false, $attributes = [])
    {
        $url = $this->getFinalUrl($email, $size, $defaultGravatar, $rating);

        if ($image) {
            $url = '<img src="' . $url . '"';
            foreach ($attributes as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }

    /**
     * Used to end the method chaining.
     *
     * @return string The url or the full image tag of the Gravatar
     * @throws Exception If no email was provided.
     */
    public function make()
    {
        if (!$this->email) $this->exception('No email was provided.');
        return $this->get(
            $this->email, $this->size,
            $this->defaultGravatar, $this->rating,
            $this->image, $this->attributes);
    }

    /**################################**
    #####       HELPER FUNCTIONS    #####
    #####   ~can be used publicly~  #####
    **################################**/

    public function prepEmail($email)
    {
        return strtolower(trim($email));
    }

    /**################################**
    #####       LIBRARY SPECIFIC    #####
    **################################**/

    /**
     * Append every item to the final URL.
     *
     * @param $email
     * @param $size
     * @param $defaultGravatar
     * @param $rating
     *
     * @return string The final URL.
     */
    protected function getFinalUrl($email, $size, $defaultGravatar, $rating)
    {
        $url = $this->getBaseUrl();
        $url .= md5($this->prepEmail($email));
        $url .= "?s=$size&d=$defaultGravatar&r=$rating";

        return $url;
    }

    /**
     * Used to apped the correct request type.
     *
     * @return string The Base URL of Gravatar
     */
    protected function getBaseUrl()
    {
        //TODO: Append the correct HTTP or HTTPS based on request type.
        return 'http://'.static::AVATAR_BASE_URL;
    }

    /**
     * Used to handle exceptions Lib-wide.
     *
     * @param string $message The message to be displayed to the user.
     * @throws Exception
     *
     * @return void
     */
    protected function exception($message = '')
    {
        throw new Exception($message);
    }

    /**################################**
    #####       METHOD CHAINING     #####
    **################################**/

    /**
     * Define the email address used to generate the avatar URL.
     *
     * @param string $email
     * @return object
     */
    public function email($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Updates the size of the final avatar URL.
     *
     * @param int $size
     * @return object
     */
    public function size($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Updates the default gravatar to be returned if user has no Garavtar defined.
     *
     * @param string $defaultGravatar
     * @return object
     */
    public function defaultGravatar($defaultGravatar)
    {
        $this->defaultGravatar = $defaultGravatar;
        return $this;
    }

    /**
     * Updates the default rating that the return image should allow.
     *
     * @param string $rating
     * @return object
     */
    public function rating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    //TODO: Method chaining to generate full image tag.

}
