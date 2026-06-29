<?php

namespace App\Http\Controllers;

use App\DTOs\CandidateProfile\CandidateProfileFilterDTO;
use App\DTOs\CandidateProfile\CreateCandidateProfileDTO;
use App\DTOs\CandidateProfile\UpdateCandidateProfileDTO;
use App\Features\CandidateProfile\CreateCandidateProfileFeature;
use App\Features\CandidateProfile\DeleteCandidateProfileFeature;
use App\Features\CandidateProfile\FilterCandidateProfilesFeature;
use App\Features\CandidateProfile\GetCandidateProfileFeature;
use App\Features\CandidateProfile\GetCandidateProfilesFeature;
use App\Features\CandidateProfile\GetMyCandidateProfileFeature;
use App\Features\CandidateProfile\UpdateCandidateProfileFeature;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CandidateProfile\CandidateProfileFilterRequest;
use App\Http\Requests\CandidateProfile\StoreCandidateProfileRequest;
use App\Http\Requests\CandidateProfile\UpdateCandidateProfileRequest;


class CandidateProfileController extends Controller
{
    /**
     * Get all candidate profiles (admin only)
     */
    public function index(GetCandidateProfilesFeature $feature): JsonResponse
    {
        try {
            $profiles = $feature->handle();

            return response()->json([
                'success' => true,
                'message' => 'Candidate profiles retrieved successfully',
                'data' => $profiles,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Filter candidate profiles (public access)
     */
    public function filter(
        CandidateProfileFilterRequest $request,
        FilterCandidateProfilesFeature $feature
    ): JsonResponse {
        try {
            $dto = CandidateProfileFilterDTO::fromRequest($request);
            $paginated = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Candidate profiles filtered successfully',
                'data' => $paginated->items(),
                'pagination' => [
                    'total' => $paginated->total(),
                    'per_page' => $paginated->perPage(),
                    'current_page' => $paginated->currentPage(),
                    'last_page' => $paginated->lastPage(),
                    'from' => $paginated->firstItem(),
                    'to' => $paginated->lastItem(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Store a new candidate profile (candidate only)
     */
    public function store(
        StoreCandidateProfileRequest $request,
        CreateCandidateProfileFeature $feature
    ): JsonResponse {
        try {
            $data = $request->validated();

            if ($request->hasFile('resume')) {
                $file = $request->file('resume');
                $path = $file->store('resumes', 'public');
                $data['resume_url'] = asset('storage/' . $path);
            }

            $dto = CreateCandidateProfileDTO::fromArray(auth()->id(), $data);
            $profile = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Candidate profile created successfully',
                'data' => $profile,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Show single candidate profile
     */
    public function show(string $id, GetCandidateProfileFeature $feature): JsonResponse
    {
        try {
            $profile = $feature->handle($id);

            return response()->json([
                'success' => true,
                'message' => 'Candidate profile retrieved successfully',
                'data' => $profile,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Get current user's candidate profile
     */
    public function me(GetMyCandidateProfileFeature $feature): JsonResponse
    {
        try {
            $profile = $feature->handle();

            return response()->json([
                'success' => true,
                'message' => 'Profile retrieved successfully',
                'data' => $profile,
            ], 200);
        } catch (\Exception $e) {
            \Log::error('CandidateProfileController@me error', [
                'auth_user_id' => auth()->id(),
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }


    /**
     * Update candidate profile (candidate only)
     */
    public function update(
        string $id,
        UpdateCandidateProfileRequest $request,
        UpdateCandidateProfileFeature $feature
    ): JsonResponse {
        try {
            $data = $request->validated();

            if ($request->hasFile('resume')) {
                $file = $request->file('resume');
                $path = $file->store('resumes', 'public');
                $data['resume_url'] = asset('storage/' . $path);
            }

            $dto = UpdateCandidateProfileDTO::fromArray($id, $data);
            $profile = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Candidate profile updated successfully',
                'data' => $profile,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Delete candidate profile (candidate/admin only)
     */
    public function destroy(string $id, DeleteCandidateProfileFeature $feature): JsonResponse
    {
        try {
            $feature->handle($id);

            return response()->json([
                'success' => true,
                'message' => 'Candidate profile deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Debug: List all profiles and their user_ids
     */
    public function debugListAllProfiles(): JsonResponse
    {
        $profiles = \App\Models\CandidateProfile::with('user:id,name,email')->get();
        $currentUser = auth()->user();

        return response()->json([
            'current_user_id' => $currentUser->id ?? null,
            'current_user_email' => $currentUser->email ?? null,
            'total_profiles' => count($profiles),
            'all_profiles' => $profiles->map(function($p) {
                return [
                    'id' => $p->id,
                    'user_id' => $p->user_id,
                    'user_name' => $p->user->name ?? null,
                    'user_email' => $p->user->email ?? null,
                    'city' => $p->city,
                    'created_at' => $p->created_at,
                ];
            }),
        ]);
    }
}
