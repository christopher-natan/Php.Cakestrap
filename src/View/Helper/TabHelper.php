<?php
namespace Cakestrap\View\Helper;

class TabHelper extends Basic
{
    public $requiredJs  = ['tab'];
    public $requiredCs  = [];
    protected $_defaultConfig = [];
    protected $_item    = [];
    protected $_tab     = [];

    /**
     * Render the template with the values.
     * Will return the final html template.
     *
     * @return string $container
     */
    public function render()
    {
        $stringTemplate = $this->getTemplate();
        $tabList = $stringTemplate->format('tabList', ['tabList' => implode('', $this->_tab)]);
        $content = $stringTemplate->format('content', ['content' => implode('', $this->_item)]);

        $container = $this->getTemplate()->format('container', [
            'tabList' => $tabList,
            'content' => $content
        ]);

        return $container;
    }

    /**
     * @param null $title
     * @param null $tabPanel
     * @param bool $isActive
     * @return $this
     */
    public function item($title = null, $tabPanel = null, $isActive = false)
    {
        $id       = md5($title);
        $isActive = $this->isActive($isActive);

        $this->_item[] = $this->getTemplate()->format('tabPanel',[
            'tabPanel'  => $tabPanel,
            'active'    => $isActive,
            'id'        => $id
        ]);

        $this->_tab[] = $this->getTemplate()->format('title',[
            'title'    => $title,
            'active'   => $isActive,
            'id'       => $id
        ]);

        return $this;
    }
}