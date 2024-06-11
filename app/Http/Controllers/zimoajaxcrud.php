<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\zimoajaxcruds;

class zimoajaxcrud extends Controller
{
    public function index()
    {
        $ngrok_link = config('app.ngrok_Link');
        return view('ajaxcrud/index',compact('ngrok_link'));
    }

    public function getCompanies()
    {
        $companies = zimoajaxcruds::all();
        return response()->json($companies);
    }

    public function delete($id)
    {
        $company = zimoajaxcruds::find($id);

        if ($company->delete()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'tax_id' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();
        $image->storeAs('public/ajaxcrudtask', $imageName);

        $company = new zimoajaxcruds;
        $company->name = $request->name; 
        $company->address = $request->address; 
        $company->city = $request->city;
        $company->tax_id = $request->tax_id; 
        $company->image = $imageName;
        $company->save();

        $request->session()->flash('success', 'Company saved successfully.');
        return response()->json(['success' => 'Company saved successfully.']);
    }

    public function show($id)
    {
        $company = zimoajaxcruds::findOrFail($id);
        return response()->json($company);
    }
    public function edit($id)
    {
        $company = zimoajaxcruds::findOrFail($id);
        return response()->json($company);
    }
    public function update(Request $request, $id)
{
    // Validate the request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'tax_id' => 'required|string|max:255',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Find the company by ID
    $company = zimoajaxcruds::findOrFail($id);

    // Handle image upload if present
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();
        $image->storeAs('public/ajaxcrudtask', $imageName);
        $validatedData['image'] = $imageName;
    }

    // Update the company with validated data
    $company->update($validatedData);

    // Return a JSON response indicating success
    return response()->json([
        'status' => 'success',
        'message' => 'Company updated successfully',
        'data' => $company,
    ]);
}

}
