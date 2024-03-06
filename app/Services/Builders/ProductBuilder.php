<?php

namespace App\Services\Builders;

use App\Models\Product;
use App\Models\RelatedProduct;
use Illuminate\Support\Facades\DB;

class ProductBuilder
{
    protected $data;
    protected $product;
    protected $isCreate;
    protected $oldProduct;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function withProduct()
    {
        $this->isCreate = true;
        $this->product = Product::create($this->data);
        return $this;
    }

    public function withEditProduct($id)
    {
        $this->isCreate = false;
        $this->product = Product::find($id);
        $this->oldProduct = $this->product;
        $this->product->update($this->data);
        return $this;
    }

    public function withImage($image)
    {
        // Set Image in inputs data
        if ($image) {
            $res =  uploadImage($image,  config('path.PRODUCT_PATH'), $this->product->image ?? null);
            $this->product->update(['image' => $res]);
        }
        // dd($this->product);
        return $this;
    }

    public function withLog()
    {
        $type = $this->isCreate ? 'store' : 'update';
        setLogs($type, 'product', $this->product, $this->oldProduct ?? []);
        return $this;
    }



    public function withImages()
    {
        if (!empty($this->data['images'])) {
            foreach ($this->data['images'] as $get) {
                $image = uploadImage($get, config('path.PRODUCT_IMAGES_PATH'), null);
                $this->product->images()->create(['image' => $image]);
            }
        }
        return $this;
    }

    /**
     * Generates and inserts product variations based on the attributes of the current product.
     *
     * @return void
     */
    public function withAttributes()
    {
        $attrs = $this->data['attributes'] ?? [];
        $attrInsertData = [];
        // dd($this->data['attributes']);
        $attrInsertData = collect($this->data['attributes'])
            ->flatMap(function ($attr)  {
                return collect($attr['size'])->map(function ($val) use ($attr ) {
                    return [
                        'product_id' => $this->product->id,
                        'color_id' => $attr['color'] ?? null,
                        'size_id' => $val ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                });
            })->all();

            DB::table('product_variations')->where('product_id', $this->product->id)->delete();
             // insert product attributes
            DB::table('product_variations')->insert($attrInsertData);
            // delete product attributes


        return $this;
    }


    public function build()
    {
        return $this->product;
    }
}
