<?php
require_once 'vendor/autoload.php';

use OpenApi\Generator;

if (isset($_GET['json'])) {
    header('Content-Type: application/json');
    try {
        $openapi = Generator::scan(['application/controllers']);
        echo $openapi->toJson();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to generate OpenAPI spec: ' . $e->getMessage()]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Swagger UI</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.15.5/swagger-ui.min.css" rel="stylesheet" />
</head>
<body>
<div id="swagger-ui"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.15.5/swagger-ui-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.15.5/swagger-ui-standalone-preset.min.js"></script>
<script>
    window.onload = function() {
        SwaggerUIBundle({
            url: "http://localhost/bestpropertiesmohali/swagger.php?json=1",
            dom_id: '#swagger-ui',
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            layout: "StandaloneLayout"
        });
    };
</script>
</body>
</html>
