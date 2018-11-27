<?php
namespace Cakestrap\View\Helper;

class PanelHelper extends Basic
{
    protected $_defaultConfig = [];

    /**
     * @return null|string
     */
    public function render()
    {
        $container   = $this->getTemplate()->format('container', [
            'content'     => $this->_content,
            'title'       => $this->_title()
        ]);

        return $container;
    }

    /**
     * @return null|string
     */
    protected function _title()
    {
        $title      = $this->getTemplate()->format('title', [
            'title' => $this->_title
        ]);

        return $title;
    }
}