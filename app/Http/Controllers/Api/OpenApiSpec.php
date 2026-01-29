<?php

namespace App\Http\Controllers\Api;

use OpenApi\Attributes as OA;

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
 *      bearerFormat="JWT",
 *      description="Enter token in format: Bearer {token}"
 * )
 *
 * @OA\Tag(
 *      name="Products",
 *      description="API Endpoints for Product Management"
 * )
 *
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
 *      @OA\Property(property="name", type="string", example="Laptop", description="Product name"),
 *      @OA\Property(property="category_id", type="integer", example=1, description="Category ID"),
 *      @OA\Property(property="description", type="string", example="High-performance laptop", description="Product description"),
 *      @OA\Property(property="price", type="number", format="float", example=999.99, description="Product price"),
 *      @OA\Property(property="stock", type="integer", example=50, description="Stock quantity"),
 *      @OA\Property(property="enabled", type="boolean", example=true, description="Product status")
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
 *
 * @OA\Schema(
 *      schema="Category",
 *      type="object",
 *      @OA\Property(property="id", type="integer", example=1),
 *      @OA\Property(property="name", type="string", example="Electronics")
 * )
 */
class OpenApiSpec
{
    // This class is only used for OpenAPI documentation annotations
}
