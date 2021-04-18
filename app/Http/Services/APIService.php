<?php

namespace app\Http\Services;

use App\Http\Services\RestClient;

class APIService
{
    /**
     * Add Requested Domain to the Process List
     *  @param string $domain
     * */

    public function onPageSeoRequest($site_url)
    {
        $api_url = config('dataforseo.API_ENDPOINT');
        $username = config('dataforseo.API_USERNAME');
        $password = config('dataforseo.API_PASSWORD');
        $client = new RestClient($api_url, null, $username, $password);
        $post_array = array();
        $post_array[] = array(
            "target" => $site_url,
            "max_crawl_pages" => 10,
        );
        if (count($post_array) > 0) {
            try {
                $result = $client->post('/v3/on_page/task_post', $post_array);
                $client = null;
                // $result = array(
                //     'version' => '0.1.20210304',
                //     'status_code' => 20000,
                //     'status_message' => 'Ok.',
                //     'time' => '0.0951 sec.',
                //     'cost' => 0.00125,
                //     'tasks_count' => 1,
                //     'tasks_error' => 0,
                //     'tasks' => array(
                //         0 => array(
                //             'id' => '04171938-2695-0216-0000-ec0978e66be8',
                //             'status_code' => 20100,
                //             'status_message' => 'Task Created.',
                //             'time' => '0.0051 sec.',
                //             'cost' => 0.00125,
                //             'result_count' => 0,
                //             'path' => array(
                //                 0 => 'v3',
                //                 1 => 'on_page',
                //                 2 => 'task_post',
                //             ),
                //             'data' => array(
                //                 'api' => 'on_page',
                //                 'function' => 'task_post',
                //                 'target' => 'fitnepali.com',
                //                 'max_crawl_pages' => 10,
                //             ),
                //             'result' => null,
                //         ),
                //     ),
                // );

                if ($result['status_code'] == 20000 && isset($result['tasks'][0]['id'])) {

                    $response = array(
                        'status_code' => 200,
                        'message' => "Your task has been added to process list.",
                        'id' => $result['tasks'][0]['id'],
                    );

                } else {
                    $response = array(
                        'status_code' => 401,
                        'message' => "Your task couldnot be added to process list.",
                        'id' => null,
                    );
                }

            } catch (\Exception $e) {
                $response = array(
                    'status_code' => 401,
                    'message' => $e->getMessage(),
                    'id' => null,
                );
            }
        }

        return $response;
    }

    /**
     * Get Requested Domain On Page SEO Details
     * @param string $id returned from onPageSeoRequest
     * */

    public function onPageSeoResponse($requestId)
    {

        $api_url = config('dataforseo.API_ENDPOINT');
        $username = config('dataforseo.API_USERNAME');
        $password = config('dataforseo.API_PASSWORD');

        try {
            $client = new RestClient($api_url, null, $username, $password);
            $result = $client->get('/v3/on_page/summary/' . $requestId);
            $client = null;

            if ($result["status_code"] == 20000 && $result["status_message"] == "Ok.") {
                $tasks = $result["tasks"][0];
                $result = $tasks['result'][0];

                if ($result["crawl_progress"] != "finished") {
                    return array(
                        "status_code" => 202,
                        "message" => "Your website is being analyzed. It might take several minutes.",
                        "state" => $result["crawl_progress"],
                        'id' => $requestId,
                    );
                }

                $ip = $result["domain_info"]["ip"];
                $server = $result["domain_info"]["server"];

                $page_metrics = $result["page_metrics"];
                $links_external = $page_metrics["links_external"];
                $links_internal = $page_metrics["links_internal"];
                $duplicate_title = $page_metrics["duplicate_title"];
                $duplicate_description = $page_metrics["duplicate_description"];
                $duplicate_content = $page_metrics["duplicate_content"];
                $broken_links = $page_metrics["broken_links"];
                $broken_resources = $page_metrics["broken_resources"];
                $onpage_score = $page_metrics["onpage_score"];

                return array(
                    "statistics" => array(
                        "External Links" => $links_external,
                        "Internal Links" => $links_internal,
                        "Duplicate Title" => $duplicate_title,
                        "Duplicate Description" => $duplicate_description,
                        "Duplicate Content" => $duplicate_content,
                        "Broken Links" => $broken_links,
                        "Broken Resources" => $broken_resources,
                        "OnPage Score" => $onpage_score,
                    ),
                    "server_ip" => $ip,
                    "server" => $server,
                    "status_code" => 200,
                    "message" => "Your website analysis has been successfully processed.",
                );
            }

        } catch (\Exception $e) {

            return array(
                "server_ip" => null,
                "server" => null,
                "statistics" => array(),
                "status_code" => 401,
                "message" => $e->getMessage(),
            );
        }

    }

}
