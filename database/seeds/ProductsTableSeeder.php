<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/** Get base context
		 */
		$context = App\Model\Base\Context::where('title', 'Base')->firstOrFail();

		/** Get default category
		 */
/*		$mainCategory = App\Model\Shop\ProductCategory::where('title', 'Base')->firstOrFail();
		$subCategory = App\Model\Shop\ProductCategory::where('title', 'Additional')->firstOrFail();*/

		/** Get default vendor
		 */
		$vendor = App\Model\Shop\Vendor::where('title', 'Base')->firstOrFail();

		$preOrderStatus = App\Model\Shop\ProductStatus::where('title', 'pre-order')->first();
		$inStockStatus = App\Model\Shop\ProductStatus::where('title', 'in-stock')->first();
		$notAvailableStatus = App\Model\Shop\ProductStatus::where('title', 'not-available')->first();

		$page = App\Model\Base\Page::where('link', 'product/dragonmint-16-th-s-2')->first();
		App\Model\Shop\Product::create([
			'context_id' => $context->id,
			//'category_id' => $mainCategory->id,
			'vendor_id' => $vendor->id,
			'page_id' => $page->id,
			'warranty' => '180 days',
			'product_status_id' => $preOrderStatus->id,
			'title' => 'DRAGONMINT T1 16TH/s',
			'description' => '<p><b>DragonMint 16TH/s</b> – The latest innovation on the Bitcoin mining market, created by Halong Mining. Based on the declared characteristics, there is no more effective SHA-256 miner to date.</p>

			<p>The main "highlight" of the design of the miner is the DM8575 chips. It is they that provide a high hashed and energy efficiency device, which is equal to 0,075J / GH. DragonMint is equipped with two fans, which ensure normal operation at temperatures from 0 to +25.</p>

			<p>Over the course of the year, many experts worked on the creation of this miner (some were developing software, others were hardware, and some were designing chips). At the same time, a huge research work was carried out. As a result, Halong Mining still managed to produce a unique product - DragonMint 16TH / s, which has excellent technical and operational characteristics.</p>',
			'active' => 1,
			'price' => '2810.00',
		]);

		$page = App\Model\Base\Page::where('link', 'product/antminer-s9-13-5th-s')->first();
		App\Model\Shop\Product::create([
			'context_id' => $context->id,
			//'category_id' => $mainCategory->id,
			'vendor_id' => $vendor->id,
			'page_id' => $page->id,
			'product_status_id' => $inStockStatus->id,
			'warranty' => '180 days',
			'title' => 'ANTMINER S9 13.5TH/s',
			'description' => '<p><b>Antminer S9</b> – One of the latest innovations in the line of miners produced by Bitmain. This model has many competitive advantages. The device perfectly combines the two main characteristics, performance and energy efficiency. Moreover, it differs compactness (dimensions of the case 30.1 × 12.3 × 15.5 cm) and excellent cooling.</p>

			<p>Simplicity of operation is another significant advantage of the presented device, because its introduction does not require special knowledge. Miner functions autonomously and has an easy setup.</p>

			<p>It should be noted that the Antminer S9 is one of the few miners in the world equipped with VM1387 chips. At the same time in the device there are 189 pieces. The hashing power is 13.5 TH / s ± 5%. Cool the design of the two fans. The power consumption declared by the manufacturer is 1.32 kW, however, in order to achieve this value, it is necessary to follow the instructions. Asik-miner S9 is considered quite economical and this is confirmed by the amount of energy consumed (0.1 J per 1GH / s).</p>

			<p>Experts Bitmain, developing Antminer S9, took into account the wishes of consumers, so the miner is compatible with power supplies, which were equipped with older models of the asics.</p>',
			'active' => 1,
			'price' => '1500.00',
		]);

		$page = App\Model\Base\Page::where('link', 'product/antminer-d3-19-3gh-s')->first();
		App\Model\Shop\Product::create([
			'context_id' => $context->id,
			//'category_id' => $mainCategory->id,
			'vendor_id' => $vendor->id,
			'page_id' => $page->id,
			'product_status_id' => $inStockStatus->id,
			'warranty' => '180 days',
			'title' => 'ANTMINER D3 19.3GH/s',
			'description' => '<p><b>Antminer D3</b> – equipment for mining, developed by specialists BITMAIN. The device was created specifically for the algorithm X11, therefore, it can produce one of the most popular crypto-currencies - DASH. In addition, on such an algorithm, you can get another digital currency, for example, QRK and CANN.</p>

			<p>All the components of the antmayner are reliably fixed. The boards in the case of the equipment are almost end-to-end relative to each other. The minimum distance between them is provided for effective cooling by the fan.</p>

			<p>In general, the Antminer D3 contains the following elements:
			<ul>
				<li>3 boards (on each of them 60 chips X11 are fixed);</li>
				<li>2 fans S9 with two-stroke operation - responsible for creating a uniform air flow.</li>
			</ul></p>

			<p>Antmeiner consumes 1200 watts (110 V), and its efficiency is 93%. It provides 10 connectors (6-pin) and an Ethernet connection. Modification of the power supply of this model MYRIG 1660W (APW3 ++ PSU). The nominal power of the equipment is 1200 W. To obtain it, the Antminer D3 is connected to a 220 V power supply.</p>

			<p>Device configuration is quick and easy. In this case, the D3 antimeter can hold up to 19.3 (depending on the batch) GHz / s at 1186 W, although the ambient temperature should not be above +20 ° C.</p>',
			'active' => 1,
			'price' => '1500.00',
		]);

		$page = App\Model\Base\Page::where('link', 'product/myrig1660')->first();
		App\Model\Shop\Product::create([
			'context_id' => $context->id,
			//'category_id' => $subCategory->id,
			'vendor_id' => $vendor->id,
			'page_id' => $page->id,
			'warranty' => '365 days',
			'product_status_id' => $inStockStatus->id,
			'title' => 'BP MYRIG 12V 1680W',
			'description' => '<p>The MYRIG power supplies provide a maximum power of 1240 watts if it is connected to a 110 volt power supply. To obtain a nominal power of 1680 watts, it must be connected to a 220 V power supply. Before ordering, check the power supply that is standard in your area.</p>

			<p>The MYRIG is supplied with only 10 PCIe slots, so they can not be used with more than one Antminer S9 / T9 / D3 / L3 + scanner.</p>',
			'active' => 1,
			'price' => '170.00',
		]);

		$page = App\Model\Base\Page::where('link', 'product/antrouter-r1')->first();
		App\Model\Shop\Product::create([
			'context_id' => $context->id,
			//'category_id' => $subCategory->id,
			'vendor_id' => $vendor->id,
			'page_id' => $page->id,
			'warranty' => '365 days',
			'product_status_id' => $inStockStatus->id,
			'title' => 'AntRouter R1',
			'description' => '<p>The MYRIG power supplies provide a maximum power of 1240 watts if it is connected to a 110 volt power supply. To obtain a nominal power of 1680 watts, it must be connected to a 220 V power supply. Before ordering, check the power supply that is standard in your area.</p>

			<p>The MYRIG is supplied with only 10 PCIe slots, so they can not be used with more than one Antminer S9 / T9 / D3 / L3 + scanner.</p>',
			'active' => 1,
			'price' => '65.00',
		]);

		$page = App\Model\Base\Page::where('link', 'product/plata-upravlenia-d3-l3')->first();
		App\Model\Shop\Product::create([
			'context_id' => $context->id,
			//'category_id' => $subCategory->id,
			'vendor_id' => $vendor->id,
			'page_id' => $page->id,
			'warranty' => '90 days',
			'product_status_id' => $inStockStatus->id,
			'title' => 'Control board D3 / L3',
			'description' => '',
			'active' => 1,
			'price' => '130.00',
		]);

		$page = App\Model\Base\Page::where('link', 'product/fan_6000rpm')->first();
		App\Model\Shop\Product::create([
			'context_id' => $context->id,
			//'category_id' => $subCategory->id,
			'vendor_id' => $vendor->id,
			'page_id' => $page->id,
			'warranty' => '90 days',
			'product_status_id' => $notAvailableStatus->id,
			'title' => '6000RPM Fan',
			'description' => '<p>Compatible with: <ul>
				<li>Antminer S9 (Fore)</li>
				<li>Antminer T9 (Fore)</li>
				<li>Antminer L3+ (Back)</li>
				<li>Antminer D3 (Fore and Back)</li>
			</ul></p>',
			'active' => 1,
			'price' => '30.00',
		]);

		$page = App\Model\Base\Page::where('link', 'product/beagle-bone-s9-t9-r4')->first();
		App\Model\Shop\Product::create([
			'context_id' => $context->id,
			//'category_id' => $subCategory->id,
			'vendor_id' => $vendor->id,
			'page_id' => $page->id,
			'warranty' => '90 days',
			'product_status_id' => $inStockStatus->id,
			'title' => 'Beagle Bone S9/T9/R4',
			'description' => '<p>Compatible with: <ul>
				<li>Antminer S9</li>
				<li>Antminer T9</li>
				<li>Antminer R4</li>
			</ul></p>',
			'active' => 1,
			'price' => '75.00',
		]);

		$page = App\Model\Base\Page::where('link', 'product/data_18pin')->first();
		App\Model\Shop\Product::create([
			'context_id' => $context->id,
			//'category_id' => $subCategory->id,
			'vendor_id' => $vendor->id,
			'page_id' => $page->id,
			'warranty' => '90 days',
			'product_status_id' => $inStockStatus->id,
			'title' => 'Data 18 pin cable',
			'description' => '<p>Compatible with: <ul>
				<li>Antminer S9 (18cm)</li>
				<li>Antminer S7 (14cm)</li>
				<li>Antminer R4 (28cm)</li>
				<li>Antminer T9 (18cm)</li>
				<li>Antminer L3+ (18cm)</li>
				<li>Antminer D3 (18cm)</li>
			</ul></p>',
			'active' => 1,
			'price' => '4.00',
		]);

		$page = App\Model\Base\Page::where('link', 'product/plata-upravleniya-s5-s7')->first();
		App\Model\Shop\Product::create([
			'context_id' => $context->id,
			//'category_id' => $subCategory->id,
			'vendor_id' => $vendor->id,
			'page_id' => $page->id,
			'warranty' => '90 days',
			'product_status_id' => $inStockStatus->id,
			'title' => 'Control board S5 / S7',
			'description' => '<p>Compatible with: <ul>
				<li>Antminer S5</li>
				<li>Antminer S7</li>
			</ul></p>',
			'active' => 1,
			'price' => '35.00',
		]);

		$page = App\Model\Base\Page::where('link', 'product/plata-upravleniya-s9-t9-r4')->first();
		App\Model\Shop\Product::create([
			'context_id' => $context->id,
			//'category_id' => $subCategory->id,
			'vendor_id' => $vendor->id,
			'page_id' => $page->id,
			'warranty' => '90 days',
			'product_status_id' => $inStockStatus->id,
			'title' => 'Control board S9 / T9 / R4',
			'description' => '<p>Compatible with: <ul>
				<li>Antminer S9</li>
				<li>Antminer R4</li>
				<li>Antminer T9</li>
			</ul></p>',
			'active' => 1,
			'price' => '50.00',
		]);

		$page = App\Model\Base\Page::where('link', 'product/beagle-s5-s7')->first();
		App\Model\Shop\Product::create([
			'context_id' => $context->id,
			//'category_id' => $subCategory->id,
			'vendor_id' => $vendor->id,
			'page_id' => $page->id,
			'warranty' => '90 days',
			'product_status_id' => $notAvailableStatus->id,
			'title' => 'Beagle Bone S5/S7',
			'description' => '<p>Compatible with: <ul>
				<li>Antminer S5</li>
				<li>Antminer S7</li>
			</ul></p>',
			'active' => 1,
			'price' => '60.00',
		]);
	}
}
