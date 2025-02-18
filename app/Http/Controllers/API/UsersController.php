<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : JsonResponse
    {
         try {  
            $result = User::find($id);

            return response()->json([
                'success' => true,
                'message' => 'Get All Transaction',
                'data' => $result
            ]);

        } catch (\Exception $e) {
              return response()->json([
                'success' => false,
                'message' => 'Failed Get All Transaction',
                'error' => $e->getMessage(), // Optional: include the actual error message
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) : JsonResponse
    {
        try {
            $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:1000', 
            'password' => 'nullable|string|min:6|max:255|confirmed', 
            ]);

            $user = User::findOrFail($id);

            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->address = $validated['address'] ?? $user->address;

            if (isset($validated['password']) && !empty($validated['password'])) {
                $user->password = bcrypt($validated['password']); 
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
