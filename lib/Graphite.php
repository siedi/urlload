<?php

class Graphite {

    public $base_ns = 'performance.urlload';
    public $server = 'graphite.local';
    public $port = '2003';

    public function __construct($graphite_options = array()) {
        if (isset($graphite_options['server'])) {
            $this->server = $graphite_options['server'];
        }
        if (isset($graphite_options['port'])) {
            $this->port = $graphite_options['port'];
        }
        if (isset($graphite_options['base_ns'])) {
            $this->base_ns = $graphite_options['base_ns'];
        }
    }

    public function save($label, $ts, $data) {
        foreach($data as $key => $value) {
            `echo "$this->base_ns.$label.$key $value $ts" | nc -q 3 $this->server $this->port`;
        }
    }
}