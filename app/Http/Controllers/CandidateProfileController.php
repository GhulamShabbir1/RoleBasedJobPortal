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
use App\Features\CandidateProfile\UpdateCandidateProfileFeature;
use App\Http\Requests\CandidateProfile\CandidateProfileFilterRequest;
use App\Http\Requests\CandidateProfile\StoreCandidateProfileRequest;
use App\Http\Requests\CandidateProfile\UpdateCandidateProfileRequest;
use Illuminate\Http\JsonResponse;

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
            ], 500);
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
            $profiles = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Candidate profiles filtered successfully',
                'data' => $profiles,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
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
            $dto = CreateCandidateProfileDTO::fromRequest($request);
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
            ], 500);
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
            ], $e->getCode() ?? 500);
        }
    }

    /**
     * Get current user's candidate profile
     */
    public function me(): JsonResponse
    {
        try {
            $profile = (new \App\Features\CandidateProfile\GetMyCandidateProfileFeature(
                app(\App\Repositories\Interfaces\CandidateProfileRepositoryInterface::class)
            ))->handle();

            return response()->json([
                'success' => true,
                'message' => 'Profile retrieved successfully',
                'data' => $profile,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?? 500);
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
            $dto = UpdateCandidateProfileDTO::fromRequest($request);
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
            ], $e->getCode() ?? 500);
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
            ], $e->getCode() ?? 500);
        }
    }
}
