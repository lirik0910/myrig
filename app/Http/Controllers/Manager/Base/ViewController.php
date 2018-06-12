<?php

namespace App\Http\Controllers\Manager\Base;

use App\Model\Base\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{
	protected $from = '/assets/manager/build/static';
	protected $to = '/static';

	/**
	 * Get json array of all views
	 * @return Illuminate\Http\JsonResponse
	 */
	public function all()
	{
		try {
			$all = View::all();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($all, 200);
	}

	/**
	 * Get manager template page
	 * @return string
	 */
	public function index()
	{
		return view('content.manager', $this->bandle());
	}

	public function bandle() : array
	{
		$a = [
			'js' => '',
			'css' => ''
		];

		/** If not exists current bundle files at all,
		 * then copy new bundles and return new files
		 */
		if (!File::exists(public_path() . $this->to)) {
			File::deleteDirectory(public_path() . $this->to, true);
			if (File::copyDirectory(resource_path() . $this->from, public_path() . $this->to)) {
				return $this->getCurrentBundles($a);
			}
		}

		if (File::exists(resource_path() . $this->from)) {
			$current = $this->getCurrentBundles($a);
			foreach (File::allFiles(resource_path() . $this->from) as $file) {
				$file = (string) $file;
				$file = explode('main.', $file);

				if (!strripos($file[1], '.map')) {
					if (strripos($file[1], '.css')) {
						$a['css'] = 'main.' . $file[1];
					}

					if (strripos($file[1], '.js')) {
						$a['js'] = 'main.' . $file[1];
					}
				}
			}

			if(array_diff($a, $current)) {
				File::deleteDirectory(public_path() . $this->to, true);
				if (File::copyDirectory(resource_path() . $this->from, public_path() . $this->to)) {
					return $this->getCurrentBundles($a);
				}
			}
		}
		return $a;
	}

	/**
	 * Retrun current bundles
	 * @param {array} $a
	 * @return array
	 */
	public function getCurrentBundles(array $a = []) : array
	{
		if (File::exists(public_path() . $this->to)) {
			foreach (File::allFiles(public_path() . $this->to) as $file) {
				$file = (string) $file;
				$file = explode('main.', $file);

				if (!strripos($file[1], '.map')) {
					if (strripos($file[1], '.css')) {
						$a['css'] = 'main.' . $file[1];
					}

					if (strripos($file[1], '.js')) {
						$a['js'] = 'main.' . $file[1];
					}
				}
			}
		}
		return $a;
	}
}
