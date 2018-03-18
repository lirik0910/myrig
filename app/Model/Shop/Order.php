<?php

namespace App\Model\Shop;

use App\Model\Base\User;
use App\Model\Base\Context;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
	/**
	 * Get order status
	 * @return boolean
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Get order context
	 * @return boolean
	 */
	public function context()
	{
		return $this->belongsTo(Context::class);
	}

	/**
	 * Get order status
	 * @return boolean
	 */
	public function status()
	{
		return $this->belongsTo(OrderStatus::class);
	}

	/**
	 * Get order payment type
	 * @return boolean
	 */
	public function paymentType()
	{
		return $this->belongsTo(PaymentType::class);
	}

	/**
	 * Get order delivery
	 * @return boolean
	 */
	public function orderDeliveries()
	{
		return $this->hasOne(OrderDelivery::class);
	}


    /**
     * Get order products
     * @return boolean
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'carts', 'order_id', 'product_id')->withPivot('count');
    }

	/**
	 * Get order products
	 * @return boolean
	 */
	public function carts()
	{
		return $this->hasMany(Cart::class);
	}

	/**
	 * Count order cost
	 * @return float
	 */
	public function countCost()
	{

	}

	/**
	 * Change order status
	 * @return boolean
	 */
	public function changeStatus()
	{

	}

	public function addProduct()
	{
		
	}
}
