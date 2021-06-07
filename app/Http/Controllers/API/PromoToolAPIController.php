<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\PromoToolAPIRequest;
use App\Http\Requests\API\UpdatepromoToolAPIRequest;
use App\Models\PromoTool;
use App\Repositories\promoToolRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\promoToolResource;
use Response;

/**
 * Class promoToolController
 * @package App\Http\Controllers\API
 */

class PromoToolAPIController extends AppBaseController
{
    /** @var  promoToolRepository */
    private $promoToolRepository;

    public function __construct(promoToolRepository $promoToolRepo)
    {
        $this->promoToolRepository = $promoToolRepo;
    }

    /**
     * Display a listing of the promoTool.
     * GET|HEAD /promoTools
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $promoTools = $this->promoToolRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(promoToolResource::collection($promoTools), 'Promo Tools retrieved successfully');
    }

    /**
     * Store a newly created promoTool in storage.
     * POST /promoTools
     *
     * @param PromoToolAPIRequest $request
     *
     * @return Response
     */
    public function store(PromoToolAPIRequest $request)
    {
        $input = $request->all();
        $promoToolInput = $input;


        if($request->hasFile('icon')){
            $promoToolInput['icon'] = $request->file('icon')->store('promo-tools','public_path');
        }

        unset($promoToolInput['promo_tools']);
        if(isset($input['promo_tools'])){
            foreach ($input['promo_tools'] as $key => $val){
                $promoToolInput[$key] =  $val;
            }
        }

        $promoTool = $this->promoToolRepository->create($promoToolInput);

        return $this->sendResponse(new promoToolResource($promoTool), 'Promo Tool saved successfully');
    }

    /**
     * Display the specified promoTool.
     * GET|HEAD /promoTools/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var promoTool $promoTool */
        $promoTool = $this->promoToolRepository->find($id);

        if (empty($promoTool)) {
            return $this->sendError('Promo Tool not found');
        }

        return $this->sendResponse(new promoToolResource($promoTool), 'Promo Tool retrieved successfully');
    }

    /**
     * Update the specified promoTool in storage.
     * PUT/PATCH /promoTools/{id}
     *
     * @param int $id
     * @param UpdatepromoToolAPIRequest $request
     *
     * @return Response
     */
    public function update($id, PromoToolAPIRequest $request)
    {

        $input = $request->all();
        $promoTool = $this->promoToolRepository->find($id);
        if (empty($promoTool)) {
            return $this->sendError('Promo Tool not found');
        }

        $promoToolInput = $input;
        unset($promoToolInput['promo_tools']);


        if($request->hasFile('icon')){
            $promoToolInput['icon'] = $request->file('icon')->store('promo-tools','public_path');
        }

        if(isset($input['promo_tools'])){
            foreach ($input['promo_tools'] as $key => $val){
                $promoToolInput[$key] =  $val;
            }
        }


        $promoTool = $this->promoToolRepository->update($promoToolInput, $id);

        return $this->sendResponse(new promoToolResource($promoTool), 'promoTool updated successfully');
    }

    /**
     * Remove the specified promoTool from storage.
     * DELETE /promoTools/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var promoTool $promoTool */
        $promoTool = $this->promoToolRepository->find($id);

        if (empty($promoTool)) {
            return $this->sendError('Promo Tool not found');
        }

        $promoTool->delete();

        return $this->sendSuccess('Promo Tool deleted successfully');
    }
}
