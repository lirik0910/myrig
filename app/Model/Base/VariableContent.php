<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;

class VariableContent extends Model
{
	/**
	 * Get page model
	 * @return boolean
	 */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

	protected $guarded = [];
	
	/**
	 * Update variables content
	 * @param int $id Page ID
	 * @param string $fields JSON string of fields data
	 * @return boolean
	 */
	public static function content(int $id, string $fields)
	{
		try {
			VariableContent::where('page_id', $id)->delete();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			throw new \Exception($e->getMessage(), 1);

			return false;
		}

		foreach (json_decode($fields, true) as $data) {
			foreach ($data['variable_content'] as $item) {
				$model = new VariableContent;

				$model->page_id = $id;
				$model->variable_id = $data['pivot']['variable_id'];
				$model->content = $item['content'];

				/** Try safe new model
				 */
				try {
					$model->save();
				}
				catch(\Exception $e) {
					logger($e->getMessage());
					throw new \Exception($e->getMessage(), 1);

					return false;
				}
			}
		}
		return true;
	}
}
