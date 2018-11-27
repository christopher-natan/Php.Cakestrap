<?php
namespace Cakestrap\View\Helper;

use Cake\Utility\Hash;
use Cake\Utility\Text;

class SideMenuHelper extends Basic
{
    public $helpers           = ['Html'];
    public $requiredJs        = ['collapse', 'transition', 'side-menu'];
    public $requiredCss       = ['side-menu'];

    protected $_menu          = [];
    protected $_item          = [];
    protected $_template      = null;
    protected $_defaultConfig = [
        'id' => 'sideMenu'
    ];

    /**
     * @param array $config
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
    }

    /**
     * @param null $title
     * @param array $options
     * @return $this
     */
    public function menu($title = null, $options = ['icon', 'url'])
    {
        $title = trim($title);
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
     * @return $this
     */
    public function item($title = null, $options = null)
    {
        $title     = trim($title);
        $menuTitle = $this->_menu['title'];
        $this->_menu[$menuTitle]['item'][][$title] = $options;

        return $this;
    }

    /**
     * Render the template with the values.
     * Will return the final html template.
     *
     * @return string $container
     */

    protected function _setTemplate()
    {
        $panel = [];
        foreach($this->_getMenu() as $key => $value) {
            $haveItem   = isset($value['item']);
            $item       = null;
            $title      = trim($key);
            $suffixId   = Text::slug($title, ['replacement' => '']);
            $chevron    = ($haveItem ? $this->getChevron() : null);
            $toggle     = ($haveItem ? 'data-toggle="collapse"' : null);
            $selected   = $this->_isSelected($value);

            $additional = [ 'title'       => $title,
                            'chevron'     => $chevron,
                            'containerId' => $this->_config['id'],
                            'toggle'      => $toggle,
                            'active'      => $selected['active']];

            $options = array_merge($this->_getOptions($value['options'], $suffixId), $additional);
            $menu    = $this->getTemplate()->format('menu', $options);
            if($haveItem) {
                $this->_setItem($options['id'], $value['item'], $selected);
                $item = $this->_getItem();
            }

            $panel[] = $this->Html->div('panel panel-default', $menu . $item);
        }

        $this->_template =  $this->getTemplate()->format('container', [
                'content'   => implode('', $panel),
                'id'        => $this->_config['id']
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
     * @param $id
     * @param $items
     * @param $selected
     * @return null|string
     */
    protected function _setItem($id, $items, $selected)
    {
        if(!$items) {
            $this->_item = [];
            return;
        }
        $item = null;
        foreach($items as $key => $value) {
            $title   = trim(key($value));
            $options = array_merge($this->_getOptions($value), ['title' => $title]);
            $item[]  = $this->getTemplate()->format('item', $options);
        }

        $this->_item = $this->getTemplate()->format('itemContainer', [
            'item'    => implode('', $item),
            'id'      => $id,
            'open'    => $selected['open']
        ]);
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
        $id              = $this->generateId() . $suffixId;
        $option['url']   = (isset($value['url']) ? $this->toUrl($value['url']) : '#item_' . $id);
        $option['id']    = $id;
        $option['icon']  = (isset($value['icon']) ? $value['icon'] : null);

        return $option;
    }

    /**
     * @param $value
     * @return array
     */
    protected function _isSelected($value)
    {
        $request   = $this->request;
        $controller = null;
        $haveItem  = isset($value['item']);
        if($haveItem)  $controller = Hash::extract($value['item'], '{n}.{s}.controller');
        if(!$haveItem) $controller = Hash::extract($value['options'], 'url.controller');

        if(!$controller) return ['active' => null, 'open' => null];
        $isMatch  = ($request['controller'] == ucfirst(strtolower($controller[0])));

        return ['active' => $this->isActive($isMatch), 'open' => $this->isOpen($isMatch)];
    }

    /**
     * @return string
     */
    public function render()
    {
        unset($this->_menu['title']);
        $this->_setTemplate();

        return $this->_getTemplate();
    }
}