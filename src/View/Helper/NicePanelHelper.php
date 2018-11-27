<?php
namespace Cakestrap\View\Helper;

class NicePanelHelper extends Basic
{
    public $requiredCss = ['nice-panel'];
    protected $_defaultConfig = [
        'id'    => 'nicePanel',
        'title' => null,
        'icon'  => 'fa-home'
    ];

    /**
     * Render the template with the values.
     * Will return the final html template.
     *
     * @return string $container
     */
    public function render()
    {
        $container   = $this->getTemplate()->format('container', [
            'icon'        => $this->_config['icon'],
            'content'     => $this->_content,
            'title'       => $this->_title($this->_config['title']),
            'note'        => $this->_note()
        ]);

        return $container;
    }

    /**
     * @return null|string
     */
    protected function _note()
    {
        return (string)$this->getTemplate()->format('note', ['note' => $this->_note]);
    }

    /**
     * @param $title
     * @return null|string
     */
    protected function _title($title)
    {
        return $this->getTemplate()->format('title', ['title' => $title]);
    }
}