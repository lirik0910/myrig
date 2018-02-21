<?php

use Illuminate\Database\Seeder;

class ComponentsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/** Add dashboard component
		 */
		App\Component::create([
			'name' => 'Статистика',
			'description' => 'Базовые показатели и статистика сайта',
			'link' => '/',
			'icon' => ''
		]);

		/** Add pages component
		 */
		App\Component::create([
			'name' => 'Страницы',
			'description' => 'Создание и редактирование страниц на сайте',
			'link' => '/pages',
			'icon' => ''
		]);

		/** Add users component
		 */
		App\Component::create([
			'name' => 'Пользователи',
			'description' => 'Управление пользователями',
			'link' => '/users',
			'icon' => ''
		]);

		/** Add views component
		 */
		App\Component::create([
			'name' => 'Шаблоны',
			'description' => 'Шаблоны страниц сайта',
			'link' => '/views',
			'icon' => ''
		]);

		/** Add settings component
		 */
		App\Component::create([
			'name' => 'Настройки',
			'description' => 'Настройка и управление сайтом',
			'link' => '/settings',
			'icon' => ''
		]);
	}
}
