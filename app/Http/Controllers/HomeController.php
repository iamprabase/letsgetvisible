<?php

namespace App\Http\Controllers;

use App\Http\Services\APIService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function reviews()
    {
        return view('reviews');
    }

    public function competitorsdomain()
    {
        return view('competitorsdomain');
    }

    public function getKeyWordReview(Request $request)
    {
        if (!$request->has('id')) {
            $this->validate($request, [
                'keywords' => 'required',
            ]);
            $addToProcessList = (new APIService())->keywordProcess($request->keywords, $request->location);
            if ($addToProcessList['status_code'] == 200) {
                $requestaddToProcessList = (new APIService())->keywordsResponse($addToProcessList['id']);
            } else {
                $requestaddToProcessList = $addToProcessList;
            }
        } else {
            $requestaddToProcessList = (new APIService())->keywordsResponse($request->id);
        }
        return response()->json($requestaddToProcessList);
    }

    public function fullPageStatistics(Request $request)
    {
        $requestSEOPageSummary = (new APIService())->fullOnPageSummary($request->id);

        $details = array();
        $details['Page'] = $requestSEOPageSummary['page'];
        $meta = array();
        $meta['Title'] = $requestSEOPageSummary['meta']['title'];
        $meta['Charset'] = $requestSEOPageSummary['meta']['charset'];
        $meta['Keywords'] = $requestSEOPageSummary['meta']['meta_keywords'];
        $meta['Title Length'] = $requestSEOPageSummary['meta']['title_length'];
        $meta['Description'] = $requestSEOPageSummary['meta']['description'];
        $meta['Description Length'] = $requestSEOPageSummary['meta']['description_length'];
        $details['Meta'] = $meta;
        $htags = $requestSEOPageSummary['meta']['htags'];
        $details['Htags'] = $htags;
        $pagetiming = array();
        $pagetiming['Time To Interact'] = $requestSEOPageSummary['page_timing']['time_to_interactive'] . ' ms';
        $pagetiming['DOM Completion'] = $requestSEOPageSummary['page_timing']['dom_complete'] . ' ms';
        $pagetiming['Waiting Time'] = $requestSEOPageSummary['page_timing']['waiting_time'] . ' ms';
        $pagetiming['Download Time'] = $requestSEOPageSummary['page_timing']['download_time'] . ' ms';
        $details['Page Timing'] = $pagetiming;
        $data = [
            "id" => $request->id,
            "details" => $details,
            "status" => 200,
        ];

        try {
            return response()->json($data, 200);
        } catch (\Exception $e) {
            $data = [
                "id" => $request->id,
                "details" => array(),
                "status" => 400,
                "message" => $e->getMessage(),
            ];
            return response()->json($data, 400);
        }
        return view('onpagedetailreport')->with($data);
    }

    public function getCompetitorsdomain(Request $request)
    {

        $requestaddToProcessList = (new APIService())->competitorDomain($request->domain, $request->location);
        return response()->json($requestaddToProcessList);
    }
}
