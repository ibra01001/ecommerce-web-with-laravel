<?php
// app/Http/Controllers/Admin/AboutUsAdminController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsAdminController extends Controller
{
    /**
     * Show the form for editing the about us page
     */
    public function edit()
    {
        $aboutUs = AboutUs::first();
        
        // If no record exists, create a default one
        if (!$aboutUs) {
            $aboutUs = new AboutUs([
                'title' => '',
                'subtitle' => '',
                'content' => '',
                'is_active' => true
            ]);
        }
        
        return view('admin.about-us.edit', compact('aboutUs'));
    }

    /**
     * Update the about us page in storage
     */
    public function update(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'mission_title' => 'nullable|string|max:255',
            'mission_content' => 'nullable|string',
            'vision_title' => 'nullable|string|max:255',
            'vision_content' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'team_members.*.name' => 'nullable|string|max:255',
            'team_members.*.position' => 'nullable|string|max:255',
            'team_members.*.bio' => 'nullable|string|max:500',
            'team_members.*.photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
        ]);

        // Get or create the about us record
        $aboutUs = AboutUs::first();
        if (!$aboutUs) {
            $aboutUs = new AboutUs();
        }

        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($aboutUs->image && Storage::disk('public')->exists($aboutUs->image)) {
                Storage::disk('public')->delete($aboutUs->image);
            }
            // Store new image
            $imagePath = $request->file('image')->store('about-us', 'public');
            $validated['image'] = $imagePath;
        }

        // Handle team members with photos
        if ($request->has('team_members')) {
            $teamMembers = [];
            $existingMembers = $aboutUs->team_members ?? [];
            
            foreach ($request->team_members as $index => $member) {
                // Only add if at least name is provided
                if (!empty($member['name'])) {
                    $memberData = [
                        'name' => $member['name'] ?? '',
                        'position' => $member['position'] ?? '',
                        'bio' => $member['bio'] ?? '',
                        'photo' => null,
                    ];

                    // Check if this member already exists and has a photo
                    if (isset($existingMembers[$index]['photo'])) {
                        $memberData['photo'] = $existingMembers[$index]['photo'];
                    }

                    // Handle new photo upload for this member
                    // Check using both array access and hasFile method
                    if ($request->hasFile("team_members.{$index}.photo")) {
                        // Delete old photo if exists
                        if (!empty($memberData['photo']) && Storage::disk('public')->exists($memberData['photo'])) {
                            Storage::disk('public')->delete($memberData['photo']);
                        }
                        
                        // Store new photo
                        $photoFile = $request->file("team_members.{$index}.photo");
                        $photoPath = $photoFile->store('about-us/team', 'public');
                        $memberData['photo'] = $photoPath;
                    }
                    // Also check if photo exists in the files array directly
                    elseif ($request->hasFile('team_members') && 
                            isset($request->file('team_members')[$index]['photo'])) {
                        // Delete old photo if exists
                        if (!empty($memberData['photo']) && Storage::disk('public')->exists($memberData['photo'])) {
                            Storage::disk('public')->delete($memberData['photo']);
                        }
                        
                        // Store new photo using alternative method
                        $photoFile = $request->file('team_members')[$index]['photo'];
                        $photoPath = $photoFile->store('about-us/team', 'public');
                        $memberData['photo'] = $photoPath;
                    }

                    $teamMembers[] = $memberData;
                }
            }
            
            $validated['team_members'] = !empty($teamMembers) ? $teamMembers : null;
        }

        // Handle is_active checkbox
        $validated['is_active'] = $request->has('is_active') ? true : false;

        // Update the record
        $aboutUs->fill($validated);
        $aboutUs->save();

        return redirect()
            ->route('admin.about-us.edit')
            ->with('success', 'About Us page updated successfully!');
    }
}