<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    /**
     * @OA\Get(
     *     path="/properties",
     *     summary="Get all properties",
     *     tags={"Properties"},
     *     @OA\Response(
     *         response=200,
     *         description="List of properties",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Beautiful House"),
     *                 @OA\Property(property="price", type="number", example=250000),
     *                 @OA\Property(property="location", type="string", example="Mohali")
     *             )
     *         )
     *     )
     * )
     */
    public function index() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = str_replace('/bestpropertiesmohali/index.php/api', '', $path);

        switch ($path) {
            case '/properties':
                if ($method == 'GET') {
                    $this->getAllProperties();
                } elseif ($method == 'POST') {
                    $this->createProperty();
                }
                break;
            case (preg_match('/\/properties\/(\d+)/', $path, $matches) ? true : false):
                $id = $matches[1];
                if ($method == 'GET') {
                    $this->getProperty($id);
                } elseif ($method == 'PUT') {
                    $this->updateProperty($id);
                } elseif ($method == 'DELETE') {
                    $this->deleteProperty($id);
                }
                break;
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Endpoint not found']);
                break;
        }
    }

    public function getAllProperties() {
        $properties = [
            ['id' => 1, 'title' => 'Beautiful House', 'price' => 250000, 'location' => 'Mohali'],
            ['id' => 2, 'title' => 'Modern Apartment', 'price' => 180000, 'location' => 'Chandigarh']
        ];
        echo json_encode($properties);
    }

    /**
     * @OA\Get(
     *     path="/properties/{id}",
     *     summary="Get property by ID",
     *     tags={"Properties"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Property details",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Beautiful House"),
     *             @OA\Property(property="price", type="number", example=250000),
     *             @OA\Property(property="location", type="string", example="Mohali"),
     *             @OA\Property(property="description", type="string", example="A beautiful house with garden")
     *         )
     *     )
     * )
     */
    public function getProperty($id) {
        $property = ['id' => $id, 'title' => 'Beautiful House', 'price' => 250000, 'location' => 'Mohali', 'description' => 'A beautiful house with garden'];
        echo json_encode($property);
    }

    /**
     * @OA\Post(
     *     path="/properties",
     *     summary="Create new property",
     *     tags={"Properties"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "price", "location"},
     *             @OA\Property(property="title", type="string", example="New House"),
     *             @OA\Property(property="price", type="number", example=300000),
     *             @OA\Property(property="location", type="string", example="Mohali"),
     *             @OA\Property(property="description", type="string", example="Description of the property")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Property created successfully"
     *     )
     * )
     */
    public function createProperty() {
        $data = json_decode(file_get_contents('php://input'), true);
        http_response_code(201);
        echo json_encode(['message' => 'Property created', 'id' => 123]);
    }

    /**
     * @OA\Put(
     *     path="/properties/{id}",
     *     summary="Update property",
     *     tags={"Properties"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated House"),
     *             @OA\Property(property="price", type="number", example=350000),
     *             @OA\Property(property="location", type="string", example="Mohali")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Property updated successfully"
     *     )
     * )
     */
    public function updateProperty($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode(['message' => 'Property updated', 'id' => $id]);
    }

    /**
     * @OA\Delete(
     *     path="/properties/{id}",
     *     summary="Delete property",
     *     tags={"Properties"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Property deleted successfully"
     *     )
     * )
     */
    public function deleteProperty($id) {
        echo json_encode(['message' => 'Property deleted', 'id' => $id]);
    }
}