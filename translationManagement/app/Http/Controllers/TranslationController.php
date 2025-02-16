<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTranslationRequest;
use App\Http\Requests\UpdateTranslationRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TranslationController extends Controller
{


    public function list(Request $request): JsonResponse
    {
        $status = 400;
        $response = ['error' => 'true', 'message' => 'Invalid request'];
        $translations = Translation::getAndSearchAllTranslations($request);

        if ($translations) {
            foreach ($translations as $translation) {
                $groupTranslation[$translation->locale][] = [
                    'id' => $translation->id,
                    'key' => $translation->key,
                    'content' => $translation->content,
                    'tags' => $translation->tags->pluck('name')
                ];
            };
            $status = 200;
            $response = [
                'data' => @$groupTranslation,
                'message' => 'Translations fetched successfully',

                'pagination' => [
                    'current_page' => @$translations->currentPage(),
                    'per_page' => @$translations->perPage(),
                    'total' => @$translations->total(),
                ]
            ];
        }

        return response()->json($response, $status);
    }

    public function create(StoreTranslationRequest $request): JsonResponse
    {
        $staus = 400;
        $response = ['error' => 'true', 'message' => 'Invalid request'];
        $validatedData = $request->validated();
        if ($validatedData) {
            $translation = Translation::create($validatedData);
            $staus = 201;
            $response = ['error' => 'false', 'message' => 'Translation created successfully', 'data' => $translation];
            return response()->json($response, $staus);
        }
    }

    public function update(UpdateTranslationRequest $request, $id): JsonResponse
    {
        $staus = 400;
        $response = ['error' => 'true', 'message' => 'Invalid request'];
        $validatedData = $request->validated();
        $translation = Translation::findOrFail($id);
        $translation->update($validatedData);
        if ($translation) {
            $staus = 200;
            $response = ['error' => 'false', 'message' => 'Translation updated successfully', 'data' => $translation];
        }
        return response()->json($response, $staus);
    }

    public function export(Request $request)
    {
        $status = 400;
        $response = ['error' => 'true', 'message' => 'Invalid request'];
        $translations = Translation::getAndSearchAllTranslations($request);
        if ($translations->count() > 0) {
            $status = 200;
            foreach ($translations as $translation) {
                $groupTranslation[$translation->locale][] = [
                    'id' => @$translation->id,
                    'key' => @$translation->key,
                    'content' => @$translation->content,
                    'tags' => @$translation->tags->pluck('name')
                ];
            };
            $data = json_encode($groupTranslation);
            $exportPath = storage_path('app/public/exports/');
            if (!File::exists($exportPath)) {
                File::makeDirectory($exportPath, 0777, true, true);
            }

            $filename = 'translations_' . now()->format('Y-m-d') . '.json';
            $filePath = $exportPath . $filename;

            file_put_contents($filePath, $data);

            return response()->download($filePath, $filename, [
                'Content-Type' => 'application/json',
            ])->deleteFileAfterSend(true);
        } else {
            return response()->json($response, $status);
        }
    }
}
