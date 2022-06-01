<?php

namespace App\Http\Controllers;
use App\Models\PostalcodeElectricity;
use Auth;

use Session;
use App\Models\Netcostgs;
use Carbon\Carbon;
use App\Models\DynamicElectricResidential;
use App\Models\Supplier;

use Illuminate\Http\Request;
use App\Models\StaticPackProfessional;

class TestController extends Controller
{
    function generateRandomString($length = 36) {
        $characters = '0123456789-abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function index(){


       Supplier::truncate();
        Session::put('offset', '0');
        while (Session::get('offset') != 'stop') {
            try {
                $client = new \GuzzleHttp\Client();
                $query['pageSize'] = 100;
                $query['offset'] = Session::get('offset');
                $request = $client->get('https://api.airtable.com/v0/app6bZwM5E2SSnySJ/Suppliers', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json',
                        'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                    ],
                    'query' => $query
                ]);
            } catch (Exception $e) {
                return $e->getCode();
            }
            $response = $request->getBody()->getContents();
            $json = json_decode($response, true);
            if (isset($json['offset'])) {
                Session::put('offset', $json['offset']);
            } else {

                Session::put('offset', 'stop');
            }
            
            foreach ($json['records'] as $supplier) {

                if (!empty($supplier['fields']['Commercial Name'])) {
                    if (isset($supplier['id'])) {
                        $recordId = $supplier['id'];
                    } else {
                        $recordId = NULL;
                    }
                    if (isset($supplier['fields']['Id'])) {
                        $supplierId = $supplier['fields']['Id'];
                    } else {
                        $supplierId = NULL;
                    }
                    // if (isset($supplier['fields']['Supplier Type'])) {
                    //     $supplierType = $supplier['fields']['Supplier Type'];
                    // } else {
                    //     $supplierType = NULL;
                    // }
                    if (isset($supplier['fields']['Origin'])) {
                        $origin = $supplier['fields']['Origin'];
                    } else {
                        $origin = NULL;
                    }
                    if (isset($supplier['fields']['Official Name'])) {
                        $officialName = $supplier['fields']['Official Name'];
                    } else {
                        $officialName = NULL;
                    }
                    if (isset($supplier['fields']['Commercial Name'])) {
                        $commercialName = $supplier['fields']['Commercial Name'];
                    } else {
                        $commercialName = NULL;
                    }
                    // if (isset($supplier['fields']['Abbreviation'])) {
                    //     $abbreviation = $supplier['fields']['Abbreviation'];
                    // } else {
                    //     $abbreviation = NULL;
                    // }
                    // if (isset($supplier['fields']['Parent Company'])) {
                    //     $parentCompany = $supplier['fields']['Parent Company'];
                    // } else {
                    //     $parentCompany = NULL;
                    // }
                    if (isset($supplier['fields']['Logo URL'])) {
                        $logoLarge = $supplier['fields']['Logo URL'];
                    } else {
                        $logoLarge = NULL;
                    }
                    // if (isset($supplier['fields']['Logo Small'])) {
                    //     $logoSmall = $supplier['fields']['Logo Small'];
                    // } else {
                    //     $logoSmall = NULL;
                    // }
                    // if (isset($supplier['fields']['Website'])) {
                    //     $website = $supplier['fields']['Website'];
                    // } else {
                    //     $website = NULL;
                    // }
                    // if (isset($supplier['fields']['Youtube Video'])) {
                    //     $youtubeVideo = $supplier['fields']['Youtube Video'];
                    // } else {
                    //     $youtubeVideo = NULL;
                    // }
                    // if (isset($supplier['fields']['Video Webm'])) {
                    //     $videoWebm = $supplier['fields']['Video Webm'];
                    // } else {
                    //     $videoWebm = NULL;
                    // }
                    // if (isset($supplier['fields']['B2b Customers'])) {
                    //     $b2b = $supplier['fields']['B2b Customers'];
                    //     $b2b = str_replace(",", ".", $b2b);
                    //     $b2b = preg_replace('/\.(?=.*\.)/', '', $b2b);
                    // } else {
                    //     $b2b = NULL;
                    // }
                    // if (isset($supplier['fields']['B2c Customers'])) {
                    //     $b2c = $supplier['fields']['B2c Customers'];
                    //     $b2c = str_replace(",", ".", $b2c);
                    //     $b2c = preg_replace('/\.(?=.*\.)/', '', $b2c);
                    // } else {
                    //     $b2c = NULL;
                    // }
                    if (isset($supplier['fields']['Greenpeace Rating'])) {
                        $greenpeaceRating = $supplier['fields']['Greenpeace Rating'];
                        $greenpeaceRating = str_replace(",", ".", $greenpeaceRating);
                        $greenpeaceRating = preg_replace('/\.(?=.*\.)/', '', $greenpeaceRating);
                    } else {
                        $greenpeaceRating = NULL;
                    }
                    if (isset($supplier['fields']['Vreg Rating'])) {
                        $vregRating = $supplier['fields']['Vreg Rating'];
                        $vregRating = str_replace(",", ".", $vregRating);
                        $vregRating = preg_replace('/\.(?=.*\.)/', '', $vregRating);
                    } else {
                        $vregRating = NULL;
                    }
                    if (isset($supplier['fields']['Customer Rating'])) {
                        $customerRating = $supplier['fields']['Customer Rating'];
                        $customerRating = str_replace(",", ".", $customerRating);
                        $customerRating = preg_replace('/\.(?=.*\.)/', '', $customerRating);
                    } else {
                        $customerRating = NULL;
                    }
                    // if (isset($supplier['fields']['Advice Rating'])) {
                    //     $adviceRating = $supplier['fields']['Advice Rating'];
                    //     $adviceRating = str_replace(",", ".", $adviceRating);
                    //     $adviceRating = preg_replace('/\.(?=.*\.)/', '', $adviceRating);
                    // } else {
                    //     $adviceRating = NULL;
                    // }
                    // if (isset($supplier['fields']['Presentation'])) {
                    //     $presentation = $supplier['fields']['Presentation'];
                    // } else {
                    //     $presentation = NULL;
                    // }
                    // if (isset($supplier['fields']['Mission Vision'])) {
                    //     $missionVision = $supplier['fields']['Mission Vision'];
                    // } else {
                    //     $missionVision = NULL;
                    // }
                    // if (isset($supplier['fields']['Values'])) {
                    //     $values = $supplier['fields']['Values'];
                    // } else {
                    //     $values = NULL;
                    // }
                    // if (isset($supplier['fields']['Services'])) {
                    //     $services = $supplier['fields']['Services'];
                    // } else {
                    //     $services = NULL;
                    // }
                    // if (isset($supplier['fields']['Mission Vision Image'])) {
                    //     $mVisionImage = $supplier['fields']['Mission Vision Image'];
                    // } else {
                    //     $mVisionImage = NULL;
                    // }
                    // if (isset($supplier['fields']['Facebook Page'])) {
                    //     $facebookPage = $supplier['fields']['Facebook Page'];
                    // } else {
                    //     $facebookPage = NULL;
                    // }
                    // if (isset($supplier['fields']['Twitter Name'])) {
                    //     $twitterName = $supplier['fields']['Twitter Name'];
                    // } else {
                    //     $twitterName = NULL;
                    // }
                    // if (isset($supplier['fields']['Location'])) {
                    //     $location = $supplier['fields']['Location'];
                    // } else {
                    //     $location = NULL;
                    // }
                    // if (isset($supplier['fields']['Video Mp4'])) {
                    //     $videoMp4 = $supplier['fields']['Video Mp4'];
                    // } else {
                    //     $videoMp4 = NULL;
                    // }
                    // if (isset($supplier['fields']['Video Ogg'])) {
                    //     $videoOgg = $supplier['fields']['Video Ogg'];
                    // } else {
                    //     $videoOgg = NULL;
                    // }
                    // if (isset($supplier['fields']['Video Flv'])) {
                    //     $videoFlv = $supplier['fields']['Video Flv'];
                    // } else {
                    //     $videoFlv = NULL;
                    // }
                    // if (isset($supplier['fields']['Greenpeace Report'])) {
                    //     $greenpeaceReport = $supplier['fields']['Greenpeace Report'];
                    // } else {
                    //     $greenpeaceReport = NULL;
                    // }
                    // if (isset($supplier['fields']['Greenpeace Report Url'])) {
                    //     $greenpeaceUrl = $supplier['fields']['Greenpeace Report Url'];
                    // } else {
                    //     $greenpeaceUrl = NULL;
                    // }
                    // if (isset($supplier['fields']['Greenpeace Supplier Response'])) {
                    //     $supplierResponse = $supplier['fields']['Greenpeace Supplier Response'];
                    // } else {
                    //     $supplierResponse = NULL;
                    // }
                    // if (isset($supplier['fields']['Greenpeace Production Image'])) {
                    //     $productionImage = $supplier['fields']['Greenpeace Production Image'];
                    // } else {
                    //     $productionImage = NULL;
                    // }
                    // if (isset($supplier['fields']['Greenpeace Investments Image'])) {
                    //     $investmentsImage = $supplier['fields']['Greenpeace Investments Image'];
                    // } else {
                    //     $investmentsImage = NULL;
                    // }
                    // if (isset($supplier['fields']['Greenpeace Report Pdf'])) {
                    //     $reportPdf = $supplier['fields']['Greenpeace Report Pdf'];
                    // } else {
                    //     $reportPdf = NULL;
                    // }
                    // if (isset($supplier['fields']['Tagline'])) {
                    //     $tagline = $supplier['fields']['Tagline'];
                    // } else {
                    //     $tagline = NULL;
                    // }
                    // if (isset($supplier['fields']['Vimeo Url'])) {
                    //     $vimeoUrl = $supplier['fields']['Vimeo Url'];
                    // } else {
                    //     $vimeoUrl = NULL;
                    // }

                    if (isset($supplier['fields']['Is Partner'])) {
                        $isPartner = $supplier['fields']['Is Partner'];
                    } else {
                        $isPartner = NULL;
                    }
                    // if (isset($supplier['fields']['Customer Reviews'])) {
                    //     $customerReview = $supplier['fields']['Customer Reviews'];
                    // } else {
                    //     $customerReview = NULL;
                    // }
                    // if (isset($supplier['fields']['Logo Medium'])) {
                    //     $logoMedium = $supplier['fields']['Logo Medium'];
                    // } else {
                    //     $logoMedium = NULL;
                    // }
                    // if (isset($supplier['fields']['Conversion Value'])) {
                    //     $conversionValue = $supplier['fields']['Conversion Value'];
                    //     $conversionValue = str_replace(",",".",$conversionValue);
                    //     $conversionValue = preg_replace('/\.(?=.*\.)/', '', $conversionValue);
                    // } else {
                    //     $conversionValue = NULL;
                    // }
                    
                    if (isset($supplier['fields']['GSC VL'])) {
                        $gsc_vl = $supplier['fields']['GSC VL'];
                        $gsc_vl = str_replace(",",".",$gsc_vl);
                        $gsc_vl = preg_replace('/\.(?=.*\.)/', '', $gsc_vl);
                    } else {
                        $gsc_vl = NULL;
                    }
                    
                    if (isset($supplier['fields']['WKC VL'])) {
                        $wkc_vl = $supplier['fields']['WKC VL'];
                        $wkc_vl = str_replace(",",".",$wkc_vl);
                        $wkc_vl = preg_replace('/\.(?=.*\.)/', '', $wkc_vl);
                    } else {
                        $wkc_vl = NULL;
                    }
                    
                    if (isset($supplier['fields']['GSC WA'])) {
                        $gsc_wa = $supplier['fields']['GSC WA'];
                        $gsc_wa = str_replace(",",".",$gsc_wa);
                        $gsc_wa = preg_replace('/\.(?=.*\.)/', '', $gsc_wa);
                    } else {
                        $gsc_wa = NULL;
                    }
                    
                    if (isset($supplier['fields']['GSC BR'])) {
                        $gsc_br = $supplier['fields']['GSC BR'];
                        $gsc_br = str_replace(",",".",$gsc_br);
                        $gsc_br = preg_replace('/\.(?=.*\.)/', '', $gsc_br);
                    } else {
                        $gsc_br = NULL;
                    }

                    Supplier::Create(
                       
                        [
                            '_id' => $recordId,
                            'supplier_id' => $supplierId,
                          //  'suppliertype' => $supplierType,
                            'origin' => $origin,
                            'official_name' => $officialName,
                            'commercial_name' => $commercialName,
                            //'abbreviation' => $abbreviation,
                           // 'parent_company' => $parentCompany,
                            'logo_large' => $logoLarge,
                            //'logo_small' => $logoSmall,
                            //'website' => $website,
                            //'youtube_video' => $youtubeVideo,
                           // 'video_webm' => $videoWebm,
                           // 'B2b_customers' => $b2b,
                            //'B2c_customers' => $b2c,
                            'greenpeace_rating' => $greenpeaceRating,
                            'Vreg_rating' => $vregRating,
                            'customer_rating' => $customerRating,
                           // 'advice_rating' => $adviceRating,
                           // 'presentation' => $presentation,
                            //'mission_vision' => $missionVision,
                            //'supplier_values' => $values,
                           // 'services' => $services,
                           // 'mission_vision_image' => $mVisionImage,
                           // 'facebook_page' => $facebookPage,
                           // 'twitter_name' => $twitterName,
                           // 'location' => $location,
                           // 'video_mp4' => $videoMp4,
                           // 'video_ogg' => $videoOgg,
                           // 'video_flv' => $videoFlv,
                           // 'greenpeace_report' => $greenpeaceReport,
                            //'greenpeace_report_url' => $greenpeaceUrl,
                            //'greenpeace_supplier_response' => $supplierResponse,
                            //'greenpeace_production_image' => $productionImage,
                            //'greenpeace_investments_image' => $investmentsImage,
                          //  'greenpeace_report_pdf' => $reportPdf,
                          //  'tagline' => $tagline,
                          //  'vimeo_url' => $vimeoUrl,
                            'is_partner' => $isPartner,
                            //'customer_reviews' => $customerReview,
                           // 'logo_medium' => $logoMedium,
                            //'conversion_value' => $conversionValue,
                            'gsc_vl'=>$gsc_vl,
                            'wkc_vl'=>$wkc_vl,
                            'gsc_wa'=>$gsc_wa,
                            'gsc_br'=>$gsc_br
                        ]);
                }
            }
        }
        

            
    }
}
