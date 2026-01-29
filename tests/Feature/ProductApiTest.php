<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create(['name' => 'Electronics']);
    }

    public function test_can_list_products()
    {
        Sanctum::actingAs($this->user);

        Product::factory()->count(3)->create(['category_id' => $this->category->id]);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'name',
                             'category_id',
                             'category_name',
                             'price',
                             'stock',
                             'enabled'
                         ]
                     ]
                 ]);
    }

    public function test_can_filter_products_by_category()
    {
        Sanctum::actingAs($this->user);

        $category2 = Category::factory()->create(['name' => 'Books']);
        
        Product::factory()->count(2)->create(['category_id' => $this->category->id]);
        Product::factory()->count(3)->create(['category_id' => $category2->id]);

        $response = $this->getJson('/api/products?category_id=' . $this->category->id);

        $response->assertStatus(200);
        $this->assertEquals(2, count($response->json('data')));
    }

    public function test_can_create_product()
    {
        Sanctum::actingAs($this->user);

        $productData = [
            'name' => 'Test Product',
            'category_id' => $this->category->id,
            'description' => 'Test Description',
            'price' => 99.99,
            'stock' => 50,
            'enabled' => true
        ];

        $response = $this->postJson('/api/products', $productData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Test Product'])
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         'id',
                         'name',
                         'category_id',
                         'category_name'
                     ]
                 ]);

        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    public function test_create_product_validation_fails()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/products', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'category_id', 'price', 'stock']);
    }

    public function test_can_show_product()
    {
        Sanctum::actingAs($this->user);

        $product = Product::factory()->create(['category_id' => $this->category->id]);

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => $product->name]);
    }

    public function test_can_update_product()
    {
        Sanctum::actingAs($this->user);

        $product = Product::factory()->create(['category_id' => $this->category->id]);

        $updateData = [
            'name' => 'Updated Product',
            'price' => 199.99
        ];

        $response = $this->putJson('/api/products/' . $product->id, $updateData);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Product']);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product'
        ]);
    }

    public function test_can_delete_product()
    {
        Sanctum::actingAs($this->user);

        $product = Product::factory()->create(['category_id' => $this->category->id]);

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Product deleted successfully']);

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    public function test_can_bulk_delete_products()
    {
        Sanctum::actingAs($this->user);

        $products = Product::factory()->count(3)->create(['category_id' => $this->category->id]);
        $ids = $products->pluck('id')->toArray();

        $response = $this->postJson('/api/products/bulk-delete', ['ids' => $ids]);

        $response->assertStatus(200);

        foreach ($ids as $id) {
            $this->assertSoftDeleted('products', ['id' => $id]);
        }
    }

    public function test_requires_authentication()
    {
        $response = $this->getJson('/api/products');
        $response->assertStatus(401);
    }
}