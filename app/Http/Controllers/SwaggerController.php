<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="HelloCSE API",
 *     version="1.0.0",
 *     description="Documentation de l’API HelloCSE"
 * )
 *
 * @OA\SecurityScheme(
 *          securityScheme="sanctum",
 *          type="http",
 *          scheme="bearer",
 *          bearerFormat="JWT"
 *      )
 */
class SwaggerController extends Controller
{

}
