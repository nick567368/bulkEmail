<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateBulkSmsAPIRequest;
use App\Http\Requests\API\UpdateBulkSmsAPIRequest;
use App\Models\BulkSms;
use App\Models\User;
use App\Repositories\BulkSmsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Response;
use Validator;

/**
 * Class BulkSmsController
 * @package App\Http\Controllers\API
 */

class BulkSmsAPIController extends AppBaseController
{
    /** @var  BulkSmsRepository */
    private $bulkSmsRepository;

    public function __construct(BulkSmsRepository $bulkSmsRepo)
    {
        $this->bulkSmsRepository = $bulkSmsRepo;
    }

    /**
     * Display a listing of the BulkSms.
     * GET|HEAD /bulkSms
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $users = User::all();
        return view('bulkSms', compact('users', $users));
    }

    /**
     * Store a newly created BulkSms in storage.
     * POST /bulkSms
     *
     * @param CreateBulkSmsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateBulkSmsAPIRequest $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'message' => 'required',
            'image_name' => 'required',
            'users' => 'required|array',
        ]);
        if ($validator->fails()) {
           return response()->json(['error' => $validator->errors()->all()]);

        }

        $input['image_name'] = $strFileName = uniqid() . time() . '.' . $request->image_name->getClientOriginalExtension();

        $filePath = 'public/bulk/';
        $path = $request->image_name->storeAs($filePath, $strFileName);
        Storage::url($path);
        $input['image_path'] = 'storage/bulk/' . $strFileName;
        // $input['users'] = $request->users;
        $input['host'] = request()->getHttpHost();
        $input['path'] = public_path() . '/' . $input['image_path'];

        // $bulkSms = BulkSms::create($input);
        $bulkSms = $this->bulkSmsRepository->create($input);

        foreach ($input['users'] as $key => $value) {
            $data = array('name' => $input['message']);

            \Mail::send('emails.test', $data, function ($message) use ($input, $value) {
                $message->to($value)
                    ->subject($input['title']);
                $message->attach($input['path']);

            });
        }


        return $this->sendResponse($bulkSms->toArray(), 'Bulk Sms saved successfully');
    }

    /**
     * Display the specified BulkSms.
     * GET|HEAD /bulkSms/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var BulkSms $bulkSms */
        $bulkSms = $this->bulkSmsRepository->find($id);

        if (empty($bulkSms)) {
            return $this->sendError('Bulk Sms not found');
        }

        return $this->sendResponse($bulkSms->toArray(), 'Bulk Sms retrieved successfully');
    }

    /**
     * Update the specified BulkSms in storage.
     * PUT/PATCH /bulkSms/{id}
     *
     * @param int $id
     * @param UpdateBulkSmsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBulkSmsAPIRequest $request)
    {
        $input = $request->all();

        /** @var BulkSms $bulkSms */
        $bulkSms = $this->bulkSmsRepository->find($id);

        if (empty($bulkSms)) {
            return $this->sendError('Bulk Sms not found');
        }

        $bulkSms = $this->bulkSmsRepository->update($input, $id);

        return $this->sendResponse($bulkSms->toArray(), 'BulkSms updated successfully');
    }

    /**
     * Remove the specified BulkSms from storage.
     * DELETE /bulkSms/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var BulkSms $bulkSms */
        $bulkSms = $this->bulkSmsRepository->find($id);

        if (empty($bulkSms)) {
            return $this->sendError('Bulk Sms not found');
        }

        $bulkSms->delete();

        return $this->sendSuccess('Bulk Sms deleted successfully');
    }
}
