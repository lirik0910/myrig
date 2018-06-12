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
	    //var_dump($id); die;
		try {
			VariableContent::where('page_id', $id)->delete();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			throw new \Exception($e->getMessage(), 1);

			return false;
		}

		foreach (json_decode($fields, true) as $data) {

			/** If current fields are multi types
			 */
			if (isset($data['multi_variable_lines'])) {

				/** Get all curent lines of current multi variable
				 */
				$lines = MultiVariableLine::where('page_id', $id)
					->where('variable_id', $data['pivot']['variable_id'])
					->get();

				/** Delete all lines of current multi variable
				 * and delete content
				 */
				foreach ($lines as $line) {
					$content = MultiVariableContent::where('multi_variable_line_id', $line->id)->get();
					foreach ($content as $value) {
						$value->delete();
					}
					$line->delete();
				}
//var_dump($data['multi_variable_lines']); die;
				foreach ($data['multi_variable_lines'] as $line) {
				    //var
                    if($line['page_id'] == $id){
                        $lineModel = new MultiVariableLine;

                        $lineModel->page_id = $id;
                        $lineModel->variable_id = $line['variable_id'];

                        /** Try save new multi variable line
                         */
                        try {
                            $lineModel->save();
                        }
                        catch (\Eception $e) {
                            logger($e->getMessage());
                            throw new \Exception($e->getMessage(), 1);

                            return false;
                        }

                        foreach ($line['content'] as $field) {
                            $contentModel = new MultiVariableContent;

                            $contentModel->multi_variable_id = $field['multi_variable']['id'];
                            $contentModel->multi_variable_line_id = $lineModel->id;
                            $contentModel->content = $field['content'];

                            /** Try save new content item
                             */
                            try {
                                $contentModel->save();
                            }
                            catch (\Eception $e) {
                                logger($e->getMessage());
                                throw new \Exception($e->getMessage(), 1);

                                return false;
                            }
                        }
                    }

				}
			}

			else {
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
		}
		return true;
	}
}
