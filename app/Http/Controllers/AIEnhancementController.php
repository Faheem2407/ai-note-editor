<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIEnhancementController extends Controller
{
	public function summarize(Request $request)
	{
		$request->validate([
			'content' => 'required|string',
		]);

		try {
			$model = env('OPENAI_API_MODEL', 'gpt-4.1-nano');

			$response = Http::withToken(config('services.openai.key'))
				->timeout(20)
				->post('https://api.openai.com/v1/chat/completions', [
					'model' => $model,
					'messages' => [
						['role' => 'system', 'content' => 'You are a helpful assistant that summarizes notes.'],
						['role' => 'user', 'content' => "Summarize this note:\n" . $request->input('content')],
					],
					'temperature' => 0.5,
				]);

			if ($response->failed()) {
				$error = $response->json()['error']['message'] ?? 'Unknown error from OpenAI.';
				\Log::error('OpenAI error: ' . $error);
				return response()->json(['error' => $error], 500);
			}

			$data = $response->json();
			$summary = $data['choices'][0]['message']['content'] ?? null;

			return response()->json([
				'summary' => $summary ?? 'No summary returned.',
			]);
		} catch (\Throwable $e) {
			\Log::error('Exception during summarization: ' . $e->getMessage());
			return response()->json(['error' => 'Exception: ' . $e->getMessage()], 500);
		}
	}

}
