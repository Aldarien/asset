<?php
namespace App\Service;

class Asset
{
    protected $assets;
    protected $dir;

    public function __construct()
    {
        $this->dir = config('locations.public');
    }
    public function get($identifier)
    {
        $asset = $this->find($identifier);
        return $asset->url;
    }
    protected function find($identifier)
    {
        $type = $this->getType($identifier);
        $asset = null;
        if ($type == false) {
            foreach (array_keys($this->assets) as $type) {
                if (($asset = $this->getAsset($identifier, $type))) {
                    break;
                }
            }
        } else {
            $asset = $this->getAsset($identifier, $type);
        }
        return $asset;
    }
    protected function getType($identifier)
    {
        if (strpos($identifier, '.') !== false) {
            list($name, $ext) = explode('.', $identifier);
            return $ext;
        }
        return false;
    }
    protected function getAsset($identifier, $type)
    {
        if (!isset($this->assets[$type])) {
            $this->loadAssets($type);
        }
        if (!isset($this->assets[$type])) {
            return null;
        }

        foreach ($this->assets[$type] as $asset) {
            if ($this->compareIdentifier($asset, $identifier)) {
                return $asset;
            }
        }
        return null;
    }
    protected function loadAssets($type)
    {
        $dir = $this->dir . '/' . $type . '/*.' . $type;
        $files = glob($dir);
        foreach ($files as $file) {
            $url = $this->url($file);
            $identifier = pathinfo($file)['filename'];

            $this->assets[$type] []= (object) ['identifier' => $identifier, 'url' => $url, 'type' => $type];
        }
    }
    protected function url($file)
    {
        $url = '/' . config('app.project') . '/' . str_replace('\\', '/', str_replace(realpath(config('locations.public')), '', dirname(realpath($file)))) . '/' . basename(realpath($file));
        $url = preg_replace('/\/+/', '/', $url);
        return $url;
    }
    protected function compareIdentifier($asset, $identifier)
    {
        if (strpos($identifier, '.') !== false) {
            list($name, $ext) = explode('.', $identifier);
            if ($asset->identifier == $name and $asset->type == $ext) {
                return true;
            }
        } else {
            if ($asset->identifier == $identifier) {
                return true;
            }
        }
        return false;
    }
}
