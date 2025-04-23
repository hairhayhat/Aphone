<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(2, 3), // Giả định có 50 người dùng
            'product_id' => $this->faker->numberBetween(99, 150),
            'content' => $this->faker->paragraph,
            'rating' => $this->faker->numberBetween(1, 5),
            'status' => 'approved',
        ];
    }

    // State để tạo comment với trạng thái cụ thể
    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'approved',
            ];
        });
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
            ];
        });
    }

    public function rejected()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'rejected',
            ];
        });
    }

    // State để tạo comment với rating cụ thể
    public function withRating(int $rating)
    {
        return $this->state(function (array $attributes) use ($rating) {
            return [
                'rating' => $rating,
            ];
        });
    }
}
