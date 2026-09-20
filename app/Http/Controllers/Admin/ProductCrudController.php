<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('товар', 'товары');
    }

    protected function setupListOperation()
    {
        CRUD::column('id')
            ->label('ID');

        CRUD::column('title')
            ->label('Название');

        CRUD::column('slug')
            ->label('Slug');

        CRUD::column('category_id')
            ->label('Категория')
            ->type('select')
            ->entity('category')
            ->model(Category::class)
            ->attribute('title');

        CRUD::column('price')
            ->label('Цена')
            ->type('number');

        CRUD::column('active')
            ->label('Активен')
            ->type('boolean');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);

        CRUD::field('title')
            ->label('Название')
            ->type('text');

        CRUD::field('slug')
            ->label('Slug')
            ->type('text');

        CRUD::field('category_id')
            ->label('Категория')
            ->type('select_from_array')
            ->options(
                Category::query()
                    ->orderBy('title')
                    ->pluck('title', 'id')
                    ->toArray()
            )
            ->allows_null(true);

        CRUD::field('price')
            ->label('Цена')
            ->type('number');

        CRUD::field('description')
            ->label('Описание')
            ->type('textarea');

        CRUD::field('active')
            ->label('Активен')
            ->type('checkbox')
            ->default(true);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
