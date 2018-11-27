<?php
namespace Cakestrap\View\Helper;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Filesystem\Folder;
use Cake\View\Helper;

class CakestrapHelper extends Helper
{
    public $helpers           = ['Html'];
    protected $_defaultConfig = [];
    protected $_name          = 'Cakestrap';
    protected $_required      = ['css' => ['bootstrap', 'font-awesome', 'cakestrap'], 'js' => ['Devstring.jquery']];

    /**
     * @param array $config
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->_setConfig();
    }

    /**
     * PHP reserves all function names starting with __ as magical.
     *
     * @param string $method
     * @param array $args
     * @return object $this
     */
    public function __call($method, $args = [])
    {
        $view = $this->_View;
        if (!in_array($method, $view->helpers()->loaded())) {
            $helper = sprintf('%s.%s', $this->_name, $method);
            $view->helpers()->load($helper);
            $view->{$method}->setTemplate($method);

            $this->_setAsset('js', $method);
            $this->_setAsset('css', $method);
        }

        return $view->{$method};
    }

    /**
     * @return $this
     */
    protected function _setConfig()
    {
        $params     = $this->request->params;
        $configure  = Configure::read('Assets');
        $pluginPath = Plugin::path($this->_name);
        $webroot    = sprintf('%s%s/', $pluginPath, 'webroot');

        $this->config([
            'jsPath'        => sprintf('%s/', $webroot, 'js'),
            'cssPath'       => sprintf('%s/', $webroot, 'css'),
            'jsMinify'      => $configure['Js']['minify'],
            'cssMinify'     => $configure['Css']['minify'],
            'minifyName'    => md5(strtolower(sprintf('%s_%s', $params['controller'], $params['action']))),
            'minifyFolder'  => sprintf("%s/", $configure['Minify']['folder'])
        ]);

        return $this;
    }

    /**
     * @param null $type
     * @param $method
     */
    public function _setAsset($type = null, $method)
    {
        $view = $this->_View;
        $asset = ucfirst($type);
        $name = sprintf('required%s', $asset);
        $requiredAsset = isset($view->{$method}->{$name}) && $view->{$method}->{$name};
        if ($requiredAsset) {
            $requiredAsset = $view->{$method}->{$name};
            foreach ($requiredAsset as $key => $value) {
                $this->_required[$type][] = $value;
            }
        }
    }

    /**
     * @param array $css
     * @internal param array $asset
     */
    public function css($css = [])
    {
        $asset = (!is_array($css) ? [$css] : $css);
        foreach ($asset as $key => $value) {
            $this->_required['css'][] = $value;
        }
    }

    /**
     * @param array $js
     * @internal param array $asset
     */
    public function js($js = [])
    {
        $asset = (!is_array($js) ? [$js] : $js);
        foreach ($asset as $key => $value) {
            $this->_required['js'][] = $value;
        }
    }

    /**
     * @param null $type
     * @return string
     */
    public function fetch($type = null)
    {
        return $this->_asset($type);
    }

    /**
     * @param null $asset
     * @return null|string
     */
    public function _prefix($asset = null)
    {
        if (!$asset) return null;

        $explode = explode('.', $asset);
        if (!isset($explode[1])) $asset = sprintf('Cakestrap.%s', $asset);

        return $asset;
    }

    /**
     * @param string $type
     * @return string
     */
    protected function _asset($type = 'js')
    {
        $call = ['js' => 'script', 'css' => 'css'];
        $method = $call[$type];
        $asset = [];
        $content = [];

        /* if existing asset file */
        if ($this->_config[$type . 'Minify'] && $this->_isFileExist($type)) {
            $asset = sprintf('%s%s.%s', $this->_config['minifyFolder'], $this->_config['minifyName'], $type);
            if($type == 'js') {
                $result = $this->arraySearch($this->_required[$type], 'var', false);
                $existing[] = $this->Html->scriptBlock($result);
            }
            $existing[] = $this->Html->{$method}($asset);
            return implode('', $existing);
        }

        foreach ($this->_required[$type] as $key => $value) {
            $isFoundVar = $this->_isFoundVar($value);

            if ($isFoundVar) {
                $asset[] = $this->Html->scriptBlock($value);
            } else {
                $assigned = $this->_prefix($value);
                if (!$this->_config[$type . 'Minify'])
                    $asset[] = $this->Html->{$method}($assigned);
                 else
                    $content[] = $this->_read($assigned, $type);

            }
        }

        $assets = implode('', $asset);
        if ($this->_config[$type . 'Minify']) {
            if ($content) {
                $filename = sprintf('%s.%s', $this->_config['minifyName'], $type);
                $this->_write($content, $type, $filename);
                return $this->Html->{$method}($filename);
            }
        }

        return $assets;
    }

