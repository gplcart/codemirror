<?php

/**
 * @package Code Mirror
 * @author Iurii Makukh
 * @copyright Copyright (c) 2017, Iurii Makukh
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0+
 */

namespace gplcart\modules\codemirror;

use gplcart\core\Controller;
use gplcart\core\Library;
use gplcart\core\Module;
use InvalidArgumentException;

/**
 * Main class for Code Mirror module
 */
class Main
{

    /**
     * Module class instance
     * @var \gplcart\core\Module $module
     */
    protected $module;

    /**
     * Library class instance
     * @var \gplcart\core\Library $library
     */
    protected $library;

    /**
     * @param Module $module
     * @param Library $library
     */
    public function __construct(Module $module, Library $library)
    {
        $this->module = $module;
        $this->library = $library;
    }

    /**
     * Implements hook "library.list"
     * @param array $libraries
     */
    public function hookLibraryList(array &$libraries)
    {
        $libraries['codemirror'] = array(
            'name' => 'Codemirror', // @text
            'description' => 'In-browser code editor', // @text
            'type' => 'asset',
            'module' => 'codemirror',
            'url' => 'https://codemirror.net',
            'download' => 'http://codemirror.net/codemirror.zip',
            'version_source' => array(
                'file' => 'vendor/codemirror/CodeMirror/package.json'
            ),
            'files' => array(
                'vendor/codemirror/CodeMirror/lib/codemirror.js',
                'vendor/codemirror/CodeMirror/lib/codemirror.css',
            ),
        );
    }

    /**
     * Implements hook "route.list"
     * @param array $routes
     */
    public function hookRouteList(array &$routes)
    {
        $routes['admin/module/settings/codemirror'] = array(
            'access' => 'module_edit',
            'handlers' => array(
                'controller' => array('gplcart\\modules\\codemirror\\controllers\\Settings', 'editSettings')
            )
        );
    }

    /**
     * Implements hook "module.enable.after"
     */
    public function hookModuleEnableAfter()
    {
        $this->library->clearCache();
    }

    /**
     * Implements hook "module.disable.after"
     */
    public function hookModuleDisableAfter()
    {
        $this->library->clearCache();
    }

    /**
     * Implements hook "module.install.after"
     */
    public function hookModuleInstallAfter()
    {
        $this->library->clearCache();
    }

    /**
     * Implements hook "module.uninstall.after"
     */
    public function hookModuleUninstallAfter()
    {
        $this->library->clearCache();
    }

    /**
     * Add CodeMirror library and extra files
     * @param \gplcart\core\Controller $controller
     * @throws InvalidArgumentException
     */
    public function addLibrary($controller)
    {
        if (!$controller instanceof Controller) {
            throw new InvalidArgumentException('Argument must be instance of \gplcart\core\Controller');
        }

        $settings = $this->module->getSettings('codemirror');
        $controller->setJsSettings('codemirror', $settings);

        $controller->addAssetLibrary('codemirror');
        $controller->setCss("system/modules/codemirror/vendor/codemirror/CodeMirror/theme/{$settings['theme']}.css");

        foreach ($settings['mode'] as $mode) {
            $controller->setJs("system/modules/codemirror/vendor/codemirror/CodeMirror/mode/$mode/$mode.js");
        }
    }

}
