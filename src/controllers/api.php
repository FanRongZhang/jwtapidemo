<?php

/**
 * @SWG\Swagger(
 *     basePath="/",
 *     host="localhost",
 *     schemes={"http"},
 *     produces={"application/json"},
 *     consumes={"application/json"},
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Swagger UI PAGE FOR DEMO - Zhang RongFang",
 *         description="一个简单的SWAGGER UI",
 *         termsOfService="http://swagger.io/terms/",
 *         @SWG\Contact(name="Swagger API Team"),
 *         @SWG\License(name="MIT")
 *     ),
 *     @SWG\Definition(
 *         definition="返回信息",
 *         type="object",
 *         required={"code", "data", "msg"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="data",
 *             type="json"
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *
 *     )
 * )
 */
