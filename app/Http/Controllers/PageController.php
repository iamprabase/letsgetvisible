<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Services\APIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
            // 'domain' => 'required|regex:/^(http(s)?\/\/:)?(www\.)?[a-zA-Z0-9\-]{3,}(\.[a-z]+(\.[a-z]+)?)$/',
            $this->validate($request, [
                'domain' => 'required',
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

    public function contact(Request $request)
    {
        try {
            Contact::create($request->except('_token'));

            Session::flash('success', 'Successfully Sent');
        } catch (\Exceptin $e) {
            Session::flash('error', $e->getMessage());
        }

        return back();
    }
}
