<?php

namespace App\Models;

use App\Traits\Filter\AddPipelineToModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, AddPipelineToModelTrait;

    protected $guarded = ['id'];

    public function discount_price()
    {
        if ($this->category === 'boots' || ($this->sku === '000003' && $this->category === 'boots')) {
            return $this->price - ($this->price * 0.3); // 30% discount
        }

        if ($this->sku === '000003') {
            return $this->price - ($this->price * 0.15); // 15% discount
        }

        return $this->price;
    }

    public function discount_percentage()
    {
        if ($this->price === $this->discount_price()) {
            return null;
        }

        $percentage = (($this->price - $this->discount_price()) / $this->price) * 100;

        return "{$percentage}%";
    }
}
