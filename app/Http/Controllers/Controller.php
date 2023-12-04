<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Bridge Proxy Service Documentation",
 *      description="L5 Swagger OpenApi description",
 *      @OA\Contact(
 *          email="bbeycanov@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="apiKey",
 *     name="Authorization",
 *     in="header",
 * )
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Production API Server"
 * )
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
