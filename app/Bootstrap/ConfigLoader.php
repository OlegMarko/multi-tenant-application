<?php
/**
 * Created by PhpStorm.
 * User: oleg-m
 * Date: 26.10.17
 * Time: 12:17
 */

namespace App\Bootstrap;


use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;
use Illuminate\Contracts\Config\Repository as RepositoryContract;

class ConfigLoader extends LoadConfiguration
{
    /**
     * {@inheritdoc}
     */
    protected function loadConfigurationFiles(Application $app, RepositoryContract $repository)
    {
        parent::loadConfigurationFiles($app, $repository);

        if (!$app->runningInConsole()) {

            $app['venture']->loadVentureConfigs();
        }
    }
}