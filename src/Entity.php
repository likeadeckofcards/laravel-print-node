<?php

namespace Infernobass7\PrintNode;

use Illuminate\Support\Facades\App;

class Entity
{
    public static $client;
    protected $attributes = [];
    protected $uri = '/';

    public function __construct($attributes = [])
    {
        self::$client = new Client();

        $this->setAttributes($attributes);
    }

    public function __get($key)
    {
        if ($key == 'client') {
            return self::$client;
        }

        if ($this->has($key)) {
            return $this->attributes[$key];
        }
    }

    public function __set($key, $value)
    {
        return $this->setAttribute($key, $value);
    }

    public function has($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    public function setAttributes($attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    public function setAttribute($key, $value)
    {
        if (array_key_exists($key, $this->foreignObjects)) {
            $value = App::make($this->getForeignClassName($key))->setAttributes($value);
        }

        $this->attributes[$key] = $value;

        return $this;
    }

    public function all()
    {
        return collect($this->client->get($this->uri))->map(function ($item) {
            return (new static())->setAttributes($item);
        });
    }

    public function getForeignClassName($key)
    {
        return $this->foreignObjects[$key];
    }

    public function toJson()
    {
        return json_encode($this->attributes);
    }

    public function toArray()
    {
        return $this->attributes;
    }

    protected function get($id)
    {
        return new static(self::$client->get("{$this->uri}/{$id}"));
    }

    public function __callStatic($method, $parameters)
    {
        //		if(method_exists($this, $name)) {
//			return $this->{$name}($params);
//		}
        return (new static())->$method(...$parameters);
    }
}
