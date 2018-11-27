<?php
/**
 * Cakestrap
 *
 * @author Christopher M. Natan
 * @version 1.0
 */
namespace Cakestrap\View\Helper;

class AlertModalHelper extends Basic
{
    public $requiredJs        = ["modal", 'message'];
    protected $_defaultConfig = [];

    /**
     * Render the template with the values.
     * Will return the final html template.
     *
     * @return string $container
     */
    public function render()
    {
        $container    = $this->getTemplate()->format('container', [
            'content' => $this->_content
        ]);

        return $container;
    }
}