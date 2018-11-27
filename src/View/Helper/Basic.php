<?php
namespace Cakestrap\View\Helper;

use Cake\I18n\Date;
use Cake\View\StringTemplate;
use Cake\View\Helper;
use Cake\Core\Plugin;
use Cake\Utility\Xml;

/**
 * Handles basic Cakestrap magic methods.
 *
 * @package Cakestrap\View\Helper
 */
abstract class Basic extends Helper
{
    protected $_xmlPath;

    /**
     * Contains a particular html template
     *
     * @var array
     */
    protected $_template;

    /**
     * @param array $config
     */
    public function initialize(array $config)
    {
        $this->setXmlPath();
        $this->_template = new StringTemplate();
    }

    /**
     * PHP reserves all function names starting with __ as magical.
     *
     * @param string $method
     * @param array $args
     * @return object $this
     */
    public function __call($method, $args)
    {
        $method = sprintf('_' . $method);
        $this->{$method} = (isset($args[0]) ? $args[0] : null);

        return $this;
    }

    public function setXmlPath()
    {
        $this->_xmlPath =  Plugin::path('Cakestrap') . 'webroot' . DS . 'xml' . DS;
    }

    /**
     * @return mixed
     */
    public function getXmlPath()
    {
        return $this->_xmlPath;
    }

    /**
     * Assign xml template to a loaded helper.
     *
     * @param null $template
     * @return $this
     * @internal param string $name
     */
    public function setTemplate($template = null)
    {
        $path     = $this->_xmlPath;
        $file     = sprintf('%s.xml', $template);
        $exist    = file_exists($path . $file);

        if ($exist) {
            $xmlArray = Xml::toArray(Xml::build($path . $file));
            $this->_template->add($xmlArray['cakestrap']);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getTemplate()
    {
        return $this->_template;
    }

    /**
     * @return string
     */
    public function getChevron()
    {
        return '<i class="fa fa-chevron-right chevron"></i>';
    }

    /**
     * @return string
     */
    public function getCaret()
    {
        return '<b class="caret"></b>';
    }

    /**
     * @return int
     */
    public function generateId()
    {
        $date = new Date();
        return $date->getTimestamp();
    }

    /**
     * @param null $url
     * @return null|string
     */
    public function toUrl($url = null)
    {
        if(!is_array($url)) return $url;

        $merged = array_merge(['plugin' => null, 'controller' => null, 'action' => null], $url);
        return sprintf('/%s', implode('/', $merged));
    }

    /**
     * @param $isActive
     * @return null|string
     */
    public function isActive($isActive)
    {
        if($isActive) return 'active';
        return null;
    }

    /**
     * @param $isOpen
     * @return null|string
     */
    public function isOpen($isOpen)
    {
        if($isOpen) return 'in';
        return null;
    }
}