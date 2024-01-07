<?php

namespace App\Admin\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RestaurantController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Restaurant';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Restaurant());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('店舗名'));
        $grid->column('description', __('店舗説明'));
        $grid->column('price', __('平均価格帯'))->sortable();
        $grid->column('postal_code', __('郵便番号'));
        $grid->column('address', __('住所'));
        $grid->column('phone_number', __('電話番号'));
        $grid->column('category.name', __('カテゴリ名'));
        $grid->column('image', __('画像'))->image();
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();
 
        $grid->filter(function($filter) {
            $filter->like('name', '商品名');
            $filter->like('description', '商品説明');
            $filter->between('price', '金額');
            $filter->in('category_id', 'カテゴリー')->multipleSelect(Category::all()->pluck('name', 'id'));
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Restaurant::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('店舗名'));
        $show->field('description', __('店舗説明'));
        $show->field('price', __('平均価格帯'));
        $show->field('postal_code', __('郵便番号'));
        $show->field('address', __('住所'));
        $show->field('phone_number', __('電話番号'));
        $show->field('category.name', __('カテゴリ名'));
        $show->field('image', __('画像'))->image();
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Restaurant());

        $form->text('name', __('店舗名'));
        $form->textarea('description', __('店舗説明'));
        $form->text('price', __('平均価格帯'));
        $form->text('postal_code', __('郵便番号'));
        $form->text('address', __('住所'));
        $form->text('phone_number', __('電話番号'));
        $form->select('category_id', __('カテゴリ名'))->options(Category::all()->pluck('name', 'id'));
        $form->image('image', __('画像'));

        return $form;
    }
}
