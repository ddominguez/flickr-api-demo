<?php

class Fotos {
    private $apikey = null;
    private $format  = null;
    private $uri = 'http://api.flickr.com/services/rest/';
    private $cachefilename = 'flickr.cache';
    
    public function __construct($apikey)
    {
        $this->apikey = $apikey;
    }
    
    public function getData($params)
    {
        $this->format = $params['format'];
        return $this->serviceCall($params);
    }
    
    public function getMediumPhotoSrc($o)
    {
        return $this->getPhotoUrl($o,'z');
    }
    
    public function getSmallPhotoSrc($o)
    {
        return $this->getPhotoUrl($o,'m');
    }
    
    public function getSquarePhotoSrc($o)
    {
        return $this->getPhotoUrl($o,'s');
    }
    
    protected function getPhotoUrl($o,$s)
    {
        return 'http://farm'.$o->farm
            .'.static.flickr.com/'
            .$o->server.'/'.$o->id.'_'
            .$o->secret.'_'.$s.'.jpg';
    }
    
    protected function prepareURI($uri,$params=null)
    {
        $querystring = '';
        if (is_array($params) && count($params)>0)
        {
            $querystring = http_build_query($params);
        }
        
        return $this->uri.'?'.$querystring;
    }
    
    protected function serviceCall($params=null)
    {
        # before we make a service call
        # lets check the cache file
        $cachefile = $this->checkCache();
        
        if ($cachefile!==false)
        {
            return $cachefile;
        }
        
        $results = '';
        
        $params['api_key'] = $this->apikey;
        $uri = $this->prepareURI($uri,$params);
        
        if (extension_loaded('curl'))
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $uri);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            $results = curl_exec($ch);
            curl_close($ch);
        }
        else
        {
            $results = file_get_contents($uri);
        }
        
        # create cache file
        $this->createCache($results);

        return $results;
    }
    
    protected function cacheFilename()
    {
        $docrootinfo = pathinfo($_SERVER['DOCUMENT_ROOT']);
        return $docrootinfo['dirname'].'/cache/'
                .$this->cachefilename.'.'.$this->format;
    }
    
    protected function createCache($data)
    {
        $handle = fopen($this->cacheFilename(), 'w');
        fwrite($handle,$data);
        fclose($handle);
        
        return true;
    }
    
    protected function checkCache()
    {
        $cachefile = $this->cacheFilename();
        if (!is_file($cachefile) || (time()-filemtime($cachefile)) > 3600)
        {
            return false;
        }

        return file_get_contents($cachefile);
    }
    
}

?>