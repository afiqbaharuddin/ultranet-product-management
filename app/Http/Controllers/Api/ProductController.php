<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Ultranet Product Management API",
 *      description="API Documentation for Product Management System",
 *      @OA\Contact(
 *          email="admin@ultranet.com"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="sanctum",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT"
 * )
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/products",
     *      operationId="getProductsList",
     *      tags={"Products"},
     *      summary="Get list of products",
     *      description="Returns list of products with optional filtering by category",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="category_id",
     *          description="Filter by category ID",
     *          required=false,
     *          in="query",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          description="Page number",
     *          required=false,
     *          in="query",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Product"))
     *          )
     *       )
     * )
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Product::with('category');

        // Filter by category if provided
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(15);

        return ProductResource::collection($products);
    }

    /**
     * @OA\Post(
     *      path="/api/products",
     *      operationId="storeProduct",
     *      tags={"Products"},
     *      summary="Create new product",
     *      description="Creates a new product and returns product data",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreProductRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Product created successfully",
     *          @OA\JsonContent(ref="#/components/schemas/Product")
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      )
     * )
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());
        $product->load('category');

        return response()->json([
            'message' => 'Product created successfully',
            'data' => new ProductResource($product)
        ], 201);
    }

    /**
     * @OA\Get(
     *      path="/api/products/{id}",
     *      operationId="getProductById",
     *      tags={"Products"},
     *      summary="Get product information",
     *      description="Returns product data",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Product ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Product")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Product not found"
     *      )
     * )
     */
    public function show(Product $product): JsonResponse
    {
        $product->load('category');

        return response()->json([
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * @OA\Put(
     *      path="/api/products/{id}",
     *      operationId="updateProduct",
     *      tags={"Products"},
     *      summary="Update existing product",
     *      description="Updates a product and returns updated product data",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Product ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateProductRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Product updated successfully",
     *          @OA\JsonContent(ref="#/components/schemas/Product")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Product not found"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      )
     * )
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());
        $product->load('category');

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * @OA\Delete(
     *      path="/api/products/{id}",
     *      operationId="deleteProduct",
     *      tags={"Products"},
     *      summary="Delete product",
     *      description="Soft deletes a product",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Product ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Product deleted successfully"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Product not found"
     *      )
     * )
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }

    /**
     * @OA\Post(
     *      path="/api/products/bulk-delete",
     *      operationId="bulkDeleteProducts",
     *      tags={"Products"},
     *      summary="Bulk delete products",
     *      description="Soft deletes multiple products",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="ids", type="array", @OA\Items(type="integer"), example={1, 2, 3})
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Products deleted successfully"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      )
     * )
     */
    public function bulkDelete(BulkDeleteProductRequest $request): JsonResponse
    {
        $deletedCount = Product::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => "{$deletedCount} product(s) deleted successfully",
            'deleted_count' => $deletedCount
        ]);
    }
}

/**
 * @OA\Schema(
 *      schema="Product",
 *      type="object",
 *      @OA\Property(property="id", type="integer", example=1),
 *      @OA\Property(property="name", type="string", example="Laptop"),
 *      @OA\Property(property="category_id", type="integer", example=1),
 *      @OA\Property(property="category_name", type="string", example="Electronics"),
 *      @OA\Property(property="description", type="string", example="High-performance laptop"),
 *      @OA\Property(property="price", type="number", format="float", example=999.99),
 *      @OA\Property(property="stock", type="integer", example=50),
 *      @OA\Property(property="enabled", type="boolean", example=true),
 *      @OA\Property(property="created_at", type="string", format="date-time"),
 *      @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *      schema="StoreProductRequest",
 *      type="object",
 *      required={"name", "category_id", "price", "stock"},
 *      @OA\Property(property="name", type="string", example="Laptop"),
 *      @OA\Property(property="category_id", type="integer", example=1),
 *      @OA\Property(property="description", type="string", example="High-performance laptop"),
 *      @OA\Property(property="price", type="number", format="float", example=999.99),
 *      @OA\Property(property="stock", type="integer", example=50),
 *      @OA\Property(property="enabled", type="boolean", example=true)
 * )
 *
 * @OA\Schema(
 *      schema="UpdateProductRequest",
 *      type="object",
 *      @OA\Property(property="name", type="string", example="Laptop"),
 *      @OA\Property(property="category_id", type="integer", example=1),
 *      @OA\Property(property="description", type="string", example="High-performance laptop"),
 *      @OA\Property(property="price", type="number", format="float", example=999.99),
 *      @OA\Property(property="stock", type="integer", example=50),
 *      @OA\Property(property="enabled", type="boolean", example=true)
 * )
 */