<?php

namespace Cakestrap\View\Helper;

use Cake\View\Helper;

class HtmlsHelper extends Basic
{
    public $helpers = ['Html'];

    public function divStart($class = '')
    {
        return sprintf('<div class="%s">', $class);
    }

    public function divEnd()
    {
        return '</div>';
    }
}

