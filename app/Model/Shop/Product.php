<?php

namespace App\Model\Shop;

use App\Model\Base\Page;
use App\Model\Shop\ProductImage;
use App\Model\Shop\ProductOption;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $guarded = [];

	/**
	 * Get page model
	 * @return boolean
	 */
	public function page()
	{
		return $this->belongsTo(Page::class);
	}

	/**
	 * Get category model
	 * @return boolean
	 */
	public function categories()
	{
		return $this->belongsToMany(Category::class, 'product_categories');
	}

	/**
	 * Get the options for the product
	 * @return boolean
	 */
	public function options()
	{
		return $this->hasMany(ProductOption::class);
	}

	/**
	 * Get the omages for the product
	 * @return boolean
	 */
	public function images()
	{
		return $this->hasMany(ProductImage::class);
	}

	/**
	 * Get product status
	 * @return boolean
	 */
	public function productStatus()
	{
		return $this->belongsTo(ProductStatus::class);
	}

    /**
     * Get orders items with this product
     * @return boolean
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

	/**
	 * Get auto prices settings
	 * @return boolean
	 */
	public function productAutoPrices()
	{
		return $this->hasOne(ProductAutoPrice::class);
	}

   /**
    * Convert product options to array
    * @param object $options Current product options
    * @return array
    */
    public static function convertOptions($options)
    {
        $output = [];
        foreach ($options as $option) {
            if ($option->name == 'image') {
                $output['images'][] = $option;
            }

            elseif (preg_match('/[а-яё]/iu', $option->name)) {
                $output['characteristics'][] = $option;
            }

            else {
                $output[$option->name] = $option;
            }
        }
        return $output;
    }

	/**
	 * Set images to product
	 * @param string|array $images
	 * @return boolean
	 */
	public function setImages($images = '')
	{
		$data = $images;
		if (gettype($images) === 'string') {
			try {
				$data = json_decode($images, true);
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				throw new Exception($e->getMessage(), 1);
				
				return false;
			}
		}

		/** Remove all images before insert
		 */
		try {
			$collection = ProductImage::where('product_id', $this->id)->get();
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
			$model = new ProductImage;

			$model->product_id = $this->id;
			$model->name = $field['name'];

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

	/**
	 * Set options to product
	 * @param string|array $images
	 * @return boolean
	 */
	public function setOptions($options = '')
	{
		$data = $options;
		if (gettype($options) === 'string') {
			try {
				$data = json_decode($options, true);
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				throw new Exception($e->getMessage(), 1);
				
				return false;
			}
		}

		/** Remove all options before insert
		 */
		try {
			$collection = ProductOption::where('product_id', $this->id)->get();
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
			$model = new ProductOption;

			$model->product_id = $this->id;
			$model->type_id = $field['type_id'];
			$model->name = $field['name'];
			$model->value = $field['value'];

			try {
				$model->save();
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				throw new \Exception($e->getMessage(), 1);
				
				return false;
			}
		}
		return true;
	}

	/**
	 * Add categories to current product model
	 * @param string
	 * @return boolean
	 */
	public function setCategories($line = '')
	{
		$explode = explode(',', $line);

		/** Remove all categories before insert
		 */
		try {
			$collection = ProductCategory::where('product_id', $this->id)->get();
			foreach ($collection as $item) {
				$item->delete();
			}
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			throw new Exception($e->getMessage(), 1);
				
			return false;
		}

		if ($line !== '0') {
			foreach ($explode as $id) {
				$model = new ProductCategory;

				$model->product_id = $this->id;
				$model->category_id = $id;

				try {
					$model->save();
				}
				catch (\Exception $e) {
					logger($e->getMessage());
					throw new \Exception($e->getMessage(), 1);
					
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Add or update auto price settings of current products.
	 * It needs for auto count product price
	 * @param string|array $settings
	 * @return boolean
	 */
	public function setAutoPrices($settings = '')
	{
		$data = $settings;
		if (gettype($settings) === 'string') {
			try {
				$data = json_decode($settings, true);
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				throw new Exception($e->getMessage(), 1);
				
				return false;
			}
		}

		if (!isset($data['id'])) {
			$model = new ProductAutoPrice;
		}

		else {
			$model = ProductAutoPrice::findOrFail($data['id']);
		}

		$model->fill($data);
		$model->product_id = $this->id;

		/** Try to save model
		 */
		try {
			$model->save();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			throw new Exception($e->getMessage(), 1);
				
			return false;
		}
		return true;
	}
}
