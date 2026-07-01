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


/**
 * CandidateProfileController
 *
 * Handles candidate profile CRUD operations, filtering, and resume uploads.
 * Candidates can create/update their profiles with resume files and skills.
 * Admins have management access to all profiles.
 */
class CandidateProfileController extends Controller
{
  /**
   * Get all candidate profiles (admin only)
   *
   * @param GetCandidateProfilesFeature $feature Feature class for retrieving profiles
   * @return JsonResponse JSON response with all candidate profiles
   */
  public function index(GetCandidateProfilesFeature $feature): JsonResponse
  {
    try {
      $profiles = $feature->handle();

      return response()->json([
        'status' => true,
        'message' => 'Candidate profiles retrieved successfully',
        'data' => $profiles,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Filter candidate profiles (public access)
   *
   * @param CandidateProfileFilterRequest $request HTTP request with filter criteria
   * @param FilterCandidateProfilesFeature $feature Feature class for filtering profiles
   * @return JsonResponse Paginated JSON response with filtered profiles
   */
  public function filter(
    CandidateProfileFilterRequest $request,
    FilterCandidateProfilesFeature $feature
  ): JsonResponse {
    try {
      $dto = CandidateProfileFilterDTO::fromRequest($request);
      $paginated = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Candidate profiles filtered successfully',
        'data' => $paginated->items(),
        'pagination' => [
          'total' => $paginated->total(),
          'per_page' => $paginated->perPage(),
          'current_page' => $paginated->currentPage(),
          'last_page' => $paginated->lastPage(),
        ],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Store a new candidate profile (candidate only)
   *
   * @param StoreCandidateProfileRequest $request HTTP request with profile details and resume
   * @param CreateCandidateProfileFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with created profile
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
        'status' => true,
        'message' => 'Candidate profile created successfully',
        'data' => $profile,
      ], 201);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Show single candidate profile
   *
   * @param string $id Candidate profile identifier
   * @param GetCandidateProfileFeature $feature Feature class for retrieving profile
   * @return JsonResponse JSON response with profile data
   */
  public function show(string $id, GetCandidateProfileFeature $feature): JsonResponse
  {
    try {
      $profile = $feature->handle($id);

      return response()->json([
        'status' => true,
        'message' => 'Candidate profile retrieved successfully',
        'data' => $profile,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Get current user's candidate profile
   *
   * @param GetMyCandidateProfileFeature $feature Feature class for retrieving user's profile
   * @return JsonResponse JSON response with profile data
   */
  public function me(GetMyCandidateProfileFeature $feature): JsonResponse
  {
    try {
      $profile = $feature->handle();

      return response()->json([
        'status' => true,
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
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }


  /**
   * Update candidate profile (candidate only)
   *
   * @param string $id Candidate profile identifier
   * @param UpdateCandidateProfileRequest $request HTTP request with updated profile details and resume
   * @param UpdateCandidateProfileFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with updated profile
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
        'status' => true,
        'message' => 'Candidate profile updated successfully',
        'data' => $profile,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Delete candidate profile (candidate/admin only)
   *
   * @param string $id Candidate profile identifier
   * @param DeleteCandidateProfileFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with deletion status
   */
  public function destroy(string $id, DeleteCandidateProfileFeature $feature): JsonResponse
  {
    try {
      $feature->handle($id);

      return response()->json([
        'status' => true,
        'message' => 'Candidate profile deleted successfully',
        'data' => [],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }
}
