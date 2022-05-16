<?php
class Search_model extends CI_Model {

	private $_site_path;

	function __construct() {

		parent::__construct();
		$CI = &get_instance();
		$this -> _site_path = $CI -> config -> item('site_path');
		$this -> load -> database();

	}

	function get_count($type="member",$q=array()){
		$f = array();
		$s = array();
		$tblname = "";
		switch ($type) {
			case 'hotel':
				$f = array("hotel","hotel_en","hotel_ch","descript");
				$tblname = "hotel";
				break;
			case 'restaurant':
				$f = array("restaurant","restaurant_en","restaurant_ch","descript");
				$tblname = "restaurant";
				break;
			case 'sight':
				$f = array("sight","sight_en","sight_ch","descript");
				$tblname = "sight";
				break;
			case 'area':
				$f = array("a_name_tc","a_name_sc","a_name_en","a_name_local","page_desc");
				$tblname = "area_code";
				$this -> db -> where("invisible",0,FALSE);
				break;
			case 'member':
				$f = array("member_name","member_description");
				$tblname = "member_view";
				break;
			case 'article':
				$f = array("subject","content","body");
				$tblname = "article";
				$this -> db -> where("status",'P');
				break;
			default:
				return 0;
		}
		$c = 0;
		$clause=array();
		for($i=0;$i<count($q);$i++){
		    for($j=0;$j<count($f);$j++){
		        $clause[$c] = " (LOCATE(".$this->db->escape($q[$i]).",".$f[$j].")>0) ";
		        $c++;
		    }
		}
		$this -> db -> where("(".implode(" OR ", $clause).")",NULL,FALSE);
		return $this -> db -> count_all_results($tblname);
	}

	function search($type="member",$q=array(),$page= 0,$limit=20){
		$f = array();
		$s = array();
		$tblname = "";
		$cols = "";
		$offset = $page * $limit;
		$site_path = $this -> _site_path;
		$this -> db -> order_by("score","desc");
		switch ($type) {
			case 'hotel':
				$f = array("hotel_ch","hotel","hotel_en","descript");
				$s = array(4,4,4,1);
				$tblname = "hotel";
				$cols = "'hotel' as poi_type,hid as poi_id,hotel_ch as result_subject,image_id,image,descript  as result_summary";
				$this -> db -> order_by("hotfactor","desc");
				break;
			case 'restaurant':
				$f = array("restaurant_ch","restaurant","restaurant_en","descript");
				$s = array(4,4,4,1);
				$tblname = "restaurant";
				$cols = "'restaurant' as poi_type,rid as poi_id,restaurant_ch as result_subject,image_id,image,descript  as result_summary";
				$this -> db -> order_by("hotfactor","desc");
				break;
			case 'sight':
				$f = array("sight_ch","sight","sight_en","descript");
				$s = array(4,4,4,1);
				$tblname = "sight";
				$cols = "'sight' as poi_type,sigid as poi_id,sight_ch as result_subject,image_id,image,descript  as result_summary";
				$this -> db -> order_by("hotfactor","desc");
				break;
			case 'area':
				$f = array("a_name_tc","a_name_sc","a_name_en","a_name_local","page_desc");
				$s = array(5,4,3,2,1);
				$tblname = "area_code";
				$cols = "a_id as area_id , a_name_tc as result_subject,a_path as area_path , page_desc as result_summary,cover";
				$this -> db -> where("invisible",0,FALSE);
				$this -> db -> order_by("area_path","asc");
				break;
			case 'member':
				$f = array("member_name","member_description");
				$s = array(2,1);
				$tblname = "member_view";
				$cols = "member_id,member_name as result_subject,member_description as result_summary,avatar,avatar_ext,facebook_id,pro,member_type";
				$this -> db -> order_by("pro","desc");
				break;
			case 'article':
				$f = array("subject","content","body");
				$s = array(3,2,1);
				$tblname = "article";
				$cols = "ano,subject as result_subject,content as result_summary,image,image_type,image_id,view_cnt";
				$this -> db -> where("status",'P');
				$this -> db -> order_by("view_cnt","desc");
				break;
			default:
				return array();
		}
		$c = 0;
		for($i=0;$i<count($q);$i++){
		    for($j=0;$j<count($f);$j++){
		        $clause[$c] = " (LOCATE(".$this->db->escape($q[$i]).",".$f[$j].")>0) ";
		        $score[$c]  = " IF(LOCATE(".$this->db->escape($q[$i]).", ".$f[$j]."), ".$s[$j].", 0) ";
		        $c++;
		    }
		}
		$cols .= ",(".implode("+",$score).") AS score";
		$this -> db -> from($tblname);
		$this -> db -> select($cols,FALSE);
		$this -> db -> where("(".implode(" OR ", $clause).")",NULL,FALSE);
		$this -> db -> limit($limit,$offset);
		$r = $this -> db -> get() -> result_array();
		foreach ($r as $k => $v) {
			$r[$k]['result_subject'] = $this -> search_content_highlight($r[$k]['result_subject'],$q);
			$r[$k]['result_summary'] = $this -> search_content_highlight($r[$k]['result_summary'],$q);
			switch($type){
				case "member":
					$r[$k]['result_url'] = "/member/" . $v['member_id'];
					$r[$k]['result_image_url'] = handle_member_image_url($v['member_id'], $v['avatar'], 'n', $v['avatar_ext'], $v['facebook_id']);
					break;
				case "area":
					$r[$k]['result_url'] = "/area/" . $v['area_id'];
					$r[$k]['result_image_url'] = build_area_cover_url($v['cover'] , 'm' );
					break;	
				case "hotel":
				case "restaurant":
				case "sight":
					$r[$k]['result_url'] = build_poi_url($site_path, $v['poi_type'], $v['poi_id'], $v['result_subject']);
					$r[$k]['result_image_url'] = build_unit_image_url($v['image_id'], $v['image'], "s");
					break;

				case "article":
					$r[$k]['result_url'] = "/article/" . $v['ano'];
					if($v['image_type']=='I' || $v['image']==''){
						$r[$k]['result_image_url'] = build_unit_image_url($v['image_id'], $v['image'], "s");
					}else{
						$r[$k]['result_image_url'] = $v['image'];
					}
			}
		}

		return $r;
	}

