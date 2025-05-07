<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\StressLog;
use App\Models\MotivationalMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
 
class StressDetectionController extends Controller
{
    // Window size for temporal aggregation (minutes)
    const STRESS_WINDOW = 20;
   
    // Ollama API configuration 
    const OLLAMA_API_URL = 'http://172.20.10.2:11434/api/generate';
    const OLLAMA_MODEL = 'deepseek-r1:1.5b'; 
   
    public function detectStress(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'heart_rate' => 'required|numeric|min:30|max:250',
            'hrv' => 'nullable|numeric|min:10|max:200',
            'is_exercising' => 'required|boolean',
            'timestamp' => 'required|date',
        ]);
       
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
       
        $data = $validator->validated();
       
        // Get user's age from profile if available
        $user = \App\Models\User::with('profile')->find($data['user_id']);
        $userAge = null;
       
        if ($user && $user->profile && $user->profile->dateOfBirth) {
            $userAge = Carbon::parse($user->profile->dateOfBirth)->age;
        }
       
        // Calculate stress score using default values
        $stressScore = $this->calculateStressScore(
            $data['heart_rate'],
            $data['hrv'] ?? null,
            $data['is_exercising'],
            $userAge
        );
       
        // Use default stress threshold of 0.5
        $isStressed = $stressScore > 0.5;
       
        $stressLog = StressLog::create([
            'user_id' => $data['user_id'],
            'heart_rate' => $data['heart_rate'],
            'hrv' => $data['hrv'] ? (int)$data['hrv'] : null,
            'is_exercising' => $data['is_exercising'],
            'is_stressed' => $isStressed,
            'stress_score' => $stressScore,
            'hour_of_day' => Carbon::parse($data['timestamp'])->hour,
          
        ]);
       
        // Generate message
        $message = $this->generateMotivationalMessage(
            $data['user_id'],
            $stressScore,
            $isStressed,
            $data['heart_rate'],
            $data['hrv'] ?? null,
            $data['is_exercising']
        );
       
        return response()->json([
            'status' => 'success',
            'is_stressed' => $isStressed,
            'stress_score' => round($stressScore, 2),
            'heart_rate' => $data['heart_rate'],
            'hrv' => $data['hrv'] ? (int)$data['hrv'] : null,
            'log_id' => $stressLog->id,
            'timestamp' => now()->toDateTimeString(),
            'motivational_message' => $message,
        ]);
    }
   
   
   
    protected function generateMotivationalMessage(
        int $userId,
        float $stressScore,
        bool $isStressed,
        float $heartRate = null,
        float $hrv = null,
        bool $isExercising = false
    ): array {
        try {
            // First get some user context
            $user = \App\Models\User::find($userId);
           
            // Determine time of day
            $hour = now()->hour;
            $timeOfDay = 'day';
            if ($hour >= 5 && $hour < 12) $timeOfDay = 'morning';
            elseif ($hour >= 12 && $hour < 17) $timeOfDay = 'afternoon';
            elseif ($hour >= 17 && $hour < 22) $timeOfDay = 'evening';
            else $timeOfDay = 'night';
           
            // Skip trying to use Ollama and just use our own well-crafted messages
            // Create arrays of appropriate messages for different situations
           
            // HIGH STRESS MESSAGES (stress score > 0.7)
            $highStressMessages = [
                // Physical relaxation
                "Take a deep breath in for 4 counts, hold for 2, then exhale for 6. Repeat three times.",
                "Place your hand on your heart and take five slow breaths. Feel your body start to calm.",
                "Roll your shoulders back slowly three times. Release the tension you're holding.",
               
                // Mental relief
                "This moment of intensity will pass. Focus on just the next five minutes.",
                "Name five things you can see right now. This simple practice helps center your mind.",
                "Your feelings are valid. Give yourself permission to step back for a moment.",
               
                // Action-oriented
                "Step outside for three minutes of fresh air. A change of environment can reset your system.",
                "Splash cold water on your face or wrists. Temperature change can help break the stress cycle.",
                "Try the 5-4-3-2-1 technique: notice 5 things you see, 4 you feel, 3 you hear, 2 you smell, 1 you taste."
            ];
           
            // MODERATE STRESS MESSAGES (stress score 0.5-0.7)
            $moderateStressMessages = [
                "Check in with your breathing. Is it shallow? Take a moment for three deeper breaths.",
                "Place both feet firmly on the ground and feel your connection to the earth.",
                "Roll your neck gently from side to side. Physical movement can help release mental tension.",
                "What's one small thing you can control right now? Focus your energy there.",
                "Try writing down what's on your mind for two minutes. Getting thoughts out can create space.",
                "How would you support a friend feeling this way? Offer that same kindness to yourself."
            ];
           
            // LOW STRESS / POSITIVE MESSAGES (stress score < 0.5)
            $positiveMessages = [
                "You're doing well today. Notice what's working and carry it forward.",
                "Your balance today is something to celebrate. What's helping you stay centered?",
                "This steady energy you have is valuable. How might you build on it?",
                "Take a moment to appreciate how your body is supporting you right now.",
                "You've created some peace for yourself today. That's an achievement worth noticing.",
                "This current calm is something you've helped create. Well done."
            ];
           
            // MORNING-SPECIFIC MESSAGES
            $morningMessages = [
                "Morning light brings new possibilities. What's one small positive choice you can make today?",
                "Set an intention for today in just one word. Let it guide your next few hours.",
                "Your morning energy sets the tone. Take a moment to center yourself before the day unfolds."
            ];
           
            // EVENING-SPECIFIC MESSAGES
            $eveningMessages = [
                "The day is winding down. Let your shoulders drop and your breath deepen.",
                "Evening is a time to begin letting go. What can you release from today?",
                "As the day closes, give yourself permission to transition to rest mode."
            ];
           
            // NIGHT-SPECIFIC MESSAGES
            $nightMessages = [
                "Night brings the gift of rest. Prepare your mind by letting go of the day's events.",
                "Darkness outside is a reminder to slow down. Your body and mind need recovery time.",
                "Close the chapter on today. Tomorrow brings fresh perspective and new opportunities."
            ];
 
            // EXERCISE-RELATED MESSAGES
            $exerciseMessages = [
                "Your body is working hard. Notice your strength and resilience in motion.",
                "Each movement is an investment in your wellbeing. Honor where you are today.",
                "Listen to what your body needs - intensity or rest. Both are valuable paths."
            ];
           
            // Select appropriate message pool based on stress level
            $messagePool = $positiveMessages; // Default
           
            if ($stressScore > 0.7) {
                $messagePool = $highStressMessages;
            } elseif ($stressScore > 0.5) {
                $messagePool = $moderateStressMessages;
            }
           
            // Add time-specific messages to the pool
            if ($timeOfDay == 'morning') {
                $messagePool = array_merge($messagePool, $morningMessages);
            } elseif ($timeOfDay == 'evening') {
                $messagePool = array_merge($messagePool, $eveningMessages);
            } elseif ($timeOfDay == 'night') {
                $messagePool = array_merge($messagePool, $nightMessages);
            }
           
            // Add exercise messages if applicable
            if ($isExercising) {
                $messagePool = array_merge($messagePool, $exerciseMessages);
            }
           
            // Select random message from the appropriate pool
            $message = $messagePool[array_rand($messagePool)];
           
            // Log what we're doing
            \Log::info("Using predefined message: " . $message);
           
            // Save the message
            $motivationalMessage = MotivationalMessage::create([
                'user_id' => $userId,
                'message' => $message,
                'is_for_stress' => $isStressed,
                'stress_score' => $stressScore,
                'time_of_day' => $timeOfDay,
            ]);
           
            return [
                'id' => $motivationalMessage->id,
                'message' => $message,
                'title' => $isStressed ? 'Take a moment' : 'Keep it up!',
            ];
           
        } catch (\Exception $e) {
            \Log::error('Error in motivational message generation: ' . $e->getMessage());
            return $this->getFallbackMessage($isStressed);
        }
    }
   
    protected function getFallbackMessage(bool $isStressed): array
    {
        if ($isStressed) {
            $fallbacks = [
                "Take a moment to breathe deeply. Small pauses can create big shifts in how you feel.",
                "Your feelings are valid. Consider stepping outside for a moment to reset.",
                "Stress is a signal, not a sentence. Maybe it's time for a short break?",
                "Remember to be as kind to yourself as you would be to a friend going through the same thing.",
                "This moment is challenging, but it will pass. What's one small thing you can do for yourself right now?"
            ];
            $title = "Take a moment";
        } else {
            $fallbacks = [
                "You're doing well today. Consider taking a moment to appreciate your progress.",
                "Small wins add up. What's one thing you're proud of right now?",
                "Momentum is on your side today. How might you build on this positive energy?",
                "Your wellbeing matters. What's one small thing you could do to nurture yourself further today?",
                "You've got this. Remember that consistency beats intensity in the long run."
            ];
            $title = "Keep it up!";
        }
       
        $message = $fallbacks[array_rand($fallbacks)];
       
        return [
            'id' => null,
            'message' => $message,
            'title' => $title,
        ];
    }
   
    
    protected function calculateStressScore(
        float $heartRate,
        ?float $hrv,
        bool $isExercising,
        ?int $userAge = null
    ): float {
        // Set default thresholds based on scientific values from your table
        $hrMin = 60;    // Resting Heart Rate Min
        $hrMax = $isExercising
            ? (208 - (0.7 * ($userAge ?? 35)))  // Exercising Heart Rate Max formula
            : 90;                               // Resting Heart Rate Max
       
        $hrvMin = 50;   // HRV Minimum
        $hrvMax = 100;  // HRV Maximum
       
        // Time-of-day adjustments
        $hour = now()->hour;
        $isNighttime = $hour < 6 || $hour > 22;
        if ($isNighttime) {
            $hrvMin *= 0.8; // Expect lower HRV at night
            $hrMax *= 0.9;  // Expect lower HR at night
        }
       
        // Normalize values (0-1 range)
        $hrNorm = min(max(($heartRate - $hrMin) / ($hrMax - $hrMin), 0), 1);
        $hrvNorm = $hrv !== null
            ? 1 - min(max(($hrv - $hrvMin) / ($hrvMax - $hrvMin), 0), 1)
            : 0.5;
       
        // Dynamic weights based on data availability
        $hrWeight = $hrv === null ? 0.7 : 0.6;
        $hrvWeight = 1 - $hrWeight;
       
        return ($hrNorm * $hrWeight) + ($hrvNorm * $hrvWeight);
    }
   
    protected function shouldSendMotivationalMessage(int $userId): bool
    {
        // Find the most recent motivational message for this user
        $lastMessage = MotivationalMessage::where('user_id', $userId)
            ->latest()
            ->first();
           
        if (!$lastMessage) {
            return true; // First message for this user
        }
       
        // Check if it's been at least 2 hours since the last message
        return $lastMessage->created_at->diffInHours(now()) >= 2;
    }
}
 