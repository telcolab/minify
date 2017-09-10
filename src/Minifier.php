<?php
namespace TelcoLAB\Minify;

class Minifier
{
    /**
     * @var string
     */
    protected $view;

    /**
     * @var array
     */
    protected $rules = [
        '/<!--[^\[](.*?)[^\]]-->/s' => '',
        '/<\?php/'                  => '<?php ',
        '/@(.*)\n/'                 => '@$1 ',
        '/\n+/'                     => '',
        '/\t+/'                     => '',
        '/\s+/'                     => ' ',
        '/(>)\s+(<\/?)/'            => '$1$2',
        '/\s+(\/?>)/'               => '$1',
    ];

    /**
     * @param string $view
     * @return string
     */
    public function __construct(string $view)
    {
        return $this->view = $view;
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->shouldMinify()) {
            $this->view = preg_replace(
                array_keys($this->rules),
                array_values($this->rules),
                $this->view
            );
        }

        return $this->view;
    }

    /**
     * @return bool
     */
    public function shouldMinify()
    {
        return !$this->containsBadHtml() && !$this->containsBadComments();
    }

    /**
     * @return bool
     */
    public function containsBadHtml()
    {
        return preg_match('/<(code|pre|textarea)/', $this->view) ||
        preg_match('/value=("|\')(.*)([ ]{2,})(.*)("|\')/', $this->view);
    }

    /**
     * @return bool
     */
    public function containsBadComments()
    {
        foreach (token_get_all($this->view) as $token) {
            if (!is_array($token) || !isset($token[0]) || $token[0] !== T_COMMENT) {
                continue;
            }

            if (substr($token[1], 0, 2) === '//') {
                return true;
            }
        }

        return false;
    }
}
