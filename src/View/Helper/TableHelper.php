<?php
namespace Cakestrap\View\Helper;

use Cake\Utility\Text;
use Devstring\Datatype\Strings;
use Devstring\Security\Securities;

class TableHelper extends Basic
{
    public $requiredJs  = [];
    public $requiredCss = ['table'];
    protected $_content = null;
    protected $_header  = [];

    protected $_defaultConfig = [
        'imageSize'  => '100x100',
        'id'         => 'table',
        'class'      => '',
        'imageField' => ['photo', 'image']
    ];

    /**
     * @return null|string
     */
    public function render()
    {
        $container = $this->getTemplate()->format('container', [
            'content' => implode('', $this->_content),
            'id'      => $this->_config['id'],
            'class'   => $this->_config['class']
        ]);

        return $container;
    }

    /**
     * @param array $headers
     * @return $this
     * @internal param array $header
     */
    public function header($headers = [])
    {
        $head  = null;
        foreach ($headers as $key => $value) {
            $item  = $value;
            if (!is_numeric($key)) $item = $key;

            $class  = (isset($this->_column[$item]) ? $this->_column[$item] : '');
            $head[] = $this->_View->Html->tag('th', ucfirst($value), ['class' => $class]);
            $this->_header[trim($item)] = trim($item);
        }

        $this->_content[] = $this->getTemplate()->format('head', ['head' => implode('', $head)]);

        return $this;
    }

    /**
     * @param array $results
     * @return $this
     */
    public function content($results = [])
    {
        $tr = [];
        foreach ($results as $key => $value) {
            $td = [];
            foreach ($this->_header as $field => $index) {
                $td[] = $this->_View->Html->tag('td', $this->_image($index, $value[$index]));
            }
            $tr[] = $this->_View->Html->tag('tr', implode('', $td), ['id' => Securities::encrypt($value['id'])]);
        }
        $this->_content[] = $this->getTemplate()->format('body', ['body' => implode('', $tr)]);

        return $this;
    }

    /**
     * @param $index
     * @param $value
     * @return string
     */
    protected function _image($index, $value)
    {
        if(!in_array($index, $this->_config['imageField'])) return Text::truncate(Strings::nice($value), 50);

        $this->_View->loadHelper('Image.Image');
        return $this->_View->Html->image($this->_View->Image->file($value, $this->_config['imageSize']));
    }
}