    /**
     * @param array $additional
     * @return mixed
     */
    public function requestVar($additional = [])
    {
        $params  = $this->request->params;
        $current = ['controller' => $params['controller'], 'action' => $params['action'], 'plugin' => strtolower($params['plugin'])];
        $config  = json_encode(array_merge($additional, ['Current' => $current]));
        $config  = sprintf('var Configure = %s;', $config);

        return $this->Html->scriptBlock($config);
    }

    /**
     * @param $asset
     * @param string $type
     * @return string
     */
    protected function _read($asset, $type = 'js')
    {
        $explode = explode('.', $asset);
        $pluginName = $explode[0];
        $file = sprintf('%s.%s', $explode[1], $type);

        /* get the asset path */
        $path = sprintf('%s%s/%s/', Plugin::path($pluginName), 'webroot', $type);
        $content = file_get_contents($path . $file);

        return trim($content);
    }

    /**
     * @param $content
     * @param $type
     * @param $filename
     * @return $this
     */
    protected function _write($content, $type, $filename)
    {
        $tmpPath = sprintf('%s%s/', TMP, $type);
        if (!file_exists($tmpPath)) {
            $folder = new Folder();
            $folder->create($tmpPath);
            $folder->chmod('777');
        }

        $content = implode('', $content);
        file_put_contents(sprintf('%s%s', $tmpPath, $filename), trim($content));

        return $this;
    }

    /**
     * @param string $type
     * @return bool
     */
    protected function _isFileExist($type = 'js')
    {
        $tmpPath = sprintf('%s%s/', TMP, $type);
        $filename = sprintf('%s.%s', $this->_config['minifyName'], $type);
        if (file_exists($tmpPath . $filename)) return true;

        return false;
    }

    /**
     * @param $string
     * @return bool
     */
    protected function _isFoundVar($string)
    {
        $arrayToSearch = ['var', '=', ';'];
        return $this->arrayIsMatch($arrayToSearch, $string);
    }

    /**
     * @param $arrayToSearch
     * @param $findWord
     * @param bool $sensitive
     * @return null
     */
    public function arraySearch($arrayToSearch, $findWord, $sensitive = true)
    {
        foreach($arrayToSearch as $key=> $value) {
            if($this->stringFindWord($value, $findWord, $sensitive)) {
                return $arrayToSearch[$key];
            }
        }

        return null;
    }

    /**
     * Check if the array values contains string value
     *
     * @param array $arrayToSearch The value for search
     * @param string $string Word to search in array
     * @return boolean $isMatch Return true if string found in an array
     */
    public function arrayIsMatch($arrayToSearch, $string = null)
    {
        foreach ($arrayToSearch as &$param) $param = preg_quote($param, '/');
        $isMatch = preg_match_all('/('.join('|', $arrayToSearch).')/i', $string, $matches);

        return $isMatch;
    }

    /**
     * @param $string
     * @param $wordToFind
     * @param bool $sensitive
     * @return mixed
     */
    public function stringFindWord($string, $wordToFind, $sensitive = true)
    {
        if($sensitive)
            $pattern = sprintf('/\%s\b/', trim($wordToFind));
        else
            $pattern = sprintf('/%s/i', trim($wordToFind));
        preg_match($pattern, trim($string), $matches);

        return $matches;
    }
}