	function search_content_highlight($content , $key_arr=array()) {
        $keys = implode('|', $key_arr);
        $content = preg_replace('/(' . $keys .')/iu', '<strong class="search-highlight">\0</strong>', $content);

        return $content;
    }

	function search_poi($poi_type="sight",$q=array(),$page= 0,$limit=8){
		$poi_type = get_full_type($poi_type);
		$offset = $page * $limit;
		switch ($poi_type) {
			case 'hotel':
				$f = array("hotel_ch","hotel","hotel_en");
				$tblname = "hotel";
				$cols = "'hotel' as poi_type,'H' as poi_short_type,,hid as poi_id,hotel_ch as poi_name, addr";
				$this -> db -> order_by("hotfactor","desc");
				break;
			case 'restaurant':
				$f = array("restaurant_ch","restaurant","restaurant_en");
				$tblname = "restaurant";
				$cols = "'restaurant' as poi_type,'R' as poi_short_type,rid as poi_id,restaurant_ch as poi_name, addr";
				$this -> db -> order_by("hotfactor","desc");
				break;
			case 'sight':
				$f = array("sight_ch","sight","sight_en");
				$tblname = "sight";
				$cols = "'sight' as poi_type,'S' as poi_short_type,sigid as poi_id,sight_ch as poi_name, addr";
				$this -> db -> order_by("hotfactor","desc");
				break;
			default:
				return array();
		}
        $clause = array();
        for($i=0;$i<count($q);$i++){
            $pc = array();
            for($j=0;$j<count($f);$j++){
				$pc[] = " (LOCATE(".$this->db->escape($q[$i]).",".$f[$j].")>0) ";
			}
            $clause[] = "(".implode(" OR ", $pc).")";
		}
		$cols .= ",lat,lng,image,image_id,a.a_id as area_id,a.a_name_tc as area_name,a.a_path as area_path";
		$this -> db -> from($tblname);
		$this -> db -> join("area_code as a","sid=a.a_id");
		$this -> db -> select($cols,FALSE);
        if(count($clause)>0){
            $this -> db -> where("(".implode(" AND ", $clause).")",NULL,FALSE);
        }
		$this -> db -> limit($limit,$offset);
		$r = $this -> db -> get() -> result_array();

        foreach($r as $k=>$v){
            $r[$k]['poi_url'] = site_url($v['poi_type'].'/'.$v['poi_id']);
            $r[$k]['image_url'] = build_unit_image_url($v['image_id'], $v['image'], "n");
            unset($r[$k]['image_id']);
            unset($r[$k]['image']);
        }

		return $r;
	}

