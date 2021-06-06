<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\EngagingSocialToolAPIRequest;
use App\Http\Requests\API\UpdateEngagingSocialToolAPIRequest;
use App\Models\EngagingSocialTool;
use App\Repositories\EngagingSocialToolRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\EngagingSocialToolResource;
use Response;

/**
 * Class EngagingSocialToolController
 * @package App\Http\Controllers\API
 */

class EngagingSocialToolAPIController extends AppBaseController
{
    /** @var  EngagingSocialToolRepository */
    private $engagingSocialToolRepository;

    public function __construct(EngagingSocialToolRepository $engagingSocialToolRepo)
    {
        $this->engagingSocialToolRepository = $engagingSocialToolRepo;
    }

    /**
     * Display a listing of the EngagingSocialTool.
     * GET|HEAD /engagingSocialTools
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $engagingSocialTools = $this->engagingSocialToolRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(EngagingSocialToolResource::collection($engagingSocialTools), 'Engaging Social Tools retrieved successfully');
    }

    /**
     * Store a newly created EngagingSocialTool in storage.
     * POST /engagingSocialTools
     *
     * @param EngagingSocialToolAPIRequest $request
     *
     * @return Response
     */
    public function store(EngagingSocialToolAPIRequest $request)
    {
        $input = $request->all();
        $EngagingSocialInput = $input;

        if($request->hasFile('icon')){
            $EngagingSocialInput['icon'] = $request->file('icon')->store('engaging-tools','public_path');
        }

        if($request->hasFile('image')){
            $EngagingSocialInput['image'] = $request->file('image')->store('engaging-tools','public_path');
        }


        unset($EngagingSocialInput['engaging_social']);
        if(isset($input['engaging_social'])){
            foreach ($input['engaging_social'] as $key => $val){
                $EngagingSocialInput[$key] =  $val;
            }
        }

        $engagingSocialTool = $this->engagingSocialToolRepository->create($EngagingSocialInput);

        return $this->sendResponse(new EngagingSocialToolResource($engagingSocialTool), 'Engaging Social Tool saved successfully');
    }

    /**
     * Display the specified EngagingSocialTool.
     * GET|HEAD /engagingSocialTools/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var EngagingSocialTool $engagingSocialTool */
        $engagingSocialTool = $this->engagingSocialToolRepository->find($id);

        if (empty($engagingSocialTool)) {
            return $this->sendError('Engaging Social Tool not found');
        }

        return $this->sendResponse(new EngagingSocialToolResource($engagingSocialTool), 'Engaging Social Tool retrieved successfully');
    }

    /**
     * Update the specified EngagingSocialTool in storage.
     * PUT/PATCH /engagingSocialTools/{id}
     *
     * @param int $id
     * @param UpdateEngagingSocialToolAPIRequest $request
     *
     * @return Response
     */
    public function update($id, EngagingSocialToolAPIRequest $request)
    {
        $input = $request->all();
        $EngagingSocialInput = $input;

        if($request->hasFile('icon')){
            $EngagingSocialInput['icon'] = $request->file('icon')->store('engaging-tools','public_path');
        }

        if($request->hasFile('image')){
            $EngagingSocialInput['image'] = $request->file('image')->store('engaging-tools','public_path');
        }

        unset($EngagingSocialInput['engaging_social']);
        if(isset($input['engaging_social'])){
            foreach ($input['engaging_social'] as $key => $val){
                $EngagingSocialInput[$key] =  $val;
            }
        }

        /** @var EngagingSocialTool $engagingSocialTool */
        $engagingSocialTool = $this->engagingSocialToolRepository->find($id);

        if (empty($engagingSocialTool)) {
            return $this->sendError('Engaging Social Tool not found');
        }


        unset($EngagingSocialInput['engaging_social']);
        if(isset($input['engaging_social'])){
            foreach ($input['engaging_social'] as $key => $val){
                $EngagingSocialInput[$key] =  $val;
            }
        }


        $engagingSocialTool = $this->engagingSocialToolRepository->update($EngagingSocialInput, $id);

        return $this->sendResponse(new EngagingSocialToolResource($engagingSocialTool), 'EngagingSocialTool updated successfully');
    }

    /**
     * Remove the specified EngagingSocialTool from storage.
     * DELETE /engagingSocialTools/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var EngagingSocialTool $engagingSocialTool */
        $engagingSocialTool = $this->engagingSocialToolRepository->find($id);

        if (empty($engagingSocialTool)) {
            return $this->sendError('Engaging Social Tool not found');
        }

        $engagingSocialTool->delete();

        return $this->sendSuccess('Engaging Social Tool deleted successfully');
    }
}
