<?php 

require_once __DIR__ . '/../../../_helpers/vendor/autoload.php';

use Service_landing\Helpers\Url;

class View 
{

    /**
     * @var string
     */
    public $sub_land;

    /**
     * @var string $page
     * @var string $error
     * @return string
     */
    public function render(string $page, string $error): string 
    {
        $content = file_get_contents(__DIR__ . "/../lands/$this->sub_land/$page.php");

        $content = str_replace("<head>", "<head>\n<base href=\"" . preg_replace('/\/aeke.*/', '/aeke/', Url::currentUri()) . "lands/$this->sub_land/\">", $content);
        $content = str_replace("</body>", "<script>document.querySelector('form').action = '" . Url::currentUri() . "' </script>", $content);
        $content = str_replace(['.css', '.js'], ['.css?v=' . password_hash("random", PASSWORD_BCRYPT, ["cost" => 4]), '.js?v=' . password_hash("random", PASSWORD_BCRYPT, ["cost" => 4])], $content);
        $content = str_replace('<p class="error"></p>', "<p class=\"error\">$error</p>", $content);
        
        return $content;
    }
}