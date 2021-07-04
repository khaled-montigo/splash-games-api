<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\GamePropertyAPIRequest;
use App\Models\GameProperty;
use App\Repositories\GamePropertyRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\GamePropertyResource;
use Response;

/**
 * Class GamePropertyController
 * @package App\Http\Controllers\API
 */

class GamePropertyAPIController extends AppBaseController
{
    /** @var  GamePropertyRepository */
    private $gamePropertyRepository;

    public function __construct(GamePropertyRepository $gamePropertyRepo)
    {
        $this->gamePropertyRepository = $gamePropertyRepo;
    }

    /**
     * Display a listing of the GameProperty.
     * GET|HEAD /gameProperties
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $gameProperties = $this->gamePropertyRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(GamePropertyResource::collection($gameProperties), 'Game Properties retrieved successfully');
    }

    /**
     * Store a newly created GameProperty in storage.
     * POST /gameProperties
     *
     * @param GamePropertyAPIRequest $request
     *
     * @return Response
     */
    public function store(GamePropertyAPIRequest $request)
    {
        $input = $request->all();
        $gamePropertyInput = $input;



        unset($gamePropertyInput['properties']);

        if(isset($input['properties'])){
            foreach ($input['properties'] as $key => $val){
                $gamePropertyInput[$key] =  $val;
            }
        }


        $gameProperty = $this->gamePropertyRepository->create($gamePropertyInput);

        return $this->sendResponse(new GamePropertyResource($gameProperty), 'Game Property saved successfully');
    }

    /**
     * Display the specified GameProperty.
     * GET|HEAD /gameProperties/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var GameProperty $gameProperty */
        $gameProperty = $this->gamePropertyRepository->find($id);

        if (empty($gameProperty)) {
            return $this->sendError('Game Property not found');
        }

        return $this->sendResponse(new GamePropertyResource($gameProperty), 'Game Property retrieved successfully');
    }

    /**
     * Update the specified GameProperty in storage.
     * PUT/PATCH /gameProperties/{id}
     *
     * @param int $id
     * @param UpdateGamePropertyAPIRequest $request
     *
     * @return Response
     */
    public function update($id, GamePropertyAPIRequest $request)
    {
        $input = $request->all();
        $gamePropertyInput = $input;

        if($request->hasFile('icon')){
            $gamePropertyInput['icon'] = $request->file('icon')->store('game-property','public_path');
        }


        unset($gamePropertyInput['properties']);

        if(isset($input['properties'])){
            foreach ($input['properties'] as $key => $val){
                $gamePropertyInput[$key] =  $val;
            }
        }

        /** @var GameProperty $gameProperty */
        $gameProperty = $this->gamePropertyRepository->find($id);

        if (empty($gameProperty)) {
            return $this->sendError('Game Property not found');
        }

        $gameProperty = $this->gamePropertyRepository->update($gamePropertyInput, $id);

        return $this->sendResponse(new GamePropertyResource($gameProperty), 'GameProperty updated successfully');
    }

    /**
     * Remove the specified GameProperty from storage.
     * DELETE /gameProperties/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var GameProperty $gameProperty */
        $gameProperty = $this->gamePropertyRepository->find($id);

        if (empty($gameProperty)) {
            return $this->sendError('Game Property not found');
        }

        $gameProperty->delete();

        return $this->sendSuccess('Game Property deleted successfully');
    }
}
