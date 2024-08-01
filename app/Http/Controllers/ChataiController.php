<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use App\Repositories\ChataiRepositoryInterface;

class ChataiController extends Controller
{
    public function __construct(public ChataiRepositoryInterface $chataiRepositoryInterface) {
        //
    }
    
    public function home(Request $request) {
        $data = session()->get('data', null);

        return Inertia::render('Chatai/Home', ['data' => $data]);
    }

    public function store(Request $request) {
        $gemini_api_url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent";

        $user_message = $request->message;
        $model_message = Storage::disk('public')->get('chatai/SYSTEM_MESSAGE.md');

        $gemini_api_key = config('services.gemini.api_key');

        $data = [
            "contents" => [
                [
                    "role" => "model",
                    "parts" => [
                        [
                            "text" => $model_message
                        ]
                    ]
                ],
                [
                    "role" => "user",
                    "parts" => [
                        [
                            "text" => $user_message
                        ]
                    ]
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Accept' => "application/json", 
        ])
        ->post("$gemini_api_url?key=$gemini_api_key", $data);

        $data = $response->json();

        $filePath = base_path('app/Repositories/ChataiRepository.php');

        $content = $data['candidates'][0]['content']['parts'][0]['text'];

        $default_content = '<?php

        namespace App\Repositories;
        
        class ChataiRepository implements ChataiRepositoryInterface
        {
            /**
             * Find all users.
             *
             * @return mixed
             */
            public function process()
            {
                //
            }
        }';

        file_put_contents($filePath, $default_content);

        if (preg_match('/```php(.*?)```/s', $content, $matches)) {
            $content = trim($matches[1]);
        } else {
            throw new Exception("Invalid data");
        }

        file_put_contents($filePath, $content);

        $data = $this->chataiRepositoryInterface->process();

        return redirect()->route('chatai.home')->with([
            'data' => $data,
        ]);
    }
}
