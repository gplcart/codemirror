<?php

/**
 * @package Code Mirror
 * @author Iurii Makukh
 * @copyright Copyright (c) 2017, Iurii Makukh
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0+
 */

namespace gplcart\modules\codemirror;

use gplcart\core\Module;

/**
 * Main class for Code Mirror module
 */
class Codemirror extends Module
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Implements hook "library.list"
     * @param array $libraries
     */
    public function hookLibraryList(array &$libraries)
    {
        $libraries['codemirror'] = array(
            'name' => 'CodeMirror',
            'description' => 'In-browser code editor',
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
     * Add codemirror library and context files depending on the module settings
     * @param \gplcart\core\Controller $object
     */
    public function addLibrary($object)
    {
        if (!$object instanceof \gplcart\core\Controller) {
            throw new \InvalidArgumentException('Argument must be instance of gplcart\core\Controller');
        }

        $settings = $this->config->module('codemirror');
        $object->setJsSettings('codemirror', $settings);

        $options = array('aggregate' => false);
        $base = 'system/modules/codemirror/vendor/codemirror/CodeMirror';

        $object->addAssetLibrary('codemirror', $options);
        $object->setCss("$base/theme/{$settings['theme']}.css", $options);

        foreach ($settings['mode'] as $mode) {
            $object->setJs("$base/mode/$mode/$mode.js", $options);
        }
    }

    /**
     * Implements hook "module.enable.after"
     */
    public function hookModuleEnableAfter()
    {
        $this->getLibrary()->clearCache();
    }

    /**
     * Implements hook "module.disable.after"
     */
    public function hookModuleDisableAfter()
    {
        $this->getLibrary()->clearCache();
    }

    /**
     * Implements hook "module.install.after"
     */
    public function hookModuleInstallAfter()
    {
        $this->getLibrary()->clearCache();
    }

    /**
     * Implements hook "module.uninstall.after"
     */
    public function hookModuleUninstallAfter()
    {
        $this->getLibrary()->clearCache();
    }

}
