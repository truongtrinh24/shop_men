<?php
abstract class ServiceProvider{
    public $db = null;
    public $model = [];
    abstract public function boot();
}