<?php

/*
  +------------------------------------------------------------------------+
  | Phalcon Developer Tools                                                |
  +------------------------------------------------------------------------+
  | Copyright (c) 2011-2016 Phalcon Team (https://www.phalconphp.com)      |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file LICENSE.txt.                             |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconphp.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
  | Authors: Andres Gutierrez <andres@phalconphp.com>                      |
  |          Eduar Carvajal <eduar@phalconphp.com>                         |
  +------------------------------------------------------------------------+
*/

namespace Phalcon\Builder;

use Phalcon\Builder\Project\BaseApi;
use Phalcon\Builder\Project\Api;
use Phalcon\Builder\Project\SimpleApi;
use Phalcon\Builder\Project\Cli;
use Phalcon\Builder\Project\Web;
use Phalcon\Utils\FsUtils;
use SplFileInfo;

/**
 * Project Builder
 *
 * Builder to create application skeletons
 *
 * @package  Phalcon\Builder
 */
class Project extends Component
{
    const TYPE_BASEAPI = 'baseapi';
    const TYPE_API     = 'api';
    const TYPE_SIMPLEAPI     = 'simpleapi';
    const TYPE_CLI     = 'cli';
    const TYPE_WEB     = 'web';

    /**
     * Current Project Type
     * @var string
     */
    private $currentType = self::TYPE_BASEAPI;

    /**
     * Available Project Types
     * @var array
     */
    private $types = [
        self::TYPE_BASEAPI => BaseApi::class,
        self::TYPE_API     => Api::class,
        self::TYPE_SIMPLEAPI     => SimpleApi::class,
        self::TYPE_CLI     => Cli::class,
        self::TYPE_WEB     => Web::class,
    ];

    /**
     * Project build
     *
     * @return mixed
     * @throws \Phalcon\Builder\BuilderException
     */
    public function build()
    {
        if ($this->options->offsetExists('directory')) {
            $this->path->setRootPath($this->options->get('directory'));
        }

        $templatePath =
            str_replace('scripts/' . str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.php', '', __FILE__) .
            'templates';

        if ($this->options->offsetExists('templatePath')) {
            $templatePath = $this->options->get('templatePath');
        }

        if ($this->path->hasPhalconDir()) {
            throw new BuilderException('Projects cannot be created inside Phalcon projects.');
        }

        $this->currentType = $this->options->get('type');

        if (!isset($this->types[$this->currentType])) {
            throw new BuilderException(sprintf(
                'Type "%s" is not a valid type. Choose among [%s] ',
                $this->currentType,
                implode(', ', array_keys($this->types))
            ));
        }

        $builderClass = $this->types[$this->currentType];

        if ($this->options->offsetExists('name')) {
            $this->path->appendRootPath($this->options->get('name'));
        }

        if (file_exists($this->path->getRootPath())) {
            throw new BuilderException(sprintf('Directory %s already exists.', $this->path->getRootPath()));
        }

        if (!mkdir($this->path->getRootPath(), 0777, true)) {
            throw new BuilderException(sprintf('Unable create project directory %s', $this->path->getRootPath()));
        }

        if (!is_writable($this->path->getRootPath())) {
            throw new BuilderException(sprintf('Directory %s is not writable.', $this->path->getRootPath()));
        }

        $this->options->offsetSet('templatePath', $templatePath);
        $this->options->offsetSet('projectPath', $this->path->getRootPath());

        /** @var \Phalcon\Builder\Project\ProjectBuilder $builder */
        $builder = new $builderClass($this->options);

        $success = $builder->build();

        $root = new SplFileInfo($this->path->getRootPath('public'));
        $fsUtils = new FsUtils();
        //仅web类项目生成css/js目录
        if (preg_match('/web/', $this->currentType)) {
            $fsUtils->setDirectoryPermission($root, ['css' => 0777, 'js' => 0777]);
        }

        if ($success === true) {
            //项目创建成功提示
            $sprintMessage = "Project '%s' was successfully created." .
                "Please run 'composer install' to install relevant dependencies packages in this project directory.";

            $this->notifySuccess(sprintf($sprintMessage, $this->options->get('name')));
        }

        return $success;
    }
}
