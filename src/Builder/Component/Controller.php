<?php
declare(strict_types=1);

/**
 * This file is part of the Phalcon Developer Tools.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Phalcon\DevTools\Builder\Component;

use Phalcon\DevTools\Builder\Exception\BuilderException;
use Phalcon\DevTools\Utils;
use SplFileObject;

/**
 * Builder to generate controller
 */
class Controller extends AbstractComponent
{
    /**
     * Create Builder object
     *
     * @param array $options Builder options
     * @throws BuilderException
     */
    public function __construct(array $options = [])
    {
        if (!isset($options['name'])) {
            throw new BuilderException('Please specify the controller name.');
        }

        if (!isset($options['force'])) {
            $options['force'] = false;
        }

        parent::__construct($options);
    }

    /**
     * @throws BuilderException
     */
    public function build()
    {
        if ($this->options->has('directory')) {
            $this->path->setRootPath($this->options->get('directory'));
        }

        $namespace = '';
        if ($this->options->has('namespace') && $this->checkNamespace((string)$this->options->get('namespace'))) {
            $namespace = 'namespace '.$this->options->get('namespace').';'.PHP_EOL.PHP_EOL;
        }

        $baseClass = $this->options->get('baseClass', '\Phalcon\Mvc\Controller');

        if (!$controllersDir = $this->options->get('controllersDir')) {
            $config = $this->getConfig();
            if (empty($config->path('application.controllersDir'))) {
                throw new BuilderException('Please specify a controller directory.');
            }

            $controllersDir = $config->path('application.controllersDir');
        }

        if (!$this->options->has('name')) {
            throw new BuilderException('The controller name is required.');
        }

        $name = str_replace(' ', '_', $this->options->get('name'));

        $className = Utils::camelize($name);

        // Oops! We are in APP_PATH and try to get controllersDir from outside from project dir
        if ($this->isConsole() && substr($controllersDir, 0, 3) === '../') {
            $controllersDir = ltrim($controllersDir, './');
        }

        $controllerPath = rtrim($controllersDir, '\\/') . DIRECTORY_SEPARATOR . $className . "Controller.php";

        $code = "<?php\n\n" . $namespace . "class " . $className . "Controller extends " .
            $baseClass . "\n{\n\n\tpublic function indexAction()\n\t{\n\n\t}\n\n}\n\n";
        $code = str_replace("\t", "    ", $code);

        if (file_exists($controllerPath) && !$this->options->has('force')) {
            throw new BuilderException(sprintf('The Controller %s already exists.', $name));
        }

        $controller = new SplFileObject($controllerPath, 'w');
        if (!$controller->fwrite($code)) {
            throw new BuilderException(
                sprintf('Unable to write to %s. Check write-access of a file.', $controller->getRealPath())
            );
        }

        if ($this->isConsole()) {
            $this->notifySuccess(sprintf('Controller "%s" was successfully created.', $name));
            echo $controller->getRealPath(), PHP_EOL;
        }

        return $className . 'Controller.php';
    }
}