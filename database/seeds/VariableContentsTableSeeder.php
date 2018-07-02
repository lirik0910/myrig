<?php

use Illuminate\Database\Seeder;

class VariableContentsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
	    $contexts = \App\Model\Base\Context::all();
		$variable = \App\Model\Base\Variable::where('title', 'hosting')->first();

		foreach($contexts as $context){
            $page = \App\Model\Base\Page::where('link', 'calculator')->where('context_id', $context->id)->first();

            App\Model\Base\VariableContent::create([
                'page_id' => $page->id,
                'variable_id' => $variable->id,
                'content' => '5.2'
            ]);
        }


	}
}
