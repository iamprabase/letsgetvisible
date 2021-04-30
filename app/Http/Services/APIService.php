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
                $result = $client->post('/v3/on_page/task_post', $post_array);
                Log::info(array("Initial Request For SEO ON Page ", $result));

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
            Log::info(array("Response For SEO ON Page ", $result));

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
            Log::info(array("Initial Request For Full Page Summary ", $page_summary));
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
            $keywords_review = $client->post('/v3/business_data/google/my_business_info/task_post', $post_array);
            Log::info(array("Initial Request For Keywords Review ", $keywords_review));
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
            Log::info(array("Response For Keywords Review ", $result));

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
                $result = $client->post('/v3/dataforseo_labs/competitors_domain/live', $post_array);
                Log::info(array("Initial Request For Domain Competitors ", $result));
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
