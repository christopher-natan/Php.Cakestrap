<?php

namespace Cakestrap\View\Helper;

use Cake\View\Helper;

class FormsHelper extends Basic
{
    public function submit($name, array $options = []) {
        if(!isset($options['class'])) $options['class'] = 'btn  btn-primary submit';
        if(!isset($options['type']))  $options['type']  = 'submit';

        $loader = $this->_View->Html->image('Cakestrap.loader.gif', ['class' => 'loader']);
        if($options['type'] == 'button') $loader = '';

        return $this->_View->Form->button($name, $options) . $loader;
    }

    public function button($name, array $options = [])
    {
        $defaultClass     = 'btn btn-default button ';
        $options['class'] = (isset($options['class']) ? $defaultClass . $options['class'] : $defaultClass );
        $options['type']  = 'button';

        return $this->submit($name, $options);
    }

    public function hrefButton($name, $link = null, array $options = [])
    {
        $defaultClass     = 'btn btn-default button ';
        $options['class'] = (isset($options['class']) ? $defaultClass . $options['class'] : $defaultClass );

        return $this->_View->Html->link($name, $link, $options);
    }
}

