<?php

namespace App\Library;


use Illuminate\Config\Repository;
use League\Flysystem\Exception;

class Venture
{
    const VENTURE_UKRAINE = 'ua';
    const VENTURE_RUSSIA  = 'ru';

    const ALL_VENTURES = [
        self::VENTURE_UKRAINE,
        self::VENTURE_RUSSIA,
    ];

    /**
     * @var Repository
     */
    protected $config;

    /**
     * Venture constructor.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Get all ventures
     *
     * @return array
     */
    public function getAllVentures()
    {
        return self::ALL_VENTURES;
    }

    /**
     * Resolve schema based on request url.
     *
     * @return mixed
     */
    public function resolveVenture()
    {
        $requestUrl = request()->getHttpHost();
        $domainMap = config('ventures');

        return isset($domainMap[$requestUrl]) ?
            $domainMap[$requestUrl] :
            env('VENTURE_DEFAULT', 'public');
    }

    /**
     * Load venture specific configs.
     *
     * @param null $venture
     * @param Repository $config
     */
    public function loadVentureConfigs($venture = null, Repository $config)
    {
        $venture = $venture ?? $this->resolveVenture();
        $ventureConfigs = app_path() . '/../venture_configs/' . $venture . '.php';

        if (!file_exists($ventureConfigs)) {
            new Exception('Not config file');
        }

        $config = $config ?? $this->config;

        $config->set(require $ventureConfigs);
    }
}