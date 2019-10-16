<?php

namespace App\Helpers\Utils;


interface IController
{
    public function _get();
    public function _getAll();
    public function _post();
    public function _put();
    public function _del();
}