<?php
namespace Ablunier\Laravel\Translation\Services;

interface ResourcesRepository
{
    /**
     * @param $version
     * @param $lang
     *
     * @return array
     */
    public function findForVersion($version, $lang, $file);

    /**
     * @return string
     */
    public function getLatestVersion();

    /**
     * @return array
     */
    public function getVersions();
}
