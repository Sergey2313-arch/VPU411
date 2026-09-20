<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CategoryCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public function setup()
    {
        CRUD::setModel(Category::class);

        CRUD::setRoute(
            config('backpack.base.route_prefix') . '/category'
        );

        CRUD::setEntityNameStrings(
            'категорию',
            'категории'
        );
    }
    protected function setupReorderOperation()
    {
        CRUD::set('reorder.label', 'title');

        // 0 = неограниченная глубина вложенности
        CRUD::set('reorder.max_level', 0);

        CRUD::set('reorder.escaped', true);
    }
    protected function setupListOperation()
    {
        CRUD::column('id')
            ->label('ID');

        CRUD::column('title')
            ->label('Название');

        CRUD::column('slug')
            ->label('Slug');

        CRUD::column('parent')
            ->type('relationship')
            ->attribute('title')
            ->label('Родительская категория');

        CRUD::column('active')
            ->type('boolean')
            ->label('Активна');

        CRUD::column('created_at')
            ->label('Создана');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CategoryRequest::class);

        CRUD::field('title')
            ->type('text')
            ->label('Название');

        CRUD::field('slug')
            ->type('text')
            ->label('Slug');

        CRUD::field('parent_id')
            ->type('select_from_array')
            ->label('Родительская категория')
            ->options(
                Category::query()
                    ->orderBy('title')
                    ->pluck('title', 'id')
                    ->toArray()
            )
            ->allows_null(true);

        CRUD::field('active')
            ->type('checkbox')
            ->label('Активна')
            ->default(true);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
