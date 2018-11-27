<?php
/**
 * Cakestrap
 *
 * @author Christopher M. Natan
 * @version 1.0
 */
namespace Cakestrap\View\Helper;

class NoteHelper extends Basic
{
    protected $_defaultConfig = [
        'icon'   => 'fa-info-circle',
        'spacer' => false
    ];

    /**
     * @return null|string
     */
    public function render()
    {
        $spacer       = ($this->_config['spacer'] ? $this->getTemplate()->format('spacer', ['spacer' => '']) : null);
        $container    = $this->getTemplate()->format('container', [
            'icon'    => $this->_config['icon'],
            'content' => $this->_content,
            'spacer'  => $spacer
        ]);

        return $container;
    }
}