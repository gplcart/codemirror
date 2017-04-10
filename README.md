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

1. Download and extract to `system/modules` manually or using composer `composer require gplcart/codemirror`. IMPORTANT: If you downloaded the module manually, be sure that the name of extracted module folder doesn't contain a branch/version suffix, e.g `-master`. Rename if needed.
2. Go to `admin/module/list` end enable the module
3. Adjust settings on `admin/module/settings/codemirror`

