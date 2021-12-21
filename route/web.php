<?php

use App\Controllers\UsersController;
use App\Controllers\IndexController;
use App\Controllers\RoleController;

class Route
{
    function loadPage($db, $controllerName, $actionName = 'index')
    {
        switch ($controllerName) {
            case 'users':
                $controller = new UsersController($db);
                break;
            case 'roles':
                $controller = new RoleController($db);
                break;
            default:
                $controller = new IndexController($db);
        }

        $controller->$actionName();
    }
}
