[![Build Status](https://scrutinizer-ci.com/g/gplcart/codemirror/badges/build.png?b=master)](https://scrutinizer-ci.com/g/gplcart/codemirror/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gplcart/codemirror/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gplcart/codemirror/?branch=master)

Code Mirror is a [GPL Cart](https://github.com/gplcart/gplcart) module that provides [Code Mirror](https://github.com/codemirror/codemirror) library for other modules. Don't install if your modules don't require it.

Example of usage in your module - add Code Mirror on every page within admin area

    /**
     * Implements hook "construct.controller.backend"
     * @param \gplcart\core\controllers\backend\Controller $object
     */
    public function hookConstructControllerBackend($object)
    {
    	if ($this->config->isEnabledModule('codemirror')) {
    		/* @var $module \gplcart\modules\codemirror\Codemirror */
    		$module = $this->config->getModuleInstance('codemirror');
    		$module->addLibrary($object);
		}
    }
    

**Installation**

This module requires 3-d party library which should be downloaded separately. You have to use [Composer](https://getcomposer.org) to download all the dependencies.

1. From your web root directory: `composer require gplcart/codemirror`. If the module was downloaded and placed into `system/modules` manually, run `composer update` to make sure that all 3-d party files are presented in the `vendor` directory. 
2. Go to `admin/module/list` end enable the module
3. Adjust settings on `admin/module/settings/codemirror`

