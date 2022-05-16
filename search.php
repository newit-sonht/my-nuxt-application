<?php
class Search extends CI_Controller
{
    const search_history_data = 'search_history_data';
    private $search_history = [];
    /*
	 * Advance Dump
	 * require(APPPATH.'php/kint-master/Kint.class.php');
	 * Kint::dump( $data );
	 */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("search_model");
        require_once(APPPATH . 'php/kint-master/Kint.class.php');
    }

    public function index($keyword = '', $search_type = "index")
    {
        $data['start_time'] = microtime(true);
        //Include session data
        require(APPPATH . 'php/header_user_info.php');

        require_once APPPATH . 'libraries/Mobile_Detect.php';
        $mobile_detect = new Mobile_Detect();
        $is_mobile = $data['is_mobile'] = $mobile_detect->isMobile();

        $data['types'] = $type_arr = array(
            "index" => "地點",
            "sight" => "景點",
            "restaurant" => "餐廳",
            "hotel" => "飯店",
            "article" => "文章遊記",
            "member" => "會員",
            "trip" => "行程"
        );

        $key = $this->input->get("key", true);
        if ($key) {
            if ($keyword == '') {
                redirect("/search/" . $key, "location", 301);
            } else if (in_array($keyword, array_keys($type_arr))) {
                redirect("/search/" . $key . "/" . $keyword, "location", 301);
            }
        }

        $page_num = $this->input->get("page", true);
        if (!$page_num) $page_num = 1;

        $search_key = urldecode($keyword);
        if (!$search_key) $search_key = "";
        $data['is_home'] = $ishome = $search_key == "";
        $data['noresult'] = true;
        if (!array_key_exists($search_type, $type_arr) && $search_type != "index") {
            redirect("/search/" . ($ishome ? "" : $search_key), "location", 301);
            return;
        }
        $data['title'] = ($ishome ? "搜尋" :
            $search_key . ' ' . $data['types'][$search_type] . ' 的搜尋結果');
        $data['page_desc'] = "";
        $data['page_keys'] = '搜尋,' . $search_key;
        $data['key'] = $search_key;
        $data['page_num'] = $page_num;
        $data['page_size'] = $size = 20;
        $data['page_count'] = 1;
        $data['view'] = $search_type;
        $data['active_item'] = 'search';
        $data['css_files'] = [
            "js/swiper4/css/swiper.min.css",
            "css/components/addToTrip.css",
            "css/components/poi_card.css",
            "css/search/search.css"
        ];

        $data['js_files'] = [
            "js/search/search.js"
        ];

        if (!$ishome) {
            $this->load->library("cloudsearch_api");
            $query = $this->cloudsearch_api->convert_search_string($search_key);
            $qstr = $query['string'];

            //TODO: hits > 10,0000 use http://docs.aws.amazon.com/cloudsearch/latest/developerguide/paginating-results.html#deep-paging

            $search_params = array(
                "query" => $qstr,
                "highlight" => json_encode(array(
                    "name_tc" => array("format" => "html"),
                    "description" => array("format" => "html"),
                    "category" => array("format" => "html"),
                    "area_name" => array("format" => "html"),
                    "content" => array("format" => "html")
                )),
                "queryOptions" => json_encode(["fields" => ["name_tc^5", "name_en^5", "name_local^5", "category^3", "area_name^3", "description^1", "content^1"]]),
                'expr' => json_encode([
                    'myrank' => "_score/(_time - update_date)"
                ]),
                'sort' => 'myrank desc',
                "size" => $size,
                "start" => ($page_num - 1) * $size
            );

            if ($search_type == "index") {
                $search_params['filterQuery'] = "(or type:'sight' type:'restaurant' type:'hotel')";
                $search_params['expr'] = json_encode(['myrank' => "(0.1 * hotfactor) + (0.9 * _score)"]);
            } else if (in_array($search_type, ['sight', 'restaurant', 'hotel'])) {
                $search_params['filterQuery'] = "type:'" . $search_type . "'";
                $search_params['expr'] = json_encode(['myrank' => "(0.1 * hotfactor) + (0.9 * _score)"]);
            } else {
                $search_params['filterQuery'] = "type:'" . $search_type . "'";
            }

            $search_result = $this->cloudsearch_api->search($search_params);

            $this->load->model("area_model");

            if ($search_result['status'] != "error") {
                $query_time = $search_result['status']['timems'] / 1000;
                $found = $search_result['hits']['found'];
                $results = array();
                if ($found > 0) {
                    foreach ($search_result['hits']['hit'] as $r) {
                        $type_id_pair = explode("_", $r['id']);
                        $poi_url = site_url($type_id_pair[0] . "/" . $type_id_pair[1]);

                        if ($type_id_pair[0] == 'article') {
                            $hcontent = (isset($r['highlights']['content']) && strlen($r['highlights']['content']) > 0) ? $r['highlights']['content'] : "";
                            $hdesc = (isset($r['highlights']['description']) && strlen($r['highlights']['description']) > 0) ? $r['highlights']['description'] : "";
                            $desc = (isset($r['fields']['description'][0]) && strlen($r['fields']['description'][0]) > 0) ? $r['fields']['description'][0] : "";

                            if (strlen($hcontent) > 0) {
                                $description = $hcontent;
                            } elseif (strlen($hdesc) > 0) {
                                $description = $hdesc;
                            } else {
                                $description = $desc;
                            }
                        } else {
                            $description = (isset($r['highlights']['description']) && $r['highlights']['description'] != "") ? $r['highlights']['description'] : (isset($r['fields']['description']) ? $r['fields']['description'] : "");
                        };

                        $results[] = array(
                            "poi_type" => $type_id_pair[0],
                            "poi_id" => $type_id_pair[1],
                            "poi_url" => $poi_url,
                            "poi_name" => in_array($type_id_pair[0], ['sight', 'restaurant', 'hotel']) ? (isset($r['fields']['name_tc']) ? $r['fields']['name_tc'][0] : "") : str_replace(
                                html_entity_decode(strip_tags($r['highlights']['name_tc'])),
                                $r['highlights']['name_tc'],
                                $r['fields']['name_tc'][0]
                            ),
                            "poi_description" => html_entity_decode($description),
                            "poi_category" => isset($r['fields']['category']) && is_array($r['fields']['category']) ?
                                $r['fields']['category'] : array(),
                            "area_name" => (isset($r['fields']['area_name'][0]) && $r['fields']['area_name'][0] != "") ?
                                $r['fields']['area_name'] : "",
                            "author_name" => isset($r['fields']['owner_name']) ? $r['fields']['owner_name'][0] : "",
                            "author_url" => isset($r['fields']['owner_id']) ? site_url("member/" . $r['fields']['owner_id'][0]) : "",
                            "update_date" => date('Y-m-d H:i:s', strtotime($r['fields']['update_date'][0]))
                        );
                    }

                    if ($search_type == "article" && isset($results)) {
                        $a_ids = array_filter(
                            array_map(function ($value) {
                                if ($value['poi_type'] == "article") {
                                    return (int)$value['poi_id'];
                                }
                            }, $results),
                            function ($v) {
                                return ($v != null);
                            }
                        );

                        $this->load->model('article_model');
                        $data['article_data_arr'] = [];
                        $article_data_arr = $this->article_model->get_by_anos($a_ids);
                        foreach ($article_data_arr as $article) {
                            $data['article_data_arr'][$article['article_id']] = $article;
                        }
                    }
                }

                $data['result'] = array(
                    "query_time" => $query_time,
                    "found" => $found,
                    "results" => $results
                );

                $data['page_count'] = ceil($found / $size);

                // include min planner & poi card
                if (in_array($search_type, ['index', 'sight', 'restaurant', 'hotel'])) {
                    $data['js_files'][] = "js/swiper4/js/swiper.min.js";
                    $data['js_files'][] = "js/vendors/vuejs/2.2.6/vue.min.js";
                    $data['js_files'][] = "js/moment/min/moment.min.js";
                    $data['js_files'][] = "js/datetimepicker/jquery.datetimepicker.js";
                    $data['js_files'][] = "js/components/addToTrip.js";
                    $data['js_files'][] = 'js/sweetalert-cdn/sweetalert2.js';
                    $data['js_files'][] = 'js/components/addPoiToWant.js';
                    $data['js_files'][] = "js/components/poi_card.min.js";
                    $data['css_files'][] = 'css/animate/animate.min.css';
                    $data['MINI_PLANNER'] = true;
                }

                // get mix results data
                if ($search_type == 'index') {
                    // search for area
                    $area_params = array(
                        "query" => $qstr,
                        "filterQuery" => "type:'area'",
                        "queryOptions" => json_encode(["fields" => ["name_tc", "name_en", "name_local"]]),
                        "size" => 1,
                        'return' => '_no_fields'
                    );

                    $area_result = $this->cloudsearch_api->search($area_params);
                    if ($area_result['status'] != 'error' && $area_result['hits']['found'] > 0) {
                        $data['area_result'] = $this->area_model->list_areas(['areas_id' => explode('_', $area_result['hits']['hit'][0]['id'])[1]]);
                    }
                }

                // log the search
                if($data['userid'] > 0) $this->save_history_to_cookies($data['key']);
                $this->search_model->log_search($data['key'], $data['view'], $data['userid']);
            } else {
                $data['result'] = "error";
            }
        }

        // d($data);
        // return;

        if($data['userid'] > 0) $data['search_keys'] = $this->load_history_from_cookies();
        else $data['search_keys'] = $this->search_model->get_recent_search(5);

        $this->layout->loadview_v3("search/search_view_new", $data);
    }

    function search_poi($poi_type = "sight")
    {

        $search_key = $this->input->get('key', true);
        if ($search_key) {
            $search_key = urldecode($search_key);
            $search_key = str_replace('=', '', $search_key);
        }

        $qstring_replace = preg_replace('/ {2,}/', ' ', trim($search_key));
        $qstring = explode(' ', $qstring_replace);
        if ($poi_type == 'all') {
            $pz = $this->input->get('pz', true);
            if (!$pz) $pz = 4;
            $result = array("success" => true, "results" => array());
            $all_type = array(
                array('name' => 'sight', 'label' => '景點'),
                array('name' => 'restaurant', 'label' => '餐廳'),
                array('name' => 'hotel', 'label' => '飯店')
            );
            foreach ($all_type as $type) {
                $r = $this->search_model->search_poi($type['name'], $qstring, 0, $pz);
                if (count($r) > 0) {
                    $result['results'][$type['name']] = array('name' => $type['label'], 'results' => $r);
                }
            }
        } else {
            $result = array("success" => true, "results" => $this->search_model->search_poi($poi_type, $qstring));
        }

        $this->output->set_output(json_encode($result));
    }

    function search_member()
    {
        $search_key = $this->input->get('key', true);
        if ($search_key) {
            $search_key = urldecode($search_key);
            $search_key = str_replace('=', '', $search_key);
        }

        $qstring_replace = preg_replace('/ {2,}/', ' ', trim($search_key));
        $qstring = explode(' ', $qstring_replace);

        $result = array("success" => true, "results" => $this->search_model->search_member($qstring));

        $this->output->set_output(json_encode($result));
    }

    function load_history_from_cookies() {
        $display_history = [];
        foreach($this->search_history as $value) {
            $display_history[]['search_key'] = $value;
        }
        return array_reverse($display_history);
    }

    function save_history_to_cookies($search_key = '',$expire = 2592000) {
        if($search_key != '') {
            $this->load->helper('cookie');
            $search_data = get_cookie(self::search_history_data);
            $this->search_history = explode(",",$search_data);

            if(!in_array($search_key,$this->search_history)){
                if(count($this->search_history) >= 5) $this->search_history = array_slice($this->search_history,1,4);
                $this->search_history[] = $search_key;
            } else { 
                $search_position = array_search($search_key,$this->search_history);
                if($search_position >= 0){
                    $swap = $this->search_history[4];
                    $this->search_history[4] = $this->search_history[$search_position];
                    $this->search_history[$search_position] = $swap;
                }
            }
            
            $search_history_to_string = implode(",",$this->search_history);
            set_cookie(self::search_history_data,$search_history_to_string,$expire);
        }
    }
}
