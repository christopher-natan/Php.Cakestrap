<?php
/**
 * Cakestrap
 *
 * @author Christopher M. Natan
 * @version 1.0
 */
namespace Cakestrap\View\Helper;

class BadgeHelper extends Basic
{
    protected $_defaultConfig = [];

    /**
     * @return mixed
     */
    public function render()
    {
        $container    = $this->getTemplate()->format('container', [
            'content' => $this->_content,
        ]);

        return $container;
    }
}