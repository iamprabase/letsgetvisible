<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // $curl = curl_init();

    // curl_setopt_array($curl, [
    //     CURLOPT_URL => "https://google-search1.p.rapidapi.com/google-search??q=Avengers%2BEndgame&gl=us&hl=en&ei=E3lsYJHnEauz5NoP84q30AY&start=10&sa=N&ved=2ahUKEwjRvNrT8unvAhWrGVkFHXPFDWoQ8tMDegQIARA1",
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_ENCODING => "",
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 30,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => "GET",
    //     CURLOPT_HTTPHEADER => [
    //         "x-rapidapi-host: google-search1.p.rapidapi.com",
    //         "x-rapidapi-key: 66d0b3a8a3msh771044803afe7f2p161432jsnc1b0fd1b6f85",
    //     ],
    // ]);

    // $response = curl_exec($curl);
    // $err = curl_error($curl);

    // curl_close($curl);

    // if ($err) {
    //     echo "cURL Error #:" . $err;
    // } else {
    //     echo $response;
    // }

    // You can download this file from here https://cdn.dataforseo.com/v3/examples/php/php_RestClient.zip

//         $api_url = 'https://api.dataforseo.com/';
    // // Instead of 'login' and 'password' use your credentials from https://app.dataforseo.com/api-dashboard

//         try {
    //             //Instead of 'login' and 'password' use your credentials from https://my.dataforseo.com/#api_dashboard
    //             $client = new RestClient($api_url, null, 'prabesh.deltatech@gmail.com', '3b6da40dfde55758');
    //             $loc_get_result = $client->get('v2/cmn_locations');
    //             print_r($loc_get_result);
    //             //do something with locations
    //         } catch (\Exception $e) {
    //             echo "\n";
    //             print "HTTP code: {$e->getHttpCode()}\n";
    //             print "Error code: {$e->getCode()}\n";
    //             print "Message: {$e->getMessage()}\n";
    //             print $e->getTraceAsString();
    //             echo "\n";
    //             exit();
    //         }
    //         $client = null;
    //         die;

//         $post_array = array();
    // // simple way to set a task
    //         $post_array[] = array(
    //             "target" => "thulo.com",
    //             "language_name" => "English",
    //             "location_code" => 2840,
    //             "filters" => [
    //                 [
    //                     ["metrics.organic.count", ">=", 50],
    //                     "and",
    //                     ["metrics.organic.pos_1", "in", [1, 2, 3]],
    //                 ],
    //                 "or",
    //                 ["metrics.organic.etv", ">=", 100],
    //             ],
    //         );
    //         try {
    //             // POST /v3/dataforseo_labs/competitors_domain/live
    //             $result = $client->post('/v3/dataforseo_labs/competitors_domain/live', $post_array);
    //             dump($result);
    //             // do something with post result
    //         } catch (\Exception $e) {
    //             echo "\n";
    //             print "HTTP code: {$e->getHttpCode()}\n";
    //             print "Error code: {$e->getCode()}\n";
    //             print "Message: {$e->getMessage()}\n";
    //             print $e->getTraceAsString();
    //             echo "\n";
    //         }
    //         $client = null;
}
