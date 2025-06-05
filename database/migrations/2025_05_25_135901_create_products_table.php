<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Khóa chính (ID)
            $table->string('name'); // Tên sản phẩm
            $table->text('description')->nullable(); // Mô tả sản phẩm (có thể null)
            $table->decimal('price', 10, 2); // Giá sản phẩm (10 chữ số, 2 số thập phân)
            $table->string('image_path')->nullable(); // Đường dẫn đến hình ảnh (có thể null)
            $table->unsignedInteger('sold_count')->default(0); // Số lượng đã bán (mặc định là 0)
            $table->string('category')->nullable(); // Danh mục sản phẩm (có thể null, nếu bạn muốn phân loại sản phẩm)
            $table->timestamps(); // created_at và updated_at
            // Thêm các cột khác tùy theo nhu cầu của bạn
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
