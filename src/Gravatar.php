<?php namespace Uibar\Gravatar;

class Gravatar implements Contracts\GravatarInterface
{

    const AVATAR_BASE_URL = 'gravatar.com/avatar/';

    protected $email = NULL;

    protected $size = 80;

    protected $defaults = 'mm';

    protected $rating = 'g';

    protected $attributes = [];

    protected $force_secure = FALSE;

    protected $image = FALSE;

    /**
     * This function is used as a quick way for the user to return the avatar url or the image.
     *
     * @param   string  $email      The email for which to fetch the avatar
     * @param   int     $size       The desired size of the avatar (in pixels [1-2048])
     * @param   string  $defaults   Default image set to use if avatar not found [ 404 | mm | identicon | monsterid | wavatar ]
     * @param   string  $rating     The maximum rating you want to allow [ g | pg | r | x ]
     * @param   bool    $image      The return should be a full image tag?
     * @param   array   $attributes Additional key=value pairs to include in the image tag
     * @return  string  Contains either the url or the full image tag of the avatar
     * @throws \Exception
     */
    public function get($email, $size = 80, $defaults = 'mm', $rating = 'g', $image = false, $attributes = [])
    {
        $url = $this->getFinalUrl($email, $size, $defaults, $rating);

        if ($image || $this->image) {
            $url = '<img src="' . $url . '"';
            foreach ($attributes as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }

    /**
     * Used to end the method chaining and deliver the final result.
     *
     * @param   array|string|bool   $params
     * @param   array               $attributes
     * @return  string|void The url or the full image tag of the Gravatar
     * @throws  \Exception
     */
    public function make($params = NULL, Array $attributes = NULL)
    {
        $image = $this->fetchMakeParams($params, $attributes);

        return $this->get(
            $this->email, $this->size,
            $this->defaults, $this->rating,
            $image, $this->attributes);
    }

    /**################################**
    #####       HELPER FUNCTIONS    #####
    #####   ~can be used publicly~  #####
    **################################**/

    /**
     * @param   string  $email      The e-mail address to be prepared.
     * @return  string|void
     * @throws \Exception
     */
    public function prepEmail($email)
    {
        if (!$this->isValidEmail($email)) return $this->exception('Invalid email format.');
        return strtolower(trim($email));
    }

    /**################################**
    #####       LIBRARY SPECIFIC    #####
    **################################**/

    /**
     * Fetches the parameters from the make method and returns
     * a BOOL value to know if we generate an image tag or just the URL.
     *
     * @param   array|string|bool   $params
     * @param   array               $attributes
     * @return bool
     */
    protected function fetchMakeParams($params, Array $attributes = NULL)
    {
        $image = FALSE;
        if (is_array($params)) {
            foreach($params as $key => $value)
                switch ($key)
                {
                    case 'email':
                        $this->email = $value;
                        break;
                    case 'image':
                        $image = $value;
                        break;
                    case 'size':
                        $this->size = $value;
                        break;
                    case 'defaults':
                        $this->defaults = $value;
                        break;
                    case 'rating':
                        $this->rating = $value;
                        break;
                    case 'attributes':
                        $this->attributes = $value;
                        break;
                    case 'forceSecure':
                        $this->force_secure = $value;
                        break;
                }
        } elseif (is_string($params))
            $this->email = $params;
        elseif (is_bool($params))
            return $params;

        if (!empty($attributes)) {
            $this->attributes = $attributes;
            $image = TRUE;
        }

        return $image;
    }

    /**
     * Checks to see if the given email is in a valid format.
     *
     * @param   string  $email The string to be checked.
     * @return  bool
     */
    protected function isValidEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Append every item to the final URL.
     *
     * @param   string  $email
     * @param   int     $size
     * @param   string  $defaults
     * @param   string  $rating
     * @return  string|void  The final URL.
     */
    protected function getFinalUrl($email, $size, $defaults, $rating)
    {
        if (empty($email)) return $this->exception('No email was provided.');

        $url = $this->getBaseUrl();
        $url .= md5($this->prepEmail($email));
        $url .= "?s=$size&d=$defaults&r=$rating";

        return $url;
    }

    /**
     * Append all elements for the base URL.
     *
     * @return  string  The Base URL of Gravatar
     */
    protected function getBaseUrl()
    {
        return $this->getRequestPrefix().static::AVATAR_BASE_URL;
    }

    /**
     * Used to handle exceptions Lib-wide.
     *
     * @param   string  $message    The message to be displayed to the user.
     * @return  void
     * @throws  \Exception
     */
    protected function exception($message = '')
    {
        throw new \Exception($message);
    }

    /**
     * Helps the class to determine the protocol and prefix to use when generating final URL.
     *
     * @return  string  The protocol and prefix that the request will use.
     */
    protected function getRequestPrefix()
    {
        if ($this->force_secure) return 'https://secure.';
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://secure.' : 'http://';
    }

    /**################################**
    #####       METHOD CHAINING     #####
    **################################**/

    /**
     * Define the email address used to generate the avatar URL.
     *
     * @param   string  $email
     * @return  object
     */
    public function email($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Updates the size of the final avatar URL.
     *
     * @param   int $size
     * @return  object
     */
    public function size($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Updates the default gravatar to be returned if user has no Garavtar defined.
     *
     * @param   string  $defaults
     * @return  object
     */
    public function defaults($defaults)
    {
        $this->defaults = $defaults;
        return $this;
    }

    /**
     * Updates the default rating that the return image should allow.
     *
     * @param   string  $rating
     * @return  object
     */
    public function rating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * Updates the protected $attributes variable with the new data.
     *
     * @param   array   $attributes
     * @return  object
     */
    public function attributes(Array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Forces the final URL for the Gravatar to be secure
     *
     * @param   bool    $fs
     * @return  object
     */
    public function forceSecure($fs = TRUE)
    {
        if (is_bool($fs)) $this->force_secure = $fs;
        return $this;
    }

    /**
     * Final return should be a full HTML img tag
     *
     * @param   bool  $fs
     * @return  object
     */
    public function image($fs = TRUE)
    {
        if (is_bool($fs)) $this->image = $fs;
        return $this;
    }

}
