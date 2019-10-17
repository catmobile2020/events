<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @SWG\Swagger(
 * 		basePath="/api",
 * 		@SWG\Info(
 * 			title="Events System API",
 * 			version="2.0.0"
 * 		),
 * 		@SWG\SecurityScheme(
 * 			securityDefinition="jwt",
 * 			description="Value: Bearer \<token\><br><br>",
 * 			type="apiKey",
 * 			name="Authorization",
 * 			in="header",
 * 		),
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
