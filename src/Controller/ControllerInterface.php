<?php

namespace App\Controller;


/**
 * Interface ControllerInterface
 * Define the CRUD operations
 * @package App\Controller
 */
interface ControllerInterface
{
    public function _get($entity);
    public function _getAll();
    public function _post();
    public function _del($id);
}