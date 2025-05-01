<?php

namespace App\Http\Controllers;

use App\Models\HousingPhoto;
use App\Models\HousingPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HousingPhotoController extends Controller
{
    /**
     * Upload additional photos to an existing housing post
     */
    public function upload(Request $request, $housingPostId)
    {
        $post = HousingPost::findOrFail($housingPostId);
        
        // Check if current user owns this post
        if ($post->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'You cannot add photos to someone else\'s housing post.');
        }
        
        $request->validate([
            'photos' => 'required|array|max:10',
            'photos.*' => 'image|max:5120', // 5MB per image
        ]);
        
        // Count existing photos
        $existingCount = $post->photos()->count();
        $newPhotos = count($request->file('photos'));
        
        if ($existingCount + $newPhotos > 10) {
            return back()->with('error', 'Maximum 10 photos allowed per listing. You can upload ' . (10 - $existingCount) . ' more photos.');
        }
        
        // Handle photo uploads
        if ($request->hasFile('photos')) {
            $this->handlePhotoUploads($request->file('photos'), $post);
        }
        
        return redirect()->route('housing.edit', $post->id)
            ->with('success', 'Photos uploaded successfully.');
    }
    
    /**
     * Set a photo as the primary photo for the housing post
     */
    public function setPrimary($photoId)
    {
        $photo = HousingPhoto::findOrFail($photoId);
        
        // Check if current user owns this post
        if ($photo->housingPost->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'You cannot modify someone else\'s housing post.');
        }
        
        $photo->setPrimary();
        
        return redirect()->back()->with('success', 'Primary photo updated successfully.');
    }
    
    /**
     * Delete a photo
     */
    public function destroy($photoId)
    {
        $photo = HousingPhoto::findOrFail($photoId);
        
        // Check if current user owns this post
        if ($photo->housingPost->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'You cannot delete photos from someone else\'s housing post.');
        }
        
        $housingPostId = $photo->housing_post_id;
        
        // Delete the photo (the model boot method will handle deleting the file)
        $photo->delete();
        
        return redirect()->route('housing.edit', $housingPostId)
            ->with('success', 'Photo deleted successfully.');
    }
    
    /**
     * Handle uploading and storing photos for housing posts
     */
    private function handlePhotoUploads($files, $housingPost)
    {
        // Get the highest current sort order
        $maxOrder = $housingPost->photos()->max('sort_order') ?? -1;
        $counter = $maxOrder + 1;
        $hasPrimary = $housingPost->photos()->where('is_primary', true)->exists();
        
        foreach ($files as $file) {
            // Generate unique filename
            $filename = uniqid('housing_') . '.' . $file->getClientOriginalExtension();
            
            // Store file in storage
            $path = $file->storeAs(
                'housing_photos/' . $housingPost->id,
                $filename,
                'public'
            );
            
            // Create photo record
            $photo = new HousingPhoto([
                'housing_post_id' => $housingPost->id,
                'file_path' => 'public/' . $path,
                'file_name' => $file->getClientOriginalName(),
                'caption' => null,
                'is_primary' => (!$hasPrimary && $counter === 0), // First photo is primary if no primary exists
                'sort_order' => $counter,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
            
            $photo->save();
            
            // If this is the first photo and there's no primary, make it primary
            if (!$hasPrimary && $counter === 0) {
                $hasPrimary = true;
            }
            
            $counter++;
        }
    }
}
