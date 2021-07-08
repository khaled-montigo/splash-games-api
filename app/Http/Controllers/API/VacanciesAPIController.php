<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\VacanciesAPIRequest;
use App\Http\Requests\API\UpdateVacanciesAPIRequest;
use App\Models\Vacancies;
use App\Repositories\VacanciesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\VacanciesResource;
use Response;

/**
 * Class VacanciesController
 * @package App\Http\Controllers\API
 */

class VacanciesAPIController extends AppBaseController
{
    /** @var  VacanciesRepository */
    private $vacanciesRepository;

    public function __construct(VacanciesRepository $vacanciesRepo)
    {
        $this->vacanciesRepository = $vacanciesRepo;
    }

    /**
     * Display a listing of the Vacancies.
     * GET|HEAD /vacancies
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $vacancies = $this->vacanciesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(VacanciesResource::collection($vacancies), 'Vacancies retrieved successfully');
    }

    /**
     * Store a newly created Vacancies in storage.
     * POST /vacancies
     *
     * @param VacanciesAPIRequest $request
     *
     * @return Response
     */
    public function store(VacanciesAPIRequest $request)
    {
        $input = $request->all();
        $VacanciesInput = $input;

        unset($VacanciesInput['description']);

        foreach ($input['description'] as $key => $val){
            $VacanciesInput[$key] =  $val;
        }


        $vacancies = $this->vacanciesRepository->create($VacanciesInput);

        return $this->sendResponse(new VacanciesResource($vacancies), 'Vacancies saved successfully');
    }

    /**
     * Display the specified Vacancies.
     * GET|HEAD /vacancies/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Vacancies $vacancies */
        $vacancies = $this->vacanciesRepository->find($id);

        if (empty($vacancies)) {
            return $this->sendError('Vacancies not found');
        }

        return $this->sendResponse(new VacanciesResource($vacancies), 'Vacancies retrieved successfully');
    }

    /**
     * Update the specified Vacancies in storage.
     * PUT/PATCH /vacancies/{id}
     *
     * @param int $id
     * @param UpdateVacanciesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, VacanciesAPIRequest $request)
    {
        $input = $request->all();
        $VacanciesInput = $input;

        /** @var Vacancies $vacancies */
        $vacancies = $this->vacanciesRepository->find($id);

        if (empty($vacancies)) {
            return $this->sendError('Vacancies not found');
        }



        unset($VacanciesInput['description']);

        foreach ($input['description'] as $key => $val){
            $VacanciesInput[$key] =  $val;
        }


        $vacancies = $this->vacanciesRepository->update($VacanciesInput, $id);

        return $this->sendResponse(new VacanciesResource($vacancies), 'Vacancies updated successfully');
    }

    /**
     * Remove the specified Vacancies from storage.
     * DELETE /vacancies/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Vacancies $vacancies */
        $vacancies = $this->vacanciesRepository->find($id);

        if (empty($vacancies)) {
            return $this->sendError('Vacancies not found');
        }

        $vacancies->delete();

        return $this->sendSuccess('Vacancies deleted successfully');
    }
}
