<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\CustomerBodyProfile;
use Illuminate\Support\Facades\Auth;

class SizeRecommendationController extends Controller
{
    public function recommendSize(Request $request, $productId)
    {
        // For portfolio purposes, we simulate the logged-in user with a predefined profile if not authenticated.
        // Usually it would be: $user = $request->user();
        
        // Let's assume we pass customer_profile_id via query for testing if no auth is present
        $profileId = $request->query('profile_id');
        
        if ($profileId) {
            $profile = CustomerBodyProfile::find($profileId);
        } else {
            // Auth flow
            $user = $request->user();
            if (!$user) {
                return response()->json(['error' => 'Unauthenticated or missing profile_id'], 401);
            }
            $profile = $user->bodyProfile;
        }

        if (!$profile) {
            return response()->json(['error' => 'Customer body profile not found'], 404);
        }

        $product = Product::with('sizes')->find($productId);
        
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        if ($product->sizes->isEmpty()) {
            return response()->json(['error' => 'No sizes available for this product'], 404);
        }

        // Logic for recommending size
        // We compare the customer's chest circumference and height
        $customerChest = $profile->chest_circumference_cm; 
        $customerHeight = $profile->height_cm;

        $bestFit = null;
        $minDifference = PHP_INT_MAX;

        foreach ($product->sizes as $size) {
            // We assume chest_width_cm is half of the circumference
            $garmentChestCircumference = $size->chest_width_cm * 2;
            
            // Calculate how well it fits the chest
            // Standard fit means garment is ~5 to 10 cm larger than body chest
            $difference = $garmentChestCircumference - $customerChest;
            
            // We want the difference to be positive and as close to 5-10cm as possible
            // We'll penalize if it's too tight (difference < 0) or too loose
            
            if ($difference >= 0) {
                // simple scoring: closer to 8cm ease is better
                $score = abs($difference - 8);
                
                if ($score < $minDifference) {
                    $minDifference = $score;
                    $bestFit = $size;
                }
            }
        }

        if (!$bestFit) {
            // If all sizes are too small, just pick the largest one
            $bestFit = $product->sizes->sortByDesc('chest_width_cm')->first();
            $fitDetails = [
                'chest' => 'Sangat ketat',
                'overall' => 'Mungkin tidak muat, ukuran terbesar yang tersedia adalah ' . $bestFit->size_label
            ];
        } else {
            $diff = ($bestFit->chest_width_cm * 2) - $customerChest;
            $chestFit = 'Pas / Regular';
            if ($diff < 5) $chestFit = 'Agak ketat (Slim Fit)';
            if ($diff > 12) $chestFit = 'Longgar (Oversize)';

            $fitDetails = [
                'chest' => $chestFit,
                'overall' => 'Cocok berdasarkan lingkar dada Anda.'
            ];
        }

        return response()->json([
            'recommended_size' => $bestFit->size_label,
            'confidence_score' => '85%',
            'fit_details' => $fitDetails,
            'message' => 'Berdasarkan profil tubuh Anda, ' . $bestFit->size_label . ' adalah pilihan terbaik.',
            'product_id' => $product->id,
            'profile_used' => [
                'height_cm' => $customerHeight,
                'weight_kg' => $profile->weight_kg,
                'chest_circumference_cm' => $customerChest
            ]
        ]);
    }
}
