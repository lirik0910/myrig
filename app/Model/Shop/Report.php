<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = [];

    /*
     * Bind with Report products model
     */
    public function products()
    {
        return $this->hasMany(ReportProduct::class);
    }

    /**
     * Set products to report
     * @param string|array $products
     * @return boolean
     */
    public function setProducts($products = '')
    {
        $data = $products;
        if (gettype($products) === 'string') {
            try {
                $data = json_decode($products, true);
            }
            catch (\Exception $e) {
                logger($e->getMessage());
                throw new Exception($e->getMessage(), 1);

                return false;
            }
        }

        /** Remove all products before insert
         */
        try {
            $collection = ReportProduct::where('report_id', $this->id)->get();
            foreach ($collection as $item) {
                $item->delete();
            }
        }
        catch (\Exception $e) {
            logger($e->getMessage());
            throw new Exception($e->getMessage(), 1);

            return false;
        }

        foreach ($data as $field) {
            if($field['id'] == 0){
                continue;
            }
            $model = new ReportProduct;

            $model->report_id = $this->id;
            $model->product_id = $field['id'];
            $model->count = $field['count'];

            try {
                $model->save();
            }
            catch (\Exception $e) {
                logger($e->getMessage());
                throw new Exception($e->getMessage(), 1);

                return false;
            }
        }
        return true;
    }
}
