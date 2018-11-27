<?php
namespace Cakestrap\View\Helper;

class PillsHelper extends Basic
{
    protected $_defaultConfig = [
        'stacked'  => 'nav-stacked'
    ];
    protected $_item   = [];

    /**
     * @param null $value
     * @param array $options
     * @param bool $isSelected
     * @return $this
     */
    public function item($value, $options = [], $isSelected)
    {
        $active          = $this->isActive($options['active']);
        $this->_item[]   = $this->getTemplate()->format('item', [
            'value'      => $value,
            'active'     => $active
        ]);

        return $this;
    }

    /**
     * @return null|string
     */
    public function render()
    {
        $content   = implode('', $this->_item);
        $container = $this->getTemplate()->format('container', [
            'content' => $content,
            'stacked' => $this->_config['stacked']
        ]);

        return $container;
    }
}