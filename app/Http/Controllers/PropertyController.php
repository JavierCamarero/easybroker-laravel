<?php

namespace App\Http\Controllers;

use App\Features\Properties\UseCases\ListAllProperties;
use Illuminate\Http\Request;
use RuntimeException;

class PropertyController extends Controller
{
    private ListAllProperties $listAllProperties;

    public function __construct(ListAllProperties $listAllProperties)
    {
        $this->listAllProperties = $listAllProperties;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $properties = $this->listAllProperties->execute();
            return response()->json([
                'data' => array_map(fn($item) => [
                    'title' => $item->getTitle()
                ], $properties)
            ]);
        } catch (RuntimeException $e) {
            return response()->json([
                'error' => 'Failed to load properties',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
