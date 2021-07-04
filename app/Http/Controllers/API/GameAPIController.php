<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\GameAPIRequest;
use App\Http\Requests\API\GameUploadImageRequest;
use App\Models\EngagingSocialTool;
use App\Models\Game;
use App\Models\GameHasEngagingSocialTool;
use App\Models\GameHasPromoTool;
use App\Models\GameHasProperty;
use App\Models\GameProperty;
use App\Models\PromoTool;
use App\Models\TournamentsSpins;
use App\Repositories\GameRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\GameResource;
use Response;

/**
 * Class GameController
 * @package App\Http\Controllers\API
 */

class GameAPIController extends AppBaseController
{
    /** @var  GameRepository */
    private $gameRepository;

    public function __construct(GameRepository $gameRepo)
    {
        $this->gameRepository = $gameRepo;
    }

    /**
     * Display a listing of the Game.
     * GET|HEAD /games
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $games = $this->gameRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(GameResource::collection($games), 'Games retrieved successfully');
    }

    /**
     * Store a newly created Game in storage.
     * POST /games
     *
     * @param GameAPIRequest $request
     *
     * @return Response
     */
    public function store(GameAPIRequest $request)
    {
        $input = $request->all();
        $gameInput = $input;

        unset($gameInput['description']);
        unset($gameInput['properties']);
        unset($gameInput['properties']);
        unset($gameInput['promo_tools']);
        unset($gameInput['engaging_and_social']);
        unset($gameInput['TournamentsArea']);
        unset($gameInput['SpinsArea']);


        foreach ($input['description'] as $key => $val){
            $gameInput[$key] =  $val;
            $gameInput[$key]['devices'] = implode(',', $gameInput[$key]['devices']);
        }

        if($request->hasFile('logo')){
            $gameInput['logo'] = $request->file('logo')->store('game-logo','public_path');
        }

        if($request->hasFile('image')){
            $gameInput['image'] = $request->file('image')->store('game-image','public_path');
        }


        $gameInput['image_list'] = implode(',', $gameInput['slider_images']);





        $game = $this->gameRepository->create($gameInput);

        if(isset($input['properties'])){
            $properties = $input['properties'];
            foreach ($properties as $property){
                if(GameProperty::find($property)){
                    GameHasProperty::updateOrCreate(
                        ['game_id'   => $game->id, 'game_property_id' => $property],
                        ['game_id'   => $game->id, 'game_property_id' => $property]
                    );
                }
            }
        }

        if(isset($input['promo_tools'])){
            $promoTools = $input['promo_tools'];
            foreach ($promoTools as $promoTool){
                if(PromoTool::find($promoTool)){
                    GameHasPromoTool::updateOrCreate(
                        ['game_id'   => $game->id, 'promo_tool_id' => $promoTool],
                        ['game_id'   => $game->id, 'promo_tool_id' => $promoTool]
                    );
                }
            }
        }

        if(isset($input['engaging_and_social'])){
            $EngagingAndSocialList = $input['engaging_and_social'];
            foreach ($EngagingAndSocialList as $EngagingAndSocial){
                if(EngagingSocialTool::find($EngagingAndSocial)){
                    GameHasEngagingSocialTool::updateOrCreate(
                        ['game_id'   => $game->id, 'engaging_social_tool_id' => $EngagingAndSocial],
                        ['game_id'   => $game->id, 'engaging_social_tool_id' => $EngagingAndSocial]
                    );
                }
            }
        }

        if(isset($input['TournamentsArea'])){
            $TournamentsAreaInput = $input['TournamentsArea'];
            $TournamentsAreaData = json_decode(json_encode($TournamentsAreaInput,JSON_FORCE_OBJECT));
            TournamentsSpins::updateOrCreate(
                ['game_id'   => $game->id, 'type' => 'tournaments' ],
                ['game_id'   => $game->id, 'type' => 'tournaments' , 'image' => $TournamentsAreaData->image , 'image_col' => $TournamentsAreaData->image_col, 'title' => $TournamentsAreaData->en->title, 'description' => $TournamentsAreaData->en->description]
            );
        }

        if(isset($input['SpinsArea'])){
            $SpinsAreaInput = $input['TournamentsArea'];
            $SpinsAreaData = json_decode(json_encode($SpinsAreaInput,JSON_FORCE_OBJECT));
            TournamentsSpins::updateOrCreate(
                ['game_id'   => $game->id , 'type' => 'spins'],
                ['game_id'   => $game->id, 'type' => 'spins' , 'image' => $SpinsAreaData->image , 'image_col' => $SpinsAreaData->image_col, 'title' => $SpinsAreaData->en->title, 'description' => $SpinsAreaData->en->description]
            );
        }



        return $this->sendResponse(new GameResource($game), 'Game saved successfully');
    }

    /**
     * Display the specified Game.
     * GET|HEAD /games/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Game $game */
        $game = $this->gameRepository->find($id);
        if(empty($game)){
            $game = Game::where('url',$id)->first();
        }

