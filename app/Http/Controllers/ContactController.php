<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class ContactController extends Controller
{
    /**
     * List contact data from resource.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $contacts = Contact::where(function($query) use ($request) {
            // Filter contact by name if data is given
            if ($request->name) {
                $query->where('nome', 'like', "%{$request->name}%");
            }
        })->get();

        return response()
            ->json($contacts);
    }

    /**
     * List contact data from resource.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        // Validate the data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => [
                'email',
                'unique:contacts',
            ],
            'phone' => [
                'unique:contacts',
                'min:14',
                'max:18'
            ],// *TO DO* Include phone validation that handles every phone format.
        ]);
        

        // If data is invalid 
        if ($validator->fails()) {
            return response(json_encode([
                'status' => false,
                'erros' => $validator->errors()->all(),
            ]), 400);
        }

        $contact = Contact::create($request->all());

        return response(json_encode([
            'status' => $contact->getKey() > 0,
            'contact_id' => $contact->getKey(),
        ]), 201);
    }

    /**
     * Show contact data from resource.
     *
     * @param Request $request
     * @param int $contact_id
     * @return void
     */
    public function show(Request $request, $contact_id)
    {
        $contact = Contact::find($contact_id);

        if ($contact) {
            return response($contact->toJson(), 200);
        }

        return response(json_encode([
            'status' => false
        ]), 404);
    }

    /**
     * Update contact data from resource.
     *
     * @param Request $request
     * @param int $contact_id
     * @return void
     */
    public function update(Request $request, $contact_id)
    {
        $contact = Contact::find($contact_id);
    
        if (!$contact) {
            return response(json_encode([
                'status' => false
            ]), 404);
        }

        // Validate the data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => [
                'email',
                Rule::unique('contacts')->ignore($contact->id),
            ],
            'phone' => [
                Rule::unique('contacts')->ignore($contact->id),
                'min:14',
                'max:18'
            ],// *TO DO* Include phone validation that handles every phone format.
        ]);
        
        if ($validator->fails()) {
            return response(json_encode([
                'status' => false,
                'erros' => $validator->errors()->all(),
            ]), 400);
        }

        $contact->update($request->all());

        return response(json_encode([
            'status' => $contact->getKey() > 0,
            'contact_id' => $contact->getKey(),
        ]), 201);
    }

    /**
     * Show contact data from resource.
     *
     * @param Request $request
     * @param int $contact_id
     * @return void
     */
    public function delete(Request $request, $contact_id)
    {
        $contact = Contact::find($contact_id);

        if ($contact) {
            $contact->delete();
            return response(json_encode(['status' => true]), 200);
        }

        return response(json_encode([
            'status' => false
        ]), 404);
    }
    
}
