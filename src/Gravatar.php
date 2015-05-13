<?php namespace Uibar\Gravatar;

use Illuminate\Http\Request;

class Gravatar implements Contracts\GravatarInterface
{

    const AVATAR_BASE_URL = 'gravatar.com/avatar/';

    protected $email = NULL;

    protected $size = 80;

    protected $defaults = 'mm';

    protected $rating = 'g';

    protected $attributes = [];

    /**
     * This function is used as a quick way for
     * the user to return the avatar url or the image.
     *
     * @param   string $email The email for which to fetch the avatar
     * @param   int $size The desired size of the avatar (in pixels [1-2048])
     * @param   string $defaults Default image set to use if avatar not found
     *                          [ 404 | mm | identicon | monsterid | wavatar ]
     * @param   string $rating The maximum rating you want to allow [ g | pg | r | x ]
     * @param   bool $image The return should be a full image tag?
     * @param   array $attributes Additional key=value pairs to include in the image tag
     *
     * @return  string  Contains either the url or the full image tag of the avatar
     *
     * @throws EmptyEmailException
     */
    public function get($email, $size = 80, $defaults = 'mm', $rating = 'g', $image = false, $attributes = [])
    {
        $url = $this->getFinalUrl($email, $size, $defaults, $rating);

        if ($image) {
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
     * @param bool $image Do you want to generate a full image tag?
     * @return string The url or the full image tag of the Gravatar
     * @throws Exception If no email was provided.
     */
    public function make($image = FALSE)
    {
        if (!$this->email) $this->exception('No email was provided.');
        return $this->get(
            $this->email, $this->size,
            $this->defaults, $this->rating,
            $image, $this->attributes);
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
     * @param $defaults
     * @param $rating
     *
     * @return string The final URL.
     */
    protected function getFinalUrl($email, $size, $defaults, $rating)
    {
        $url = $this->getBaseUrl();
        $url .= md5($this->prepEmail($email));
        $url .= "?s=$size&d=$defaults&r=$rating";

        return $url;
    }

    /**
     * Used to apped the correct request type.
     *
     * @return string The Base URL of Gravatar
     */
    protected function getBaseUrl()
    {
        return $this->getRequestType().'://'.static::AVATAR_BASE_URL;
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

    protected function getRequestType()
    {
        return Request::secure() ? 'https' : 'http';
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
     * @param string $defaults
     * @return object
     */
    public function defaults($defaults)
    {
        $this->defaults = $defaults;
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

    public function attributes(Array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

}
