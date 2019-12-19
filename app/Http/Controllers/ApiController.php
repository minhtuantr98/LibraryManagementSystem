<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Carbon\Carbon;
use Validator;
use App\User;
use App\Book;
use App\BookDetail;
use App\Location;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function index()
    {   
        if(!isset($_GET['title'])) {
            $_GET['title'] ='';
        }

        return Book::where('title', 'LIKE', '%'.$_GET['title'].'%')->get();
    }

    public function detail($id) {
        return $book = Book::findOrFail($id);
    }

    public function getImage($slug) {
        return view('API.image', compact('slug'));
    }
     /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = auth()->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString() ,
            'name' => auth()->user()->name,
        ]);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function edit($id)
    {
        $categories = Category::all();
        $location = Location::all();
        $book = Book::findOrFail($id);

        return array('location' => $location, 'categories' => $categories, 'book' => $book);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|unique:books,title,'.Book::find($id)->id.'',
            'pages' => 'required|digits_between:2,5',
            'price' => 'required',
            'total' => 'required|digits_between:2,5',
            'company' => 'required',
            'file' => 'required',
        ]);
        Book::findOrFail($id)
        ->fill([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'number_of_page' => $request->pages,
            'price' => $request->price,
            'image' => $request->file,
            'total' => $request->total,
            'author' => $request->author,
            'publishing_company' => $request->company,
            'location_id' => $request->location,
            'category_id' => $request->category,
        ])
        ->save();

        return response()
        ->json(['message' => 'Success: You have edit an book']);
    }

    public function create()
    {
        $location = Location::all();
        $categories = Category::all();

        return array('location' => $location, 'categories' => $categories);
    }

    public function store(Request $request)
    {        
        $this->validate($request, [
            'title' => 'required|unique:books',
            'pages' => 'required|digits_between:2,5',
            'price' => 'required',
            'total' => 'required|digits_between:2,5',
            'company' => 'required',
            'file' => 'required',
        ]);
        
            Book::Create([
                'admin_id' => Auth::user()->id,
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'number_of_page' => $request->pages,
                'price' => $request->price,
                'total' => $request->total,
                'author' => $request->author,
                'image' => $request->file,
                'publishing_company' => $request->company,
                'location_id' => $request->location,
                'category_id' => $request->category,
            ]);
            for($i = 0 ; $i < $request->total; $i++) {
                BookDetail::Create([
                    'book_id' => Book::orderBy('id', 'desc')->first()->id,
                    'isAvailable' => 1,
                ]);
            }
            return response()
            ->json(['message' => 'Success: You have added an book']);
         
    }

    public function destroy($id)
    {
        Book::where('id', $id)->firstOrFail()->delete();

        return response()
            ->json(['message' => 'Success: You have delete an book']);
    }
}
