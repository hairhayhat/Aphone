<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Color;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductFactory extends Factory
{
    // Danh sách sản phẩm Apple
    protected $appleProducts = [
        'iPhone' => [
            '15 Pro Max',
            '15 Pro',
            '15 Plus',
            '15',
            '14 Pro Max',
            '14 Pro',
            '14 Plus',
            '14',
            '13 Pro Max',
            '13 Pro',
            '13 mini',
            '13',
            'SE (3rd gen)'
        ],
        'iPad' => [
            'Pro 12.9"',
            'Pro 11"',
            'Air',
            'Mini',
            '10th gen'
        ],
        'MacBook' => [
            'Air M2 13"',
            'Air M2 15"',
            'Pro M2 14"',
            'Pro M2 16"',
            'Air M1 13"',
            'Pro M1 13"',
        ]
    ];


    // Màu sắc phổ biến
    protected $colors = [
        1,
        2,
        3,
        4,
        5,
        6,
        7,
        8,
        9,
        10,
        11,
        12
    ];

    // Dung lượng lưu trữ
    protected $storages = [
        1,
        2,
        3,
        4
    ];

    public function definition(): array
    {
        // Tạo hoặc lấy các category
        $iphoneCategory = Category::firstOrCreate([
            'name' => 'iPhone',
        ]);

        $ipadCategory = Category::firstOrCreate([
            'name' => 'iPad',
        ]);

        $airpodsCategory = Category::firstOrCreate([
            'name' => 'MacBook',
        ]);

        // Chọn ngẫu nhiên loại sản phẩm
        $productType = $this->faker->randomElement(array_keys($this->appleProducts));
        $model = $this->faker->randomElement($this->appleProducts[$productType]);

        // Xác định category_id
        $categoryId = match ($productType) {
            'iPhone' => $iphoneCategory->id,
            'iPad' => $ipadCategory->id,
            'MacBook' => $airpodsCategory->id,
        };

        return [
            'name' => "Apple {$productType} {$model}",
            'price' => $this->generateBasePrice($productType, $model),
            'category_id' => $categoryId,
            'image' => $this->generateImageUrl($productType, $model),
            'description' => $this->generateDescription($productType, $model),
        ];
    }

    // Tạo variants sau khi tạo product
    public function configure()
    {
        return $this->afterCreating(function ($product) {
            $imagePath = "products/{$product->category->name}.jpg";
            $product->update([
                'image' => $imagePath,
            ]);

            $variantCount = max(1, $this->faker->numberBetween(2, 4));

            for ($i = 1; $i <= $variantCount; $i++) { // sửa vòng lặp để bắt đầu từ 1 và bao gồm $variantCount
                $variantData = [
                    'product_id' => $product->id,
                    'price' => $this->calculateVariantPrice($product->price, $i),
                    'quantity' => $this->faker->numberBetween(5, 100),
                ];

                // Tạo hoặc lấy màu sắc (color)
                $color = Color::firstOrCreate([
                    'id' => $this->faker->randomElement($this->colors)
                ]);
                $variantData['color_id'] = $color->id;

                // Tạo hoặc lấy dung lượng lưu trữ (storage)
                $storage = \App\Models\Storage::firstOrCreate([ // Sửa từ Storage sang mô hình tương ứng
                    'id' => $this->faker->randomElement($this->storages)
                ]);
                $variantData['storage_id'] = $storage->id;

                // Tạo variant
                Variant::create($variantData);
            }
        });
    }




    private function generateBasePrice($productType, $model): int
    {
        $basePrices = [
            'iPhone' => [
                'Pro Max' => 30000000,
                'Pro' => 25000000,
                'Plus' => 22000000,
                'default' => 20000000,
                'SE' => 15000000
            ],
            'iPad' => [
                'Pro' => 25000000,
                'Air' => 18000000,
                'default' => 12000000
            ],
            'MacBook' => [
                'Air M2 13"' => 30000000,
                'Air M2 15"' => 35000000,
                'Pro M2 14"' => 40000000,
                'Pro M2 16"' => 45000000,
                'Air M1 13"' => 25000000,
                'Pro M1 13"' => 35000000,
                'default' => 30000000
            ]
        ];

        $price = $basePrices[$productType]['default'];

        foreach ($basePrices[$productType] as $key => $value) {
            if (str_contains($model, $key)) {
                $price = $value;
                break;
            }
        }

        return $price;
    }


    private function calculateVariantPrice($basePrice, $index): int
    {
        // Giá tăng dần theo variant (dung lượng càng cao giá càng cao)
        return $basePrice + ($index * 2000000);
    }

    private function generateImageUrl($productType, $model): string
    {
        $slug = Str::slug("apple {$productType} {$model}");
        return "https://example.com/images/{$slug}.jpg";
    }

    private function generateDescription($productType, $model): string
    {
        $descriptions = [
            'iPhone' => "iPhone {$model} với thiết kế đẳng cấp, hiệu năng mạnh mẽ và hệ thống camera chuyên nghiệp.",
            'iPad' => "iPad {$model} mang đến trải nghiệm giải trí và làm việc vượt trội trên màn hình lớn.",
            'AirPods' => "AirPods {$model} với chất âm sống động, công nghệ chống ồn chủ động và thiết kế tinh tế."
        ];

        return $descriptions[$productType] ?? "Sản phẩm cao cấp từ Apple với chất lượng và trải nghiệm vượt trội.";
    }
}
