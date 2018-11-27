<?php

namespace Cakestrap\View\Helper;

class FileInputHelper extends Basic
{
    public $requiredCss  = ['jasny-bootstrap'];
    public $requiredJs   = ['file-input'];
    protected $_defaultConfig = [
        'class'     => 'alert-info',
        'default'   => false
    ];

    /**
     * @return mixed
     */
    public function render()
    {
        $status  = 'fileinput-new';
        $file    = null;
        $class   = $this->_config['class'];

        if($this->_file) {
            $file = $this->_View->Html->image($this->_file);
            $status  = 'fileinput-exists';
        }
        $container =  $this->getTemplate()->format('container', [
                      'default' => $this->_config['default'],
                      'file'    => $file,
                      'name'    => $this->_name,
                      'title'   => $this->_title,
                      'class'   => $class,
                      'status'  => $status]);

        return $container;
    }
}