<?php

namespace App\Http\Controllers;

use App\Constants\GlobalConstants;
use App\Models\Announcement;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Order;
use App\Models\Size;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DateTime;


class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $announcements = Announcement::getAnnouncements(GlobalConstants::ALL,GlobalConstants::ALL,GlobalConstants::ALL);
        $users = User::all();

        return view('announcements/announcements')
            ->with('announcements',$announcements)
            ->with('users',$users);
    }
    public function getMoreAnnouncements(Request $request)
    {
        $product = $request->product;
        $brand = $request->brand;
        $size = $request->size;
        if($request->ajax()){
            $announcements = Announcement::getAnnouncements($product,$brand,$size);
            return view('announcements/includes/announcement_data',compact('announcements','brand','size'))->render();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $announcement = Announcement::create([
            'user_id' => Auth::id(),
            'cover' =>'null',
            'title' => 'null',
            'description' => 'null',
            'product' => 'null',
            'brand' => 'null',
            'size' => 'null',
            'price'=>'null',
            'city'=>'null',
            'status'=>'0'
        ]);
        $id = Announcement::max('id');
        return view('announcements.create')
            ->with('announcement_id',$id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $validated = $request->validate([
//            'title' => 'required|min:5|max:30'
//            ]);
        $announcement = Announcement::findOrFail($request->input('announcement_id'));


            if ($request->has('cover')) {
                if ($announcement->cover != 'default.jpg') {
                    if (file_exists('covers/' . $announcement->cover)) {
                        unlink('covers/' . $announcement->cover);
                    }
                }
                $file = $request->file('cover');
                $announcement->cover = time() . rand(1, 1000) . '-image-' . time() . rand(1, 1000) . '.' . $file->extension();
                $file->move('covers', $announcement->cover);
                $request['cover'] = $announcement->cover;
            }

            $announcement->update([
                'user_id' => Auth::id(),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'cover' => $announcement->cover,
                'product' => $request->input('product'),
                'brand' => $request->input('brand'),
                'size' => $request->input('size'),
                'price' => $request->input('price'),
                'city'=>$request->input('city'),
                'status'=>1,
            ]);

            return redirect('/announcements')
                ->with('message', 'Announcement has been created successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $announcement = Announcement::find($id);
        $comment = Comment::all()->where('announcement_id',$id);
        $images = Image::all()->where('announcement_id',$id);

        $dateObj = DateTime::createFromFormat('!m', $announcement->user->created_at->format('m'));
        $monthName = $dateObj->format('F');

        $count = Announcement::all()
            ->where('user_id',$announcement->user_id)
            ->where('status',1)
            ->count();

        return view('announcements.show')
            ->with('announcement',$announcement)
            ->with('comments',$comment)
            ->with('images',$images)
            ->with('count',$count)
            ->with('monthName',$monthName);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $announcement = Announcement::find($id);
        if(Auth::id() == $announcement->user_id)
        {
            $images = Image::all()->where('announcement_id',$announcement->id);
            return view('announcements/edit', compact('announcement','images',));
        }
        else
            abort(404);


    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $announcement = Announcement::findOrFail($id);

        if(Auth::id() == $announcement->user_id) {
            if ($request->has('cover')) {
                if ($announcement->cover != 'default.jpg') {
                    if (file_exists('covers/' . $announcement->cover)) {
                        unlink('covers/' . $announcement->cover);
                    }
                }
                $file = $request->file('cover');
                $announcement->cover = time() . rand(1, 1000) . '-image-' . time() . rand(1, 1000) . '.' . $file->extension();
                $file->move('covers', $announcement->cover);
                $request['cover'] = $announcement->cover;
            }

            $announcement->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'cover' => $announcement->cover,
                'product' => $request->input('product'),
                'brand' => $request->input('brand'),
                'size' => $request->input('size'),
            ]);

            return redirect()->back()->with('message', 'Announcement has been updated successfully!');
        }
        else
            abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        //DELETE FROM reservations WHERE id
        $announcement = Announcement::findOrFail($id);
        if(Auth::user()->id == $announcement->user_id) {
            if (file_exists('covers/' . $announcement->cover)) {
                unlink('covers/' . $announcement->cover);
            }
            $images = Image::where("announcement_id", $announcement->id)->get();
            foreach ($images as $image) {
                if (file_exists('announcement_images/' . $image->image)) {
                    unlink('announcement_images/' . $image->image);
                }
            }
            $announcement->delete();
            return redirect()->back()->with('message', 'Announcement has been deleted successfully!');
        }
        else
            abort(404);
    }

    public function deleteImage($id)
    {
        $image = Image::findOrFail($id);
        if(file_exists('announcement_images/'.$image->image)){
            unlink('announcement_images/'.$image->image);
        }
        Image::find($id)->delete();
        return back();
    }
    public function deleteCover($id)
    {

        $cover = Announcement::findOrFail($id)->cover;
        if($cover != 'default.jpg'){
            if(file_exists('covers/'.$cover)){
                unlink('covers/'.$cover);
            }
        }
        Announcement::find($id)->update([
            'cover'=>'default.jpg'
        ]);
        return back();
    }

    public function manageAnnouncements()
    {
        $announcements = Announcement::all()->where('user_id',Auth::id())->where('status',1);
        return view('announcements.manageAnnouncements')
            ->with('announcements',$announcements);
    }

}
