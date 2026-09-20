<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('пользователя', 'пользователи');
    }

    protected function setupListOperation()
    {
        CRUD::column('id')->label('ID');

        CRUD::column('name')
            ->label('Имя');

        CRUD::column('email')
            ->label('Email');

        CRUD::column('avatar')
            ->label('Аватар');

        CRUD::column('created_at')
            ->label('Создан');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserRequest::class);

        CRUD::field('name')
            ->label('Имя')
            ->type('text');

        CRUD::field('email')
            ->label('Email')
            ->type('email');

        CRUD::field('password')
            ->label('Пароль')
            ->type('password');

        CRUD::field('avatar')
            ->label('Аватар')
            ->type('text');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
