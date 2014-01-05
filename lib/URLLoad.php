<?php

class URLLoad {

    public $curl_options = array();

    private static $result_keys = array(
        'http_code',
        'header_size',
        'request_size',
        'total_time',
        'namelookup_time',
        'connect_time',
        'pretransfer_time',
        'size_download',
        'speed_download',
        'redirect_count',
        'starttransfer_time',
        'redirect_time',
    );

    public function __construct($curl_options = array()) {
        $this->curl_options = $curl_options;
    }

    public function run($url = 'http://www.google.com/') {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:25.0) Gecko/20100101 Firefox/25.0');
        curl_setopt_array($ch,
            array_combine(
                array_map("constant", array_keys($this->curl_options)),
                array_values($this->curl_options)
            )
        );
        curl_exec($ch);
        $results = $this->__prepareResults(curl_getinfo($ch));
        curl_close ($ch);
        return $results;
    }

    private function __prepareResults($raw_data) {
        $result = array();
        foreach (self::$result_keys as $key) {
            // we want to have milliseconds, not seconds
            if (strpos($key, '_time') !== false) {
                $result["$key"] = $raw_data["$key"] * 1000;
            } else {
                $result["$key"] = $raw_data["$key"];
            }
        }
        return $result;
    }
}