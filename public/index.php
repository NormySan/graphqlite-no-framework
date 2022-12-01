<?php

include '../vendor/autoload.php';

use App\Resolver\FacilityResolver;
use App\Type\FacilityType;
use GraphQL\GraphQL;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use TheCodingMachine\GraphQLite\SchemaFactory;
use TheCodingMachine\GraphQLite\Context\Context;
use Twig\Environment as Twig;
use Twig\Loader\FilesystemLoader;

header("Access-Control-Allow-Origin: *");

$cache = new ArrayAdapter();
$container = new ContainerBuilder();

$container->set(FacilityResolver::class, new FacilityResolver());
$container->set(FacilityType::class, new FacilityType());

// Render the GraphQL explorer.
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $loader = new FilesystemLoader('../templates');
    $twig = new Twig($loader);

    echo $twig->render('explorer.html.twig');
    exit(200);
}

// Handle a request to the GraphQL API.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $factory = new SchemaFactory(new Psr16Cache($cache), $container);
        $factory->addControllerNamespace('App\\Resolver\\')
            ->addTypeNamespace('App\\Input\\')
            ->addTypeNamespace('App\\Type\\');

        $schema = $factory->createSchema();

        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);
        $query = $input['query'];
        $variableValues = $input['variables'] ?? null;

        $result = GraphQL::executeQuery($schema, $query, null, new Context(), $variableValues);
        $output = $result->toArray();

        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode($output);
        exit();
    } catch (Exception $exception) {
        $error = new \GraphQL\Error\Error($exception->getMessage());

        header('Content-Type: application/json');
        http_response_code(500);

        echo json_encode($error);
        exit();
    }
}