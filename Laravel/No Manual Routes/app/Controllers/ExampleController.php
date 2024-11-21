<?php 
namespace App\Controllers;

use App\Controllers\Controller;
use App\Attributes\Route;
use App\Attributes\RouteGroup;

#[RouteGroup(prefix: '/admin')]
final class ExampleController extends Controller {
    #[Route(method: 'GET', uri: '/')]
    public function index() {
        return "Protected";
    }

    #[Route(method: 'GET', uri: '/hello')]
    public function hello() {
        return "Hello World";
    }
}