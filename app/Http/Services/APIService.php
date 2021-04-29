<?php

namespace app\Http\Services;

use App\Http\Services\RestClient;
use Illuminate\Support\Facades\Log;

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
                // $result = $client->post('/v3/on_page/task_post', $post_array);
                // Log::info("Initial Request ", $result);
                $result = array(
                    'version' => '0.1.20210304',
                    'status_code' => 20000,
                    'status_message' => 'Ok.',
                    'time' => '0.1243 sec.',
                    'cost' => 0.00125,
                    'tasks_count' => 1,
                    'tasks_error' => 0,
                    'tasks' => array(
                        0 => array(
                            'id' => '04250550-2695-0216-0000-e8e7f5423927',
                            'status_code' => 20100,
                            'status_message' => 'Task Created.',
                            'time' => '0.0047 sec.',
                            'cost' => 0.00125,
                            'result_count' => 0,
                            'path' => array(
                                0 => 'v3',
                                1 => 'on_page',
                                2 => 'task_post',
                            ),
                            'data' => array(
                                'api' => 'on_page',
                                'function' => 'task_post',
                                'target' => 'https://www.nepaltour.info/',
                                'max_crawl_pages' => 10,
                            ),
                            'result' => null,
                        ),
                    ),
                );
                $client = null;
                if ($result['status_code'] == 20000) {
                    if ($result['tasks'][0]['status_code'] == 40501) {
                        $response = array(
                            'status_code' => 401,
                            'message' => $result['tasks'][0]['status_message'],
                            'id' => null,
                        );
                    } elseif ($result['tasks'][0]['status_code'] == 20100) {
                        $response = array(
                            'status_code' => 200,
                            'message' => "Your task has been added to process list.",
                            'id' => $result['tasks'][0]['id'],
                        );

                    } else {
                        $response = array(
                            'status_code' => 401,
                            'message' => $result['tasks'][0]['status_message'],
                            'id' => null,
                        );
                    }

                } else {
                    $response = array(
                        'status_code' => 401,
                        'message' => $result['status_message'],
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

            if ($result["status_code"] == 20000 && $result["status_message"] == "Ok.") {
                $tasks = $result["tasks"][0];
                $summary = $tasks['result'][0];

                if ($summary["crawl_progress"] != "finished") {
                    return array(
                        "status_code" => 202,
                        "message" => "Your website is being analyzed. It might take several minutes.",
                        "state" => $summary["crawl_progress"],
                        'id' => $requestId,
                    );
                }

                $ip = $summary["domain_info"]["ip"];
                $server = $summary["domain_info"]["server"];

                $page_metrics = $summary["page_metrics"];
                $links_external = $page_metrics["links_external"];
                $links_internal = $page_metrics["links_internal"];
                $duplicate_title = $page_metrics["duplicate_title"];
                $duplicate_description = $page_metrics["duplicate_description"];
                $duplicate_content = $page_metrics["duplicate_content"];
                $broken_links = $page_metrics["broken_links"];
                $broken_resources = $page_metrics["broken_resources"];
                $onpage_score = $page_metrics["onpage_score"];

                $stats = array(
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
                    "id" => $requestId,
                );
                if (auth()->user()) {
                    $checks = $page_metrics["checks"];
                    $duplicate_meta_tags = $checks["duplicate_meta_tags"];
                    $irrelevant_meta_keywords = $checks["irrelevant_meta_keywords"];
                    $irrelevant_description = $checks["irrelevant_description"];
                    $seo_friendly_url = $checks["seo_friendly_url"];
                    $seo_friendly_url_characters_check = $checks["seo_friendly_url_characters_check"];

                    $high_waiting_time = $checks["high_waiting_time"];
                    $high_loading_time = $checks["high_loading_time"];
                    $low_readability_rate = $checks["low_readability_rate"];
                    $duplicate_title_tag = $checks["duplicate_title_tag"];
                    $deprecated_html_tags = $checks["deprecated_html_tags"];
                    $no_h1_tag = $checks["no_h1_tag"];

                    $stats["extra_stats"] = array(
                        "Pages with Duplicate Meta tags" => $duplicate_meta_tags,
                        "Pages with Irrelevant Meta Keywords" => $irrelevant_meta_keywords,
                        "Pages with Irrelevant Description" => $irrelevant_description,
                        "Pages with Deprecated HTML" => $deprecated_html_tags,
                        "Pages with Duplicate Title Tags" => $duplicate_title_tag,
                        "Pages with No H1 Tags" => $no_h1_tag,
                        "Pages with Seo Friendly URL" => $seo_friendly_url,
                        "Number of pages with good URL patterns" => $seo_friendly_url_characters_check,
                        "Pages with waiting time of 1.5 s" => $high_waiting_time,
                        "Pages with waiting time of 3 s" => $high_loading_time,
                        "Pages scoring <15 in Flesch–Kincaid readability test" => $low_readability_rate,
                    );
                }

                $client = null;
                return $stats;
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

    /**
     * Get Full Page Summary
     * @param string $id returned from onPageSeoRequest
     * */

    public function fullOnPageSummary($requestId)
    {

        $api_url = config('dataforseo.API_ENDPOINT');
        $username = config('dataforseo.API_USERNAME');
        $password = config('dataforseo.API_PASSWORD');

        try {
            $client = new RestClient($api_url, null, $username, $password);
            $post_array[] = array(
                "id" => $requestId,
                "limit" => 1,
            );
            $page_summary = $client->post('/v3/on_page/pages', $post_array);
            if ($page_summary['tasks'][0]['status_code'] == 20000 && $page_summary['tasks'][0]['status_message'] == 'Ok.') {
                $result = $page_summary['tasks'][0]['result'][0]['items'][0];
                $data = array();
                $data['page'] = $result['url'];
                $data['meta'] = $result['meta'];
                $data['page_timing'] = $result['page_timing'];

                return $data;
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

    /**
     * Get Keywords Summary
     * @param string $id returned from onPageSeoRequest
     * */

    public function keywordProcess($keywords, $location)
    {

        $api_url = config('dataforseo.API_ENDPOINT');
        $username = config('dataforseo.API_USERNAME');
        $password = config('dataforseo.API_PASSWORD');

        try {
            $client = new RestClient($api_url, null, $username, $password);
            $post_array = array();
            $post_array[] = array(
                "location_name" => $location,
                "language_name" => "English",
                "keyword" => mb_convert_encoding($keywords, "UTF-8"),
            );
            // $keywords_review = $client->post('/v3/business_data/google/my_business_info/task_post', $post_array);
            $keywords_review = array(
                'version' => '0.1.20210304',
                'status_code' => 20000,
                'status_message' => 'Ok.',
                'time' => '0.2139 sec.',
                'cost' => 0.0015,
                'tasks_count' => 1,
                'tasks_error' => 0,
                'tasks' => array(
                    0 => array(
                        'id' => '04290927-2695-0242-0000-61eff95cd3bc',
                        'status_code' => 20100,
                        'status_message' => 'Task Created.',
                        'time' => '0.0087 sec.',
                        'cost' => 0.0015,
                        'result_count' => 0,
                        'path' => array(
                            0 => 'v3',
                            1 => 'business_data',
                            2 => 'google',
                            3 => 'my_business_info',
                            4 => 'task_post',
                        ),
                        'data' => array(
                            'api' => 'business_data',
                            'function' => 'my_business_info',
                            'se' => 'google',
                            'location_name' => 'New York,New York,United States',
                            'language_name' => 'English',
                            'keyword' => 'RustyBrick, Inc.',
                            'se_type' => 'business_info',
                            'device' => 'desktop',
                            'os' => 'windows',
                        ),
                        'result' => null,
                    ),
                ),
            );
            if ($keywords_review['status_code'] == 20000) {
                if ($keywords_review['tasks'][0]['status_code'] == 40501) {
                    $response = array(
                        'status_code' => 401,
                        'message' => $keywords_review['tasks'][0]['status_message'],
                        'id' => null,
                    );
                } elseif ($keywords_review['tasks'][0]['status_code'] == 20100) {
                    $response = array(
                        'status_code' => 200,
                        'message' => "Your task has been added to process list.",
                        'id' => $keywords_review['tasks'][0]['id'],
                    );

                } else {
                    $response = array(
                        'status_code' => 401,
                        'message' => $keywords_review['tasks'][0]['status_message'],
                        'id' => null,
                    );
                }

            } else {
                $response = array(
                    'status_code' => 401,
                    'message' => $keywords_review['status_message'],
                    'id' => null,
                );
            }

        } catch (\Exception $e) {
            $response = array(
                'status_code' => 401,
                'message' => $e->getMessage(),
                // 'id' => $result['tasks'][0]['id'],
            );

        }

        return $response;
    }

    /**
     * Get Requested Keyword Domain
     * @param string $id returned from onPageSeoRequest
     * */

    public function keywordsResponse($requestId)
    {

        $api_url = config('dataforseo.API_ENDPOINT');
        $username = config('dataforseo.API_USERNAME');
        $password = config('dataforseo.API_PASSWORD');

        try {
            $client = new RestClient($api_url, null, $username, $password);
            $result = $client->get('/v3/business_data/google/my_business_info/task_get/' . $requestId);
            Log::info($result);

            if ($result["status_code"] == 20000 && $result["status_message"] == "Ok.") {
                if ($result["tasks"][0]["status_code"] == 40602 && $result["tasks"][0]["status_message"] == "Task In Queue.") {
                    $response = array(
                        'status_code' => 202,
                        'message' => $result['tasks'][0]['status_message'],
                        'id' => $requestId,
                    );
                } elseif ($result["tasks"][0]["status_code"] == 20000 && $result["tasks"][0]["status_message"] == "Ok.") {
                    $business_details = $result["tasks"][0]['result'][0]['items'][0];
                    $title = $business_details['title'];
                    $address = $business_details['address'];
                    $description = $business_details['description'];
                    $category = $business_details['category'];
                    $rating = $business_details['rating'];

                    $response = array(
                        'status_code' => 200,
                        'message' => $result['tasks'][0]['status_message'],
                        'id' => $requestId,
                        'data' => array("Title" => $title, 'Description' => $description, "Address" => $address, 'Category' => $category, "Rating" => $rating),
                    );
                }
            } else {
                $response = array(
                    'status_code' => 202,
                    'message' => $result['tasks'][0]['status_message'],
                    'id' => $requestId,
                );
            }

            return $response;

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

    /**
     * Get Competitors Domain
     *  @param string $domain
     * */

    public function competitorDomain($domain, $location)
    {
        $api_url = config('dataforseo.API_ENDPOINT');
        $username = config('dataforseo.API_USERNAME');
        $password = config('dataforseo.API_PASSWORD');
        $client = new RestClient($api_url, null, $username, $password);
        $post_array = array();
        $post_array[] = array(
            "target" => $domain,
            "language_name" => "English",
            "location_code" => 2840,
        );
        if (count($post_array) > 0) {
            try {
                // $result = $client->post('/v3/dataforseo_labs/competitors_domain/live', $post_array);
                $result = array(
                    'version' => '0.1.20210304',
                    'status_code' => 20000,
                    'status_message' => 'Ok.',
                    'time' => '1.0325 sec.',
                    'cost' => 0.02,
                    'tasks_count' => 1,
                    'tasks_error' => 0,
                    'tasks' => array(
                        0 => array(
                            'id' => '04291124-2695-0131-0000-f855081eceac',
                            'status_code' => 20000,
                            'status_message' => 'Ok.',
                            'time' => '0.9518 sec.',
                            'cost' => 0.02,
                            'result_count' => 1,
                            'path' => array(
                                0 => 'v3',
                                1 => 'dataforseo_labs',
                                2 => 'competitors_domain',
                                3 => 'live',
                            ),
                            'data' => array(
                                'api' => 'dataforseo_labs',
                                'function' => 'competitors_domain',
                                'target' => 'dataforseo.com',
                                'language_name' => 'English',
                                'location_code' => 2840,
                            ),
                            'result' => array(
                                0 => array(
                                    'target' => 'dataforseo.com',
                                    'location_code' => 2840,
                                    'language_code' => 'en',
                                    'total_count' => 27654,
                                    'items_count' => 100,
                                    'items' => array(
                                        0 => array(
                                            'domain' => 'dataforseo.com',
                                            'avg_position' => 49.777010360138135,
                                            'sum_position' => 100898,
                                            'intersections' => 2027,
                                        ),
                                        1 => array(
                                            'domain' => 'google.com',
                                            'avg_position' => 21.502567027952082,
                                            'sum_position' => 37694,
                                            'intersections' => 1753,
                                        ),
                                        2 => array(
                                            'domain' => 'moz.com',
                                            'avg_position' => 28.23065250379363,
                                            'sum_position' => 37208,
                                            'intersections' => 1318,
                                        ),
                                        3 => array(
                                            'domain' => 'medium.com',
                                            'avg_position' => 33.96514522821577,
                                            'sum_position' => 40928,
                                            'intersections' => 1205,
                                        ),
                                        4 => array(
                                            'domain' => 'semrush.com',
                                            'avg_position' => 29.924126172208013,
                                            'sum_position' => 35101,
                                            'intersections' => 1173,
                                        ),
                                        5 => array(
                                            'domain' => 'ahrefs.com',
                                            'avg_position' => 17.882716049382715,
                                            'sum_position' => 20279,
                                            'intersections' => 1134,
                                        ),
                                        6 => array(
                                            'domain' => 'wikipedia.org',
                                            'avg_position' => 39.64127546501329,
                                            'sum_position' => 44755,
                                            'intersections' => 1129,
                                        ),
                                        7 => array(
                                            'domain' => 'searchenginejournal.com',
                                            'avg_position' => 39.111317254174395,
                                            'sum_position' => 42162,
                                            'intersections' => 1078,
                                        ),
                                        8 => array(
                                            'domain' => 'neilpatel.com',
                                            'avg_position' => 35.49008498583569,
                                            'sum_position' => 37584,
                                            'intersections' => 1059,
                                        ),
                                        9 => array(
                                            'domain' => 'quora.com',
                                            'avg_position' => 32.74242424242424,
                                            'sum_position' => 30254,
                                            'intersections' => 924,
                                        ),
                                        10 => array(
                                            'domain' => 'stackoverflow.com',
                                            'avg_position' => 35.67511013215859,
                                            'sum_position' => 32393,
                                            'intersections' => 908,
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                );
                Log::info(["Initial Request ", $result]);
                $data = array();
                if ($result['status_code'] == 20000 && $result['status_message'] == "Ok.") {
                    if (!empty($result['tasks'][0]['result'])) {
                        $domains = $result['tasks'][0]['result'][0]['items'];
                        foreach ($domains as $domain) {
                            array_push($data, $domain['domain']);
                        }
                    }
                }

                $response = array(
                    'status_code' => 200,
                    'message' => "Success",
                    'data' => $data,
                );
            } catch (\Exception $e) {
                $response = array(
                    'status_code' => 401,
                    'message' => $e->getMessage(),
                );
            }
        }

        return $response;
    }

}
