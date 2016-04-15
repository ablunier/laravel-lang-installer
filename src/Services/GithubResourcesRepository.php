<?php
namespace Ablunier\Laravel\Translation\Services;

class GithubResourcesRepository implements ResourcesRepository
{
    /**
     * @param $version
     * @param $lang
     *
     * @return array
     */
    public function findForVersion($version, $lang, $file)
    {
        return $this->makeRequest($version, $lang, $file);
    }

    /**
     * @return string
     */
    public function getLatestVersion()
    {
        return config('lang-installer.latest_version');
    }

    /**
     * @return array
     */
    public function getVersions()
    {
        return config('lang-installer.versions');
    }

    /**
     * @param $version
     * @param $lang
     * @param $file
     *
     * @return string
     */
    protected function getUrl($version, $lang, $file)
    {
        return $this->getLocation() . '/' . $version . '/' . $lang . '/' . $file . '.php';
    }

    /**
     * @param $version
     * @param $package
     * @param $page
     *
     * @return string
     */
    protected function makeRequest($version, $lang, $file)
    {
        $url = $this->getUrl($version, $lang, $file);

        return (string) @file_get_contents($url);
    }

    /**
     * Prepend http:// to a  string if the string does not already contain it
     *
     * @param $url
     * @return string
     */
    protected function addHttp($url)
    {
        if (! preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
        return $url;
    }

    /**
     * @return mixed
     */
    protected function getLocation()
    {
        return $this->addHttp(config('lang-installer.location'));
    }
}
