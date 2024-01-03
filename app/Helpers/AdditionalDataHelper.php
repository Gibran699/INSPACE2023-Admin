<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class AdditionalDataHelper {
    private $__data;
    public function __construct($any = null, $releaseHook = true, $keyDefault = [])
    {
        if (is_object($any) || is_array($any)) {
            if ($releaseHook) $this->__data = json_decode(json_encode($any));
            else $this->__data = $any;
        }
        else if (empty($any)) $this->__data = new \stdClass;
        else {
            try {
                $result = json_decode($any);

                // Setup the value
                $this->__data = $result;

                // Initialize key default array
                if (count($keyDefault) > 0) {$this->keyDefault($keyDefault);}

            } catch (\Exception $e) {
                $this->__data = new \stdClass;
            }
        }

        if (!(is_array($this->__data))) {
            foreach($this->__data as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    /** Check data is empty */
    public function isEmpty() {
        return json_encode($this->__data) == "{}";
    }

    /** Set default key if not exists */
    public function keyDefault(array $key) {
        foreach($key as $k) {
            if (!property_exists($this->__data, $k)) {
                $this->__data->{$k} = '';
            }
        }

        return $this;
    }

    /** Get instance data */
    public function data() { return $this->__data; }
    public function d() { return $this->__data; }

    /** Edit the data value */
    public function edit(string $key, $value) {
        $this->__data->{$key} = $value;
        return $this;
    }

    /** Edit the multiple data value */
    public function editMultiple(array $value) {
        foreach($value as $key => $val) {
            $this->__data->{$key} = $val;
        }

        return $this;
    }

    /** Convert the data to json */
    public function toJson() {return json_encode($this->__data);}

    /** Getting current key with default value */
    public function get($key, $default = NULL, $newInstance = false) {

        $result = function($key, $default) {
            if (Str::contains($key, '.')) {
                $cmd = 'return $this->__data->' . str_replace('.', '->', $key) . ';';
                $tmp = @eval($cmd);
                if (empty($tmp)) return $default;
                else return $tmp;
            } else {
                if (property_exists($this->__data, $key)) return $this->__data->{$key};
                else return $default;
            }
        };

        if ($newInstance == false) return $result($key, $default);
        else return new AdditionalDataHelper($result($key, $default));
    }

    /** Check is exists / empty key */
    public function isExists($key) {
        if (property_exists($this->__data, $key)) {
            return !empty($this->__data->{$key});
        }
        return false;
    }
}
