<?php

/**
 * Cakestrap
 *
 * @author Christopher M. Natan
 * @version 1.0
 */
namespace Cakestrap\View\Helper;

class AlertHelper extends Basic
{
    public $requiredJs = ['alert'];
    protected $_defaultConfig = [
        'type'          => 'alert-info',
        'dismissible'   => false,
        'align'         => 'text-center',
        'label'         => 'close',
        'icon'          => 'fa-info-circle'
    ];

    /**
     * Render the template with the values.
     * Will return the final html template.
     *
     * @return string $container
     */
    public function render()
    {
        $dismissible = $this->_getDismissible();
        $container   = $this->getTemplate()->format('container', [
            'content'     => $this->_content,
            'type'        => $this->_config['type'],
            'dismissible' => $dismissible['dismissible'],
            'button'      => $dismissible['button'],
            'align'       => $this->_config['align'],
            'icon'        => $this->_config['icon']
        ]);

        return $container;
    }

    protected function _getDismissible()
    {
        if ($this->_config['dismissible']) {
            $button = $this->getTemplate()->format('button', ['label' => $this->_config['label']]);
            return [
                'button'      => $button,
                'dismissible' => 'alert-dismissible'
            ];
        }

        return ['button' => null, 'dismissible' => null];
    }
}