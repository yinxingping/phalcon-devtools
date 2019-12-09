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

namespace Phalcon\Builder\Project;

/**
 * Api
 *
 * Builder to create Api application skeletons
 *
 * @package Phalcon\Builder\Project
 */
class Web extends ProjectBuilder
{
    /**
     * Project directories
     * @var array
     */
    protected $projectDirectories = [
        'app',
        'app/views',
        'app/views/index',
        'app/views/layouts',
        'app/config',
        'app/controllers',
        'app/library',
        'cache',
        'public',
        'public/img',
        'public/css',
        'public/js',
        '.phalcon'
    ];

    /**
     * Creates the configuration
     *
     * @return $this
     */
    private function createConfig()
    {
        //仅支持config.php
        $type = $this->options->get('useConfigIni') ? 'ini' : 'php';

        $getFile = $this->options->get('templatePath') . '/project/web/config.' . $type;
        $putFile = $this->options->get('projectPath') . 'app/config/config.' . $type;
        $this->generateFile($getFile, $putFile, $this->options->get('name'));

        $getFile = $this->options->get('templatePath') . '/project/web/services.php';
        $putFile = $this->options->get('projectPath') . 'app/config/services.php';
        $this->generateFile($getFile, $putFile, $this->options->get('name'));

        $getFile = $this->options->get('templatePath') . '/project/web/loader.php';
        $putFile = $this->options->get('projectPath') . 'app/config/loader.php';
        $this->generateFile($getFile, $putFile);

        $getFile = $this->options->get('templatePath') . '/project/web/constants.php';
        $putFile = $this->options->get('projectPath') . 'app/config/constants.php';
        $this->generateFile($getFile, $putFile);

        $getFile = $this->options->get('templatePath') . '/project/web/errcode.php';
        $putFile = $this->options->get('projectPath') . 'app/config/errcode.php';
        $this->generateFile($getFile, $putFile);

        return $this;
    }

    /**
     * Create Bootstrap file by default of application
     *
     * @return $this
     */
    private function createBootstrapFile()
    {
        $getFile = $this->options->get('templatePath') . '/project/web/index.php';
        $putFile = $this->options->get('projectPath') . 'public/index.php';
        $this->generateFile($getFile, $putFile);

        return $this;
    }

    /**
     * create controllers
     */
    private function createControllers()
    {
        $getFile = $this->options->get('templatePath') . '/project/web/ControllerBase.php';
        $putFile = $this->options->get('projectPath') . 'app/controllers/ControllerBase.php';
        $this->generateFile($getFile, $putFile);

        $getFile = $this->options->get('templatePath') . '/project/web/IndexController.php';
        $putFile = $this->options->get('projectPath') . 'app/controllers/IndexController.php';
        $this->generateFile($getFile, $putFile);

        return $this;
    }

    private function createLibrary()
    {
        $getFile = $this->options->get('templatePath') . '/project/web/API.php';
        $putFile = $this->options->get('projectPath') . 'app/library/API.php';
        $this->generateFile($getFile, $putFile);

        return $this;
    }

    private function createViewFiles()
    {
        //固定用volt
        $engine = 'volt';

        $getFile = $this->options->get('templatePath') . '/project/web/views/index.' . $engine;
        $putFile = $this->options->get('projectPath') . 'app/views/index.' . $engine;
        $this->generateFile($getFile, $putFile);

        $getFile = $this->options->get('templatePath') . '/project/web/views/index/index.' . $engine;
        $putFile = $this->options->get('projectPath') . 'app/views/index/index.' . $engine;
        $this->generateFile($getFile, $putFile);
    }

    /**
     * Create project files
     */
    private function createAdditionals()
    {
        $getFile = $this->options->get('templatePath') . '/project/web/composer.json';
        $putFile = $this->options->get('projectPath') . 'composer.json';
        $this->generateFile($getFile, $putFile);

        $getFile = $this->options->get('templatePath') . '/project/web/env.example';
        $putFile = $this->options->get('projectPath') . '.env';
        $this->generateFile($getFile, $putFile, $this->options->get('name'));

        $getFile = $this->options->get('templatePath') . '/project/web/env.example';
        $putFile = $this->options->get('projectPath') . 'env.example';
        $this->generateFile($getFile, $putFile, $this->options->get('name'));

        $getFile = $this->options->get('templatePath') . '/project/web/README.md';
        $putFile = $this->options->get('projectPath') . 'README.md';
        $this->generateFile($getFile, $putFile);

        return $this;
    }

    /**
     * Build project
     *
     * @return bool
     */
    public function build()
    {
        $this
            ->buildDirectories()
            ->createConfig()
            ->createBootstrapFile()
            ->createLibrary()
            ->createControllers()
            ->createViewFiles()
            ->createAdditionals();

        return true;
    }
}