        if (empty($game)) {
            return $this->sendError('Game not found');
        }
        $Data = new GameResource($game);
        $Data->additional(['edit'=> true]);
        return $this->sendResponse($Data, 'Game retrieved successfully');
    }

    /**
     * Update the specified Game in storage.
     * PUT/PATCH /games/{id}
     *
     * @param int $id
     * @param UpdateGameAPIRequest $request
     *
     * @return Response
     */
    public function update($id, GameAPIRequest $request)
    {
        /** @var Game $game */
        $game = $this->gameRepository->find($id);

        if (empty($game)) {
            return $this->sendError('Game not found');
        }

        $input = $request->all();
        $gameInput = $input;

        unset($gameInput['description']);
        unset($gameInput['properties']);
        unset($gameInput['promo_tools']);
        unset($gameInput['engaging_and_social']);

        foreach ($input['description'] as $key => $val){
            $gameInput[$key] =  $val;
            $gameInput[$key]['devices'] = implode(',', $gameInput[$key]['devices']);
        }

        $gameInput['image_list'] = implode(',', $gameInput['slider_images']);


        $game = $this->gameRepository->update($gameInput, $id);

        if(isset($input['properties'])){
            $properties = $input['properties'];
            foreach ($properties as $property){
                if(GameProperty::find($property)){
                    GameHasProperty::updateOrCreate(
                        ['game_id'   => $game->id, 'game_property_id' => $property],
                        ['game_id'   => $game->id, 'game_property_id' => $property]
                    );
                }
            }
        }

        if(isset($input['promo_tools'])){
            $promoTools = $input['promo_tools'];
            foreach ($promoTools as $promoTool){
                if(PromoTool::find($promoTool)){
                    GameHasPromoTool::updateOrCreate(
                        ['game_id'   => $game->id, 'promo_tool_id' => $promoTool],
                        ['game_id'   => $game->id, 'promo_tool_id' => $promoTool]
                    );
                }
            }
        }

        if(isset($input['engaging_and_social'])){
            $EngagingAndSocialList = $input['engaging_and_social'];
            foreach ($EngagingAndSocialList as $EngagingAndSocial){

                if(EngagingSocialTool::find($EngagingAndSocial)){
                    GameHasEngagingSocialTool::updateOrCreate(
                        ['game_id'   => $game->id, 'engaging_social_tool_id' => $EngagingAndSocial],
                        ['game_id'   => $game->id, 'engaging_social_tool_id' => $EngagingAndSocial]
                    );
                }
            }
        }

        if(isset($input['TournamentsArea'])){
            $TournamentsAreaInput = $input['TournamentsArea'];
            $TournamentsAreaData = json_decode(json_encode($TournamentsAreaInput,JSON_FORCE_OBJECT));
            TournamentsSpins::updateOrCreate(
                ['game_id'   => $game->id, 'type' => 'tournaments' ],
                ['game_id'   => $game->id, 'type' => 'tournaments' , 'image' => $TournamentsAreaData->image , 'image_col' => $TournamentsAreaData->image_col, 'title' => $TournamentsAreaData->en->title, 'description' => $TournamentsAreaData->en->description]
            );
        }else{
            TournamentsSpins::where('game_id','=',$game->id)->where('type','=','tournaments')->delete();
        }

        if(isset($input['SpinsArea'])){
            $SpinsAreaInput = $input['TournamentsArea'];
            $SpinsAreaData = json_decode(json_encode($SpinsAreaInput,JSON_FORCE_OBJECT));
            TournamentsSpins::updateOrCreate(
                ['game_id'   => $game->id , 'type' => 'spins'],
                ['game_id'   => $game->id, 'type' => 'spins' , 'image' => $SpinsAreaData->image , 'image_col' => $SpinsAreaData->image_col, 'title' => $SpinsAreaData->en->title, 'description' => $SpinsAreaData->en->description]
            );
        }else{
            TournamentsSpins::where('game_id','=',$game->id)->where('type','=','spins')->delete();
        }




        return $this->sendResponse(new GameResource($game), 'Game updated successfully');
    }

    /**
     * Remove the specified Game from storage.
     * DELETE /games/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Game $game */
        $game = $this->gameRepository->find($id);

        if (empty($game)) {
            return $this->sendError('Game not found');
        }

        $game->delete();

        return $this->sendSuccess('Game deleted successfully');
    }




    public function imageUpload(GameUploadImageRequest $request)
    {
        $ImageUploadName = [];
        if($request->hasFile('image')){
            $ImageUploadName['image'] = $request->file('image')->store($request->type,'public_path');
        }

        return $this->sendResponse($ImageUploadName, 'image updated successfully');
    }



    //        $stringSliderImages = "";
//        if($request->hasFile('slider_images')){
//            $SlideImagesFile = $request->file("slider_images");
//            if(is_array($SlideImagesFile)) {
//                foreach($SlideImagesFile as $SlideImage) {
//                    if($stringSliderImages != ""){
//                        $stringSliderImages = $stringSliderImages . ",";
//                    }
//                    $stringSliderImages =   $stringSliderImages  . $SlideImage->store('game-slide-images','public_path');
//                }
//            }else{
//                $stringSliderImages =  $request->file("slider_images")->store('game-slide-images','public_path');
//            }
//        }


}
