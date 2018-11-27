<?php
namespace Cakestrap\View\Helper;

use Cake\Utility\Text;

class TopMenuHelper extends Basic
{
    public $helpers     = ['Html'];
    public $requiredJs  = ['dropdown'];
    public $requiredCss = [];

    protected $_item     = [];
    protected $_menu     = [];
    protected $_template = null;
    protected $_divider  = '_Divider_';

    protected $_defaultConfig = [
        'id' => 'topMenu'
    ];

    /**
     * @return $this
     */
    public function divider()
    {
        $this->_menu[$this->_menu['title']]['item'][] = $this->getDivider();
        return $this;
    }

    /**
     * @return string
     */
    public function getDivider()
    {
        return $this->_divider;
    }

    public function menu($title = null, $options = ['icon', 'url'])
    {
        $title                = trim($title);
        $this->_menu['title'] = $title;
        $this->_menu[$title]['options'] = $options;

        return $this;
    }

    /**
     * @return array
     */
    protected function _getMenu()
    {
        return $this->_menu;
    }

    /**
     * @param null $title
     * @param null $options
     * @param bool $isActive
     * @return $this
     */
    public function item($title = null, $options = null, $isActive = false)
    {
        $title     = trim($title);
        $menuTitle = $this->_menu['title'];
        $this->_menu[$menuTitle]['item'][][$title] = $options;

        return $this;
    }

    /**
     * @return null|string
     */
    protected function _setTemplate()
    {
        foreach($this->_getMenu() as $key => $value) {
            $haveItem       = isset($value['item']);
            $item           = null;
            $title          = trim($key);
            $suffixId       = Text::slug($title, ['replacement' => '']);
            $caret          = ($haveItem ? $this->getCaret() : null);
            $dropdown       = ($haveItem ? 'dropdown' : null);
            $additional = [
                'title'      => $title,
                'caret'      => $caret,
                'dropdown'   => $dropdown
            ];

            $options = array_merge($this->_getOptions($value['options'], $suffixId), $additional);
            $menu    = $this->getTemplate()->format('menu', $options);
            if($haveItem) {
                $this->_setItem($value['item']);
                $item = $this->_getItem();
            }
            $panel[] = $this->Html->tag('li',  $menu . $item, ['class' => 'dropdown']);
        }
        $this->_template =  $this->getTemplate()->format('container', [
            'content'    => implode('', $panel),
            'id'         => $this->_config['id']
        ]);
    }

    /**
     * @return null
     */
    protected function _getTemplate()
    {
        return $this->_template;
    }

    /**
     * @param $items
     * @return mixed
     */
    protected function _setItem($items)
    {
        $item = null;
        foreach($items as $key => $value) {
            if(is_array($value)) {
                $title   = trim(key($value));
                $options = array_merge($this->_getOptions($value[$title]), ['title' => $title]);
                $item[]  = $this->getTemplate()->format('item', $options);
            } else {
                $item[]  = $this->Html->tag('li', '', ['class' => 'divider']);
            }
        }
        $this->_item =  $this->Html->tag('ul',  implode('', $item), ['class' => 'dropdown-menu']);
    }

    /**
     * @return array
     */
    protected function _getItem()
    {
        return $this->_item;
    }

    /**
     * @param $value
     * @param null $suffixId
     * @return mixed
     */
    protected function _getOptions($value, $suffixId = null)
    {
        $id               = $this->generateId() . $suffixId;
        $option['url']    = (isset($value['url']) ? $this->toUrl($value['url']) : '#url_' . $id);
        $option['icon']   = (isset($value['icon']) ? $value['icon'] : null);

        return $option;
    }

    /**
     * Render the template with the values.
     * Will return the final html template.
     *
     * @return string $container
     */
    public function render()
    {
        unset($this->_menu['title']);
        $this->_setTemplate();
        return $this->_getTemplate();
    }
}