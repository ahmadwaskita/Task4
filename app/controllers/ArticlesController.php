<?php

class ArticlesController extends \BaseController {

	/*
	public function __construct(){
		$this->beforeFilter('auth');
	}*/
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//create pagination for every 10 articles
		$articles = Article::paginate(10);

		if(Request::ajax()){
			return Response::json(View::make('articles.list', array('articles' =>$articles))->render());
		}

		return View::make('articles.index', compact('articles'))->with('articles', $articles);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make('articles.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$validate = Validator::make(Input::all(), Article::valid());
		if($validate->fails()){
			return Redirect::to('articles/create')
				->withErrors($validate)
				->withInput();
		} else {
			$article = new Article;
			$article->title = Input::get('title');
			$article->content = Input::get('content');
			$article->author = Input::get('author');
			$article->save();
			Session::flash('notice', 'Success add article');
			return Redirect::to('articles');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		$article = Article::find($id);
		$comments = Article::find($id)->comments->sortBy('Comment.created_at');
		return View::make('articles.show')
			->with('article', $article)
			->with('comments', $comments);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$article = Article::find($id);
		return View::make('articles.edit')
			->with('article', $article);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$validate = Validator::make(Input::all(), Article::valid($id));
		if($validate->fails()){
			return Redirect::to('articles/'.$id.'/edit')
			->withErrors($validate)
			->withInput();
		} else {
			$article = Article::find($id);
			$article->title = Input::get('title');
			$article->content = Input::get('content');
			$article->author = Input::get('author');
			$article->save();
			Session::flash('notice', 'Success update article');
			return Redirect::to('articles');
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$article = Article::find($id);
		$article->delete();
		Session::flash('notice','Article success delete');
		return Redirect::to('articles');
	}
        
    //create method to export article
    public function export($id){
        	
      	$date = new DateTime();
        $datestr = $date->format('Y-m-d_H:i:s');
        $filename = "Article_".$datestr;
        Excel::create($filename, function($excel) use($id){

            $excel->sheet('Article', function($sheet) use($id){
            	$articles = Article::where('id','=',$id)->orderBy('created_at','desc')->get();
            	$sheet->loadView('articles.article_csv',['articles'=>$articles->toArray()]);
            });

            $excel->sheet('Comment', function($sheet) use($id){
            	$comments = Comment::where('article_id','=',$id)->orderBy('created_at','desc')->get();
            	$sheet->loadView('articles.comment_csv',['comments'=>$comments->toArray()]);
            });
            	
        })->download('xls');

    	Session::flash('notice','Success exporting article');
		return Redirect::to('articles.index');

    }
        
        //create method to import article
        public function import(){

        		// still fail to validate
        		$file = Input::file('import');
        		//var_dump($file->getMimeType());
        		//var_dump($file->getClientOriginalExtension());
        		//var_dump($file->guessExtension());
        		//$newfile = $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();
        		//$mime = File::extension($newfile);
        		//var_dump($mime);

        		/*
        		$validate = Validator::make(
        			[
        				'import' => $file,
        				'extension' =>\Str::lower($file->getClientOriginalExtension()),
        			],
        			[
        				'import' => 'required',
            			'extension'  => 'required|in:xlsx,xls',
        			]
        		);*/

				$validate = Validator::make(
					[
						'import' => $file,
						'mime' => $file->getMimeType(),
					],
					[
						'import' => 'required',
						'mime' => 'required|in:application/vnd.ms-office,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
					]
				);

				//$validate = Validator::make(Input::all(), Article::valid_file());

        		if($validate->fails()){
        			$messages = $validate->messages();
        			return Redirect::to('articles')
        				->withErrors($validate)
        				->withInput();
        		} 
            	
            	$filename = $file->getClientOriginalName();
            	$filename = pathinfo($filename, PATHINFO_FILENAME);
            	
            	$fullname = Str::slug(Str::random(8).'_'.$filename).'.'.$file->getClientOriginalExtension();

            	$upload = $file->move(public_path().'/uploads', $fullname);

            	if($upload){
            		$articles = new Article;

            		Excel::selectSheets('Article')->load(public_path().'/uploads/'.$fullname, function($reader)use($articles){

            			$obj_article = [];
            			$results = $reader->get();
            			foreach ($results as $obj) {
            				$obj_article = json_decode($obj, true);
            			}
            			
            			$articles->title = $obj_article['title'];
            			$articles->content = $obj_article['content'];
            			$articles->author = $obj_article['author'];
            			$articles->created_at = $obj_article['created_at'];
            			$articles->updated_at = $obj_article['updated_at'];
            			$articles->save();
            			Session::flash('notice', 'Success import article');
            			
            		});

            		Excel::selectSheets('Comment')->load(public_path().'/uploads/'.$fullname, function($reader)use($articles){
            			
            			$obj_comment = [];
            			$results = $reader->get();
            			$obj_comment= json_decode($results, true);
            			$id['article_id'] = $articles->id;

            			for($i=0; $i<count($obj_comment);$i++){
            				
            				//gunakan objek berbeda untuk mengisi value yg berbeda
            				$comments[$i] = new Comment;
            				$comments[$i]->article_id = $id['article_id'];
            				$comments[$i]->content = $obj_comment[$i]['content'];
            				$comments[$i]->user = $obj_comment[$i]['user'];
            				$comments[$i]->created_at = $obj_comment[$i]['created_at'];
            				$comments[$i]->updated_at = $obj_comment[$i]['updated_at'];
            				$comments[$i]->save();
            			}

            		});
            		
            	}

            	Session::flash('notice', 'Success import article');
            	return Redirect::to('articles');   	
        }

}
