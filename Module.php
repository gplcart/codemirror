<?php

/**
 * @package Code Mirror
 * @author Iurii Makukh
 * @copyright Copyright (c) 2017, Iurii Makukh
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0+
 */

namespace gplcart\modules\codemirror;

use gplcart\core\Library,
    gplcart\core\Module as CoreModule;

/**
 * Main class for Code Mirror module
 */
class Module
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
     * @param CoreModule $module
     * @param Library $library
     */
    public function __construct(CoreModule $module, Library $library)
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
            'name' => /* @text */'Codemirror',
            'description' => /* @text */'In-browser code editor',
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
     */
    public function addLibrary($controller)
    {
        $settings = $this->module->getSettings('codemirror');
        $controller->setJsSettings('codemirror', $settings);

        $controller->addAssetLibrary('codemirror');
        $controller->setCss("system/modules/codemirror/vendor/codemirror/CodeMirror/theme/{$settings['theme']}.css");

        foreach ($settings['mode'] as $mode) {
            $controller->setJs("system/modules/codemirror/vendor/codemirror/CodeMirror/mode/$mode/$mode.js");
        }
    }

}
