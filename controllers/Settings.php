<?php

/**
 * @package Code Mirror
 * @author Iurii Makukh
 * @copyright Copyright (c) 2017, Iurii Makukh
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0+
 */

namespace gplcart\modules\codemirror\controllers;

use gplcart\core\models\Module as ModuleModel;
use gplcart\core\controllers\backend\Controller as BackendController;

/**
 * Handles incoming requests and outputs data related Code Mirror module settings
 */
class Settings extends BackendController
{

    /**
     * Module model instance
     * @var \gplcart\core\models\Module $module
     */
    protected $module;

    /**
     * @param ModuleModel $module
     */
    public function __construct(ModuleModel $module)
    {
        parent::__construct();

        $this->module = $module;
    }

    /**
     * Route page callback to display the module settings page
     */
    public function editSettings()
    {
        $this->setTitleEditSettings();
        $this->setBreadcrumbEditSettings();

        $this->setData('modes', $this->getLibraryModesSettings());
        $this->setData('themes', $this->getLibraryThemesSettings());
        $this->setData('settings', $this->config->getFromModule('codemirror'));

        $this->submitSettings();
        $this->outputEditSettings();
    }

    /**
     * Returns an array of available CodeMirror syntax modes
     * @return array
     */
    protected function getLibraryModesSettings()
    {
        $pattern = __DIR__ . '/../vendor/codemirror/CodeMirror/mode/*';

        $modes = array();
        foreach (glob($pattern, GLOB_ONLYDIR) as $directory) {
            $modes[] = basename($directory, '');
        }
        return gplcart_array_split($modes, 6);
    }

    /**
     * Returns an array of available CodeMirror themes
     * @return array
     */
    protected function getLibraryThemesSettings()
    {
        $pattern = __DIR__ . '/../vendor/codemirror/CodeMirror/theme/*.css';

        $themes = array();
        foreach (glob($pattern) as $file) {
            $themes[] = pathinfo($file, PATHINFO_FILENAME);
        }
        return $themes;
    }

    /**
     * Set title on the module settings page
     */
    protected function setTitleEditSettings()
    {
        $vars = array('%name' => $this->text('Codemirror'));
        $title = $this->text('Edit %name settings', $vars);
        $this->setTitle($title);
    }

    /**
     * Set breadcrumbs on the module settings page
     */
    protected function setBreadcrumbEditSettings()
    {
        $breadcrumbs = array();

        $breadcrumbs[] = array(
            'text' => $this->text('Dashboard'),
            'url' => $this->url('admin')
        );

        $breadcrumbs[] = array(
            'text' => $this->text('Modules'),
            'url' => $this->url('admin/module/list')
        );

        $this->setBreadcrumbs($breadcrumbs);
    }

    /**
     * Saves the submitted settings
     */
    protected function submitSettings()
    {
        if ($this->isPosted('save') && $this->validateSettings()) {
            $this->updateSettings();
        }
    }

    /**
     * Validate submitted module settings
     */
    protected function validateSettings()
    {
        $this->setSubmitted('settings');
        
        return !$this->hasErrors();
    }

    /**
     * Update module settings
     */
    protected function updateSettings()
    {
        $this->controlAccess('module_edit');
        $this->module->setSettings('codemirror', $this->getSubmitted());
        $this->redirect('', $this->text('Settings have been updated'), 'success');
    }

    /**
     * Render and output the module settings page
     */
    protected function outputEditSettings()
    {
        $this->output('codemirror|settings');
    }

}
