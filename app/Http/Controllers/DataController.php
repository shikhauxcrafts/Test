<?php

namespace App\Http\Controllers;
use App\Models\Title;
use App\Models\Subtitle;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\ImageConversionService;
use Illuminate\Validation\ValidationException;


class DataController extends Controller
{
    public function get_title($id)
    {
        $titles = Title::with('subtitles')->where('id', $id)->get(); // Fetch titles from the database
        // dd($titles);
        return Inertia::render('Test', [
            'titles' => $titles // Pass the data as props to the Inertia component
        ]);

        // return Title::get();
        
    }

    public function store_subtitle(Request $request)
    {
        $data = request()->validate([
            'title_id' => 'required|string|max:50',
            'subtitle' => 'required|string|max:50',
            'content' => 'required|string|max:50',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:10240',
        ]);
        // dd($data);
        $imageFile = request()->file('image');

        if($imageFile->isValid()) {
            $subtitle = new Subtitle();
            $subtitle->title_id = $data['title_id'];
            $subtitle->subtitle = $data['subtitle'];
            $subtitle->content = $data['content'];
            try {
                $subtitle->image = (new ImageConversionService())->convertToWebp($imageFile, 'public/subtitle');
                $subtitle->save();
                return redirect()->back()->banner('Subtitle added successfully.');
            } catch (\Exception $e) {
                throw ValidationException::withMessages([
                    'image' => 'Failed to save the uploaded file.'
                ]);
            }

        } else {
            throw ValidationException::withMessages([
                'image' => 'The uploaded file is not a valid image file.'
            ]);
        }
       
    }

   public function get_subtitles()
    {
       $data = Subtitle::all();
       return Inertia::render('Welcome', [
         'data' => $data
       ]);
    }
}
