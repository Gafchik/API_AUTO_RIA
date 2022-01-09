<?php

namespace App\Http\Controllers;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class APIController extends Controller
{
    //апи ключ
    private function Get_API_Key(): string
    {return 'sW2t31D6kOBTK39HfBppWUdbORLILTYEqI7x19Ls';}
    //апи запрос  поиска машин
    private function Get_Serch_Car_Request(): string
    {return 'https://developers.ria.com/auto/search?api_key=';}
    //апи запрос поиска типа транспорта
    private function  Get_Type_Request()
    {return 'https://developers.ria.com/auto/categories/?api_key=';}
    //пропы для одной вложености
    private function Get_Prop_Car($where,$propname)
    {
        try {return  $where[$propname];}
        catch (Exception $e){return  'не указано';}
    }
    // пропы для двух вложеностей
    private function Get_Inner_PropCar($where,$propname1,$propname2)
    {
        try {return  $where[$propname1][$propname2];}
        catch (Exception $e){return  'не указано';}
    }
    public function Get_Car(Request $request)
    {
        //строка запроса  с параметрами
        $api_request = self::Get_Serch_Car_Request(). self::Get_API_Key() . '&with_photo=1';


        $type=$request->get('type');
        $api_request= $api_request . '&category_id=' . $type;

        $mark=$model=$region=$year_begin=$year_and='';

        if($request->get('mark')!=''){
            $mark =$request->get('mark');
            // $api_request=$api_request.'&marka_id['.$type.']='.$mark;
            //$api_request=$api_request.'&marka_id[0]='.$mark;
            $api_request=$api_request.'&marka_id='.$mark;
        }

        if($request->get('model')!=''){
            $model =$request->get('model');
            //$api_request=$api_request.'&model_id['.$mark.']='.$model;
           // $api_request=$api_request.'&brandOrigin[0]=0&model_id[0]='.$model;
            $api_request=$api_request.'&model_id='.$model;
        }

         if($request->get('region')!=''){
             $region =$request->get('region');
             //$api_request=$api_request.'&state[0]='.$region;
             $api_request=$api_request.'&state='.$region;
         }
         if($request->get('year_begin')!=''&&$request->get('year_and')!=''){
             $year_begin =$request->get('year_begin');
             $year_and =$request->get('year_and');
             //$api_request=$api_request.'&s_yers[1]='.$year_begin.'&po_yers[1]='.$year_and;
             $api_request=$api_request.'&s_yers='.$year_begin.'&po_yers='.$year_and;
         }
        //return new JsonResponse(['api'=>$region]);
        //return new JsonResponse(['api'=>$api_request]);


        //получаем ответ от сервера в json c id обьявлений
       $response_json_id = file_get_contents($api_request);
        // вытягем idшники
        $result = json_decode($response_json_id, TRUE);
        $ids = $result['result']['search_result']['ids'];

        //запрос получения по id
        $get_ob_by_id = 'https://developers.ria.com/auto/info?api_key=' . self::Get_API_Key() . '&auto_id=';
        // массив обявлений
        $cars = [];
        // цикл по id получаем массив  обявлений

        foreach ($ids as $id)
        {
            $temp_json_car = json_decode(file_get_contents($get_ob_by_id.$id), TRUE);
            $cars[] = array($id => array(
                'locationCityName' => self::Get_Prop_Car($temp_json_car,'locationCityName'),
                'markName' => self::Get_Prop_Car($temp_json_car,'markName'),
                'modelName' => self::Get_Prop_Car($temp_json_car,'modelName'),
                'price' => self::Get_Prop_Car($temp_json_car,'USD'),
                'subCategoryName' => self::Get_Prop_Car($temp_json_car,'subCategoryName'),
                'race' => self::Get_Inner_PropCar($temp_json_car,'autoData','race'),
                'color' => self::Get_Inner_PropCar($temp_json_car,'color','name'),
                'imgArr' => self::Get_Inner_PropCar($temp_json_car,'photoData','all'),
                'description' => self::Get_Inner_PropCar($temp_json_car,'autoData','description'),
                'year' => self::Get_Inner_PropCar($temp_json_car,'autoData','year')));
        }
        return new JsonResponse($cars);
    }
    public function Get_Type()
  {
       // получаем строку запроса апи
      $request = self::Get_Type_Request().self::Get_API_Key();
      try {
          //получаем отвт апи
          $result = json_decode(file_get_contents($request), TRUE);
          //возвращаем на вью апи ответ
          return new JsonResponse($result);
      }catch (Exception $e){return new JsonResponse(['response',$e->getMessage()]); }

  }
    public function Get_Mark(Request $request)
  {
      // получаем строку запроса апи
      $request = 'https://developers.ria.com/auto/categories/'.$request->get('type').'/marks?api_key='.self::Get_API_Key();
      try {
          //получаем отвт апи
          $result = json_decode(file_get_contents($request), TRUE);
          //возвращаем на вью апи ответ
          return new JsonResponse($result);
      }catch (Exception $e){return new JsonResponse(['response',$e->getMessage()]); }
  }
    public function Get_Model(Request $request)
  {
      // получаем строку запроса апи
      $API_request = 'https://developers.ria.com/auto/categories/'.$request->get('type').
          '/marks/'.$request->get('mark').'/models?api_key='.self::Get_API_Key();
      try {
          //получаем отвт апи
          $result = json_decode(file_get_contents($API_request), TRUE);
          //возвращаем на вью апи ответ
          return new JsonResponse($result);
      }catch (Exception $e){return new JsonResponse(['response',$e->getMessage()]); }
  }
    public function Get_Region()
    {
        // получаем строку запроса апи
        $API_request = 'https://developers.ria.com/auto/states?api_key='.self::Get_API_Key();
        try {
            //получаем отвт апи
            $result = json_decode(file_get_contents($API_request), TRUE);
            //возвращаем на вью апи ответ
            return new JsonResponse($result);
        }catch (Exception $e){return new JsonResponse(['response',$e->getMessage()]); }
    }


}