	function search_poi_by_id($poi_type="sight",$input_id){
		$tbl = "sight";
		$id = "sigid";
		switch($poi_type){
			case "hotel" : 
				$tbl = "hotel";
				$cols = "'hotel' as poi_type,'H' as poi_short_type,,hid as poi_id,hotel_ch as poi_name, addr";
				$id = "hid";
				break;
			case "restaurant" : 
				$tbl = "restaurant";
				$cols = "'restaurant' as poi_type,'R' as poi_short_type,rid as poi_id,restaurant_ch as poi_name, addr";
				$id = "rid";
				break;
			default : 
				$cols = "'sight' as poi_type,'S' as poi_short_type,sigid as poi_id,sight_ch as poi_name, addr";
				break;
		}
		$this -> db -> from($tbl);
		$this -> db -> select($cols,FALSE);
		$this -> db -> where($id,$input_id);
		$r = $this -> db -> get() -> result_array();
		return $r;
	}
    /* search member name and return title, description , avatar */
    function search_member($q=array(),$page= 0,$limit=6){
        $offset = $page * $limit;
        $this -> db -> order_by("score","desc");
        $c = 0;
        for($i=0;$i<count($q);$i++){
            $clause[$c] = " (LOCATE(".$this->db->escape($q[$i]).",mnick)>0) ";
            $score[$c]  = " IF(LOCATE(".$this->db->escape($q[$i]).", mnick),1, 0) ";
            $c++;
        }
        $cols = "mid,mnick as title,mdesc as description,image ,image_ext,mfbid,(".implode("+",$score).") AS score";
        $this -> db -> from("member as m");
        $this -> db -> select($cols,FALSE);
        $this -> db -> where("mstatus",'Y');
        $this -> db -> where("(".implode(" OR ", $clause).")",NULL,FALSE);
        $this -> db -> limit($limit,$offset);
        $r = $this -> db -> get() -> result_array();

        $sr = array();
        foreach($r as $k=>$v){
            $sr[] = array(
                "mid"=>$v['mid'],
                "title"=>$v['title'],
                "description"=>cut_text_count($v['description'],10),
                "url"=>site_url("member/".$v['mid']),
                "image"=>handle_member_image_url($v['mid'],$v['image'],'s',$v['image_ext'],$v['mfbid'])
            );
        }

        return $sr;
    }

  function log_search($keyword='',$type='index',$mid=0,$page=0){
  	$data=[
  		'search_key'=> $keyword ,
  		'search_type'=> $type ,
  		'mid' => $mid ,
  		'page' => $page
  	];
  	
  	$this->db->insert('search_log',$data);
  }

  function get_recent_search($limit=5,$start=0){
  	$this->db->select('search_key');
  	$this->db->distinct();
  	$this->db->from('search_log');
  	$this->db->order_by('log_time','desc');
  	$this->db->limit($limit,$start);

  	return $this->db->get()->result_array();
  }


  function log_trip_planner_search($keyword, $type, $mid){
	$data=[
		'search_key'=> $keyword ,
		'search_type'=> $type ,
		'mid' => $mid
	];
	
	$this->db->insert('trip_planner_search_log',$data);
  }
}
