<?php

namespace App\Http\Controllers;

use App\Http\Services\APIService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (!$request->has('id')) {
            $this->validate($request, [
                'domain' => 'required|regex:/^(http(s)?\/\/:)?(www\.)?[a-zA-Z0-9\-]{3,}(\.[a-z]+(\.[a-z]+)?)$/',
            ]);
            $addToProcessList = (new APIService())->onPageSeoRequest($request->domain);
            if ($addToProcessList['status_code'] == 200) {
                $requestSEOScore = (new APIService())->onPageSeoResponse($addToProcessList['id']);
            } else {
                $requestSEOScore = $addToProcessList;
            }
        } else {
            $requestSEOScore = (new APIService())->onPageSeoResponse($request->id);
        }

        return response()->json($requestSEOScore);
    }
}
