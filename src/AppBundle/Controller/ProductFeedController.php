<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

error_reporting(E_ALL ^ E_STRICT);
ini_set('memory_limit', '32M');

class ProductFeedController extends Controller
{

    public $result = array();
	public $productPerPage = 10;
	public $without_limit_flag = 0;
	 
    /**
    * @Route("/product")
    */
    public function showAction()
    {
        return $this->render('product/index.html.twig');
    }

    /**                                                                                   
    * @Route("/getdata")
    */
    public function getFeedAction(Request $request)    
    {		
        $page_number = $request->request->get('page_number')?intval($request->request->get('page_number')):1;
        $offset = ($page_number - 1) * $this->productPerPage + 1;
        $page_number = $page_number + 1;	
        if ($request->isXMLHttpRequest()) {         
            $get_url = $request->request->get('feed_url');
            if ($get_url) {	
                $parse_url = parse_url($get_url);
                $parsedQueryString = parse_str($parse_url['query']);
                if (isset($limit) && $limit != "") {	
                    $feed_url = $get_url;
                } else {
                    $feed_url = $get_url."&limit=".$this->productPerPage.",".$offset."";
                    $this->without_limit_flag = 1;
                }		
                $c = curl_init($feed_url);
                curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
                $xmlstr = curl_exec($c);
                curl_close($c);
                $xml_feed_obj = new \SimpleXMLElement ( $xmlstr, LIBXML_NOCDATA );	
                if (count($xml_feed_obj->body) <= 0) {	
                    $this->result["status"] = 1;
                    $this->result["page_number"] = $page_number;
                    $this->result["without_limit_flag"] = $this->without_limit_flag;
                    $this->result["html"] = $this->renderView('product/show.html.twig', array('xml_feeds' => $xml_feed_obj));

                    return new JsonResponse($this->result);
                } else {
                    $this->result["status"] = 0;
                    $this->result["html"] = "Something went wrong!";

                    return new JsonResponse($this->result);
                }
            }	
            else {
                $this->result["status"] = 0;
                $this->result["html"] = "Please enter url";

                return new JsonResponse($this->result);
            }
        }

        return new Response('Something went wrong!', 400);
    }
}
