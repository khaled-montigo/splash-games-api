<?php

namespace App\Http\Resources;

use App\Models\Game;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        app()->setLocale('en');


        $ReturnedData = [
            'id' => $this->id,
            'section' => $this->section,
            'name' => isset($this->name) ? $this->name : '',
            'url' => $this->url,
            'image' =>  url('/') .'/'. $this->image,
            'images' =>  $this->GetGameImages(),
            'col' => $this->col,
            'description' => isset($this->description) ? $this->description : '',
            'game_type' => isset($this->game_type) ? $this->game_type : '',
            'category' => isset($this->category) ? $this->category : '',
            'rtp' => isset($this->rtp) ? $this->rtp	 : '',
            'devices' => isset($this->devices) ? $this->devices : '',
            'tournaments' => isset($this->tournaments) ? $this->tournaments : '',
            'additional' => isset($this->game_additional) ? $this->game_additional : '',
            'logo' => url('/') .'/'.  $this->logo,
            'devices_image' => url('/') .'/'.  $this->devices_image,
            'Properties' => $this->RelationProperties(),
            'PromoTools' => $this->RelationPromoTools(),
            'EngagingAndSocial' => $this->RelationEngagingAndSocialData(),
            'TournamentsArea' => $this->RelationTournamentsArea(),
            'SpinsArea' => $this->RelationSpinsArea(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if($this->additional != null){
            if($this->additional["edit"]){
                $ReturnedData['selectedProperties'] = $this->PropertiesIDs();
                $ReturnedData['selectedPromoTools'] = $this->PromoToolsIDs();
                $ReturnedData['selectedSocialEngaging'] = $this->EngagingAndSocialIDs();
            }
        }




        return $ReturnedData;
    }


    private function GetGameImages() {
        $imagesArr = [];
        if(!strpos($this->image_list,',')){
            $imagesArr[0] = url('/') .'/'. $this->image_list;
            return $imagesArr;
        }

        $imagesStArr = explode(",", $this->image_list);
        foreach ($imagesStArr as $value) {
            $imagesArr[] = url('/') .'/'. $value;
        }
        return $imagesArr;
    }

    private function RelationProperties(){
        $propertiesList = [];
        if(!isset($this->Properties)){
            return null;
        }
        foreach ($this->Properties as $property){
            $propertyData = [];
            $propertyData['icon'] = $property->icon;
            $propertyData['title'] = $property->title;
            $propertyData['description'] = $property->description;
            array_push($propertiesList,$propertyData);
        }
        return $propertiesList;
    }

    private function RelationPromoTools(){
        $promoToolsList = [];
        if(!isset($this->PromoTools)){
            return null;
        }
        foreach ($this->PromoTools as $index => $promoTool){
            $promoData = [];
            $promoData['image'] = $promoTool->image;
            $promoData['title'] = $promoTool->title;
            $promoData['description'] = $promoTool->description;
            if(count($this->PromoTools) == 1){
                $promoData['col'] = 12;
            }
            if(count($this->PromoTools) == 2){
                $promoData['col'] = 6;
            }
            if(count($this->PromoTools) == 3){
                $promoData['col'] =  5;
                if($index == 0){
                    $promoData['col'] = 12;
                }
                if($index == 1){
                    $promoData['col'] = 7;
                }

            }
            if(count($this->PromoTools) > 3){
                $promoData['col'] = 6;
            }

            $promoData['button'] = $promoTool->button;
            array_push($promoToolsList,$promoData);
        }
        return $promoToolsList;
    }

    private function RelationEngagingAndSocialData(){
        $EngagingAndSocialData = null;
        $EngagingAndSocialPropertiesList = $this->RelationEngagingAndSocialProperties();
        if(count($EngagingAndSocialPropertiesList) > 0){
            $EngagingAndSocialData['tools'] = true;
            $EngagingAndSocialData['description'] = $this->engaging_social_description;
            $EngagingAndSocialData['Properties'] = $EngagingAndSocialPropertiesList;
        }
        return $EngagingAndSocialData;
    }
    private function RelationEngagingAndSocialProperties(){
        $engaging_social_List = [];
        if(isset($this->EngagingAndSocial)){
            foreach ($this->EngagingAndSocial as $EngagingAndSocial){
                $EngagingAndSocialData = [];
                $EngagingAndSocialData['icon'] = $EngagingAndSocial->icon;
                $EngagingAndSocialData['title'] = $EngagingAndSocial->title;
                $EngagingAndSocialData['description'] = $EngagingAndSocial->description;
                $EngagingAndSocialData['image'] = $EngagingAndSocial->image;
                array_push($engaging_social_List,$EngagingAndSocialData);
            }
        }
        return $engaging_social_List;
    }



    private function RelationTournamentsArea(){
        $TournamentsAreaData = null;
        $TournamentsAreaRelationData = $this->TournamentsArea;
        if($TournamentsAreaRelationData){
            $TournamentsAreaData['tools'] = true;
            $TournamentsAreaData['image_col'] = $TournamentsAreaRelationData->image_col;
            $TournamentsAreaData['image'] = $TournamentsAreaRelationData->image;
            $TournamentsAreaData['title'] = $TournamentsAreaRelationData->title;
            $TournamentsAreaData['description'] = $TournamentsAreaRelationData->description;
        }
        return $TournamentsAreaData;
    }


    private function RelationSpinsArea(){
        $SpinsAreaData = null;
        $SpinsAreaRelationData = $this->TournamentsArea;
        if($SpinsAreaRelationData){
            $SpinsAreaData['tools'] = true;
            $SpinsAreaData['image_col'] = $SpinsAreaRelationData->image_col;
            $SpinsAreaData['image'] = $SpinsAreaRelationData->image;
            $SpinsAreaData['title'] = $SpinsAreaRelationData->title;
            $SpinsAreaData['description'] = $SpinsAreaRelationData->description;
        }
        return $SpinsAreaData;
    }
}
