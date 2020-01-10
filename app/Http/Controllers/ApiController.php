<?php

namespace App\Http\Controllers;

use Auth;
use DB;
//use Illuminate\Support\Str;
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

        return Book::where('title', 'LIKE', '%'.$_GET['title'].'%')->where('isDeleted', '=', '0')->get();
    }

    public function detail($id) {
        return $book = Book::findOrFail($id);
    }

    public function getImage($slug) {
        return "http://35.240.132.121/storage/upload/".$slug."";
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

    public function getToken(Request $request) {
        return $request->session()->token();
    }

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

       // $this->validate($request, [
        //    'title' => 'required|unique:books,title,'.Book::find($id)->id.'',
         //   'pages' => 'required|digits_between:2,5',
         //   'price' => 'required',
         //   'total' => 'required|digits_between:2,5',
          //  'company' => 'required',
         //   'file' => 'required',
	    //  ]);
	    
	$content = file_get_contents("php://input");
        $test = str_replace('=', ':', $content);
        $test2 = str_replace('%22', '"', $test);
        $test3 = str_replace('&',',', $test2);
        $test4 = rtrim($test3, ",");
        $test5 = '{ ' . str_replace('&',',', $test4) . ' }';
        $data = json_decode($test5, true);
        Book::findOrFail($id)
        ->fill([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'number_of_page' => $data['pages'],
            'price' => $data['price'],
            'image' => $data['file'],
            'total' => $data['total'],
            'author' => $data['author'],
            'publishing_company' => $data['company'],
            'location_id' => $data['location'],
            'category_id' => $data['category'],
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

    public function test(Request $request) 
    {
            $title = $request->title;
            $pages = $request->pages;
            $price = $request->price;
            $total = $request->total;
            $author = $request->author;
            $image = $request->file;
            $company = $request->company;
            $location = $request->location;
	    $category = $request->category;
	    $headerAuthor = $request->header('Authorization');
	    $headerAcc = $request->header('Accept');
	    $headerCon = $request->header('Content-Type');
            //return view ('test',compact('title', 'pages', 'price', 'total', 'author', 'image', 'company', 'location', 'category', 'headerAuthor', 'headerAcc', 'headerCon'));
//		$content = file_get_contents("php://input");
//	$test = str_replace('=', ':', $content); 
//	$test2 = str_replace('%22', '"', $test);
//	//$test3 = str_replace('&',',', $test2);
//	$test3 = '{ ' . str_replace('&',',', $test2) . ' }';   
//	    $data = json_decode($test, true);
//if (!$content)
  //  echo "Mở file không thành công";
//else {
  //  while (!feof($content)) { // hàm feof sẽ trả về true nếu ở vị trí cuối cùng của file
	   
//	    $test = Str::replaceArray('=', [':'], $content);

  //  }
//}
//	$titletest = $test3;
	$content = file_get_contents("php://input");
        $test = str_replace('=', ':', $content);
        $test2 = str_replace('%22', '"', $test);
	$test3 = str_replace('&',',', $test2);
        $test4 = rtrim($test3, ",");
        $test5 = '{ ' . str_replace('&',',', $test4) . ' }';
        $data = json_decode($test5, true);
	return  $data;
	//return $test3;
		//return $data['title'];
		//$request = Request::instance();

		// Now we can get the content from it
		//$content = $request-$content = file_get_contents("php://input");
                
		//return json_decode($request->getContent());
		//$content = file_get_contents("php://input");
               
    }

    public function store(Request $request)
    {
	$content = file_get_contents("php://input");
        $test = str_replace('=', ':', $content);
        $test2 = str_replace('%22', '"', $test);
        $test3 = str_replace('&',',', $test2);
        $test4 = rtrim($test3, ",");
        $test5 = '{ ' . str_replace('&',',', $test4) . ' }';
        $data = json_decode($test5, true);        
      //  $this->validate($data, [
        //    'title' => 'required|unique:books',
          //  'pages' => 'required|digits_between:2,5',
            //'price' => 'required',
           // 'total' => 'required|digits_between:2,5',
           // 'company' => 'required',
           // 'file' => 'required',
       // ]);
            Book::Create([
                'admin_id' => Auth::user()->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
		'number_of_page' => $data['pages'],
                'price' => $data['price'],
                'total' => $data['total'],
                'author' => $data['author'],
                'image' => $data['file'],
                'publishing_company' => $data['company'],
                'location_id' => $data['location'],
		'category_id' => $data['category'],
		'isDeleted' => 0,
            ]);
          //  for($i = 0 ; $i < $data->total; $i++) {
            //    BookDetail::Create([
              //      'book_id' => Book::orderBy('id', 'desc')->first()->id,
                //    'isAvailable' => 1,
               // ]);
           // }
            return response()
            ->json(['message' => 'Success: You have added an book']);
         
    }

    public function destroy($id)
    {   
        if( BookDetail::where('book_id', $id)->where('isAvailable', 0)->first() )
        {
            return response()
            ->json(['error' => 'This book has already been borrowed']);
        }

	Book::findOrFail($id)
		->fill([
			'isDeleted' => 1
		])
		->save();

        return response()
            ->json(['message' => 'Success: You have delete an book']);
    }
}
