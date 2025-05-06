<?php

namespace App\Services;

use App\Models\Inspection;
use Illuminate\Support\Facades\DB;

class InspectionService
{
    public function addInspection($data){
        $gambar = [
            'front' => $data['img_front']?? null,
            'left' => $data['img_left']?? null,
            'right' => $data['img_right']?? null,
            'back' => $data['img_back']?? null,
            'add1' => $data['img_add1'] ?? null,
            'add2' => $data['img_add2'] ?? null,
            'fuel' => $data['img_fuel'] ?? null,
        ];

        $names = [];

        foreach ($gambar as $key => $image) {
            if ($image) {
                $destinationPath = 'inspections/';
                $filename = date('Ymd') . '_' . $image->getClientOriginalName();
                $image->move($destinationPath, $filename);
                $names[$key] = 'inspections/' . $filename;
            } else {
                $names[$key] = null; // Handle empty images
            }
        }

        $data['image'] = json_encode($names);

        $inspection = new Inspection();

        $inspection->rental_id = $data['rental_id'];
        $inspection->staff_id = $data['staff_id'];
        $inspection->type = $data['type'];
        $inspection->parts = json_encode($data['parts']);
        $inspection->mileage = $data['mileage'];
        $inspection->fuel = $data['fuel'];
        $inspection->remarks = $data['remarks'];
        $inspection->image = $data['image'];
        $inspection->save();

        return $inspection;
    }

    public function updateInspection($id, $data){
        $inspection = Inspection::findOrFail($id);
        
        // Handle image updates if new images are provided
        if (isset($data['img_front']) || isset($data['img_left']) || isset($data['img_right']) || isset($data['img_back']) || isset($data['img_add1']) || isset($data['img_add2'])) {
            $existingImages = json_decode($inspection->image, true);
            $newImages = [];
            
            $imagesToUpdate = [
                'front' => $data['img_front'] ?? null,
                'left' => $data['img_left'] ?? null,
                'right' => $data['img_right'] ?? null,
                'back' => $data['img_back'] ?? null,
                'add1' => $data['img_add1'] ?? null,
                'add2' => $data['img_add2'] ?? null
            ];

            foreach ($imagesToUpdate as $key => $image) {
                if ($image) {
                    // Delete old image if exists
                    if (isset($existingImages[$key]) && file_exists(public_path($existingImages[$key]))) {
                        unlink(public_path($existingImages[$key]));
                    }
                    
                    // Save new image
                    $destinationPath = 'inspections/';
                    $filename = date('Ymd') . '_' . $image->getClientOriginalName();
                    $image->move($destinationPath, $filename);
                    $newImages[$key] = 'inspections/' . $filename;
                } else {
                    // Keep existing image
                    $newImages[$key] = $existingImages[$key] ?? null;
                }
            }
            
            $data['image'] = json_encode($newImages);
        }

        // Update other fields
        $inspection->staff_id = $data['staff_id'];
        $inspection->type = $data['type'];
        $inspection->parts = json_encode($data['parts']);
        $inspection->mileage = $data['mileage'];
        $inspection->fuel = $data['fuel'];
        $inspection->remarks = $data['remarks'];
        
        // Only update image if new images were processed
        if (isset($data['image'])) {
            $inspection->image = $data['image'];
        }

        $inspection->save();

        return $inspection;
    }

    public function getInspectionById($rentalId, $type){
        $inspection = Inspection::where('rental_id', '=' , $rentalId)
                                ->where('type', '=' , $type)
                                ->first();

        return $inspection;
    }

    public function getPreInspectionById($rentalId){
        $inspection = Inspection::where('rental_id', '=' , $rentalId)
                                ->where('type', '=' , 'pre')
                                ->first();

        return $inspection;
    }

    public function getPostInspectionById($rentalId){
        $inspection = Inspection::where('rental_id', '=' , $rentalId)
                                ->where('type', '=' , 'post')
                                ->first();

        return $inspection;
    }
    
}
