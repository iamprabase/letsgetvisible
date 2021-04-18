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

    public function quickReport(Request $request)
    {
        $this->validate($request, [
            'domain' => 'required|regex:/^(http(s)?\/\/:)?(www\.)?[a-zA-Z\-]{3,}(\.[a-z]+(\.[a-z]+)?)$/',
        ]);
        $addToProcessList = (new APIService())->onPageSeoRequest($request->domain);
        if ($addToProcessList['status_code'] == 200) {
            $requestSEOScore = (new APIService())->onPageSeoResponse($addToProcessList['id']);
        } else {
            $requestSEOScore = $addToProcessList;
        }

        return response()->json($requestSEOScore);
    }

    // private function onPageSeoRequest($site_url)
    // {
    //     $api_url = config('dataforseo.API_ENDPOINT');
    //     $username = config('dataforseo.API_USERNAME');
    //     $password = config('dataforseo.API_PASSWORD');
    //     $client = new RestClient($api_url, null, $username, $password);
    //     $post_array = array();
    //     $post_array[] = array(
    //         "target" => $site_url,
    //         "max_crawl_pages" => 10,
    //     );
    //     if (count($post_array) > 0) {
    //         try {
    //             // $result = $client->post('/v3/on_page/task_post', $post_array);
    //             $client = null;
    //             $result = array(
    //                 'version' => '0.1.20210304',
    //                 'status_code' => 20000,
    //                 'status_message' => 'Ok.',
    //                 'time' => '0.0951 sec.',
    //                 'cost' => 0.00125,
    //                 'tasks_count' => 1,
    //                 'tasks_error' => 0,
    //                 'tasks' => array(
    //                     0 => array(
    //                         'id' => '04171938-2695-0216-0000-ec0978e66be8',
    //                         'status_code' => 20100,
    //                         'status_message' => 'Task Created.',
    //                         'time' => '0.0051 sec.',
    //                         'cost' => 0.00125,
    //                         'result_count' => 0,
    //                         'path' => array(
    //                             0 => 'v3',
    //                             1 => 'on_page',
    //                             2 => 'task_post',
    //                         ),
    //                         'data' => array(
    //                             'api' => 'on_page',
    //                             'function' => 'task_post',
    //                             'target' => 'fitnepali.com',
    //                             'max_crawl_pages' => 10,
    //                         ),
    //                         'result' => null,
    //                     ),
    //                 ),
    //             );

    //             if ($result['status_code'] == 20000 && isset($result['tasks'][0]['id'])) {

    //                 $response = $this->onPageSeoResponse($result['tasks'][0]['id']);

    //             } else {
    //                 $response = array(
    //                     'status_code' => 401,
    //                     'message' => "Your task couldnot be added to process list.",
    //                 );
    //             }

    //         } catch (\Exception $e) {
    //             $response = array(
    //                 'status_code' => 401,
    //                 'message' => $e->getMessage(),
    //                 'id' => null,
    //             );
    //         }
    //     }

    //     return $response;
    // }

    // private function onPageSeoResponse($requestId)
    // {

    //     $api_url = config('dataforseo.API_ENDPOINT');
    //     $username = config('dataforseo.API_USERNAME');
    //     $password = config('dataforseo.API_PASSWORD');

    //     try {
    //         $client = new RestClient($api_url, null, $username, $password);
    //         $result = $client->get('/v3/on_page/summary/' . $requestId);

    //         if ($result["status_code"] == 20000 && $result["status_message"] == "Ok.") {
    //             $tasks = $result["tasks"][0];
    //             $result = $tasks['result'][0];
    //             if ($result["crawl_progress"] != "finished") {
    //                 $this->onPageSeoRequest($requestId);
    //             }

    //             $ip = $result["domain_info"]["ip"];
    //             $server = $result["domain_info"]["server"];

    //             $page_metrics = $result["page_metrics"];
    //             $links_external = $page_metrics["links_external"];
    //             $links_internal = $page_metrics["links_internal"];
    //             $duplicate_title = $page_metrics["duplicate_title"];
    //             $duplicate_description = $page_metrics["duplicate_description"];
    //             $duplicate_content = $page_metrics["duplicate_content"];
    //             $broken_links = $page_metrics["broken_links"];
    //             $broken_resources = $page_metrics["broken_resources"];
    //             $onpage_score = $page_metrics["onpage_score"];

    //             return array(
    //                 "statistics" => array(
    //                     "External Links" => $links_external,
    //                     "Internal Links" => $links_internal,
    //                     "Duplicate Title" => $duplicate_title,
    //                     "Duplicate Description" => $duplicate_description,
    //                     "Duplicate Content" => $duplicate_content,
    //                     "Broken Links" => $broken_links,
    //                     "Broken Resources" => $broken_resources,
    //                     "OnPage Score" => $onpage_score,
    //                 ),
    //                 "server_ip" => $ip,
    //                 "server" => $server,
    //                 "status_code" => 200,
    //                 "message" => "Your website analysis has been successfully processed.",
    //             );
    //         }

    //     } catch (\Exception $e) {

    //         return array(
    //             "server_ip" => null,
    //             "server" => null,
    //             "statistics" => array(),
    //             "status_code" => 401,
    //             "message" => $e->getMessage(),
    //         );
    //     }

    // }

    // $client = null;

    // $client = new RestClient($api_url, null, $username, $password);
    // $id = "04171503-2695-0216-0000-3dda2458548e";

    // $post_array = array();
    // // simple way to get a result
    // $post_array[] = array(
    //     "id" => $id,
    // );
    // try {
    //     $result = $client->post('/v3/on_page/pages', $post_array);
    //     dump($result);
    // } catch (\Exception $e) {
    //     echo "\n";
    //     print "HTTP code: {$e->getHttpCode()}\n";
    //     print "Error code: {$e->getCode()}\n";
    //     print "Message: {$e->getMessage()}\n";
    //     print $e->getTraceAsString();
    //     echo "\n";
    // }

    // $client = null;

    // You can download this file from here https://api.dataforseo.com/v3/_examples/php/_php_RestClient.zip
    // require('RestClient.php');
    // $api_url = 'https://api.dataforseo.com/';
    // // Instead of 'login' and 'password' use your credentials from https://app.dataforseo.com/api-dashboard
    // $client = new RestClient($api_url, null, 'login', 'password');
    // try {
    //    $result = array();
    //    // using this method you can get summary for task
    //    // GET /v3/on_page/summary/$id
    //    $id = "07281559-0695-0216-0000-c269be8b7592";
    //    $result[] = $client->get('/v3/on_page/summary/' . $id);
    //    print_r($result);
    //    // do something with result
    // } catch (RestClientException $e) {
    //    echo "\n";
    //    print "HTTP code: {$e->getHttpCode()}\n";
    //    print "Error code: {$e->getCode()}\n";
    //    print "Message: {$e->getMessage()}\n";
    //    print  $e->getTraceAsString();
    //    echo "\n";
    // }
    // $client = null;
}
