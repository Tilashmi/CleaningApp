<?php
    
namespace App\Http\Controllers;
    
    use App\Models\Cleaner;
    use Illuminate\Http\Request;
        
    class CleanerController extends Controller
    { 
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        function __construct()
        {
             $this->middleware('permission:cleaner-list|cleaner-create|cleaner-edit|cleaner-delete', ['only' => ['index','show']]);
             $this->middleware('permission:cleaner-create', ['only' => ['create','store']]);
             $this->middleware('permission:cleaner-edit', ['only' => ['edit','update']]);
             $this->middleware('permission:cleaner-delete', ['only' => ['destroy']]);
        }
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $cleaners = Cleaner::latest()->paginate(5);
            return view('cleaners.index',compact('cleaners'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
        }
        
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            return view('cleaners.create');
        }
        
        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            request()->validate([
                'name' => 'required',
                'status' => 'required',
            ]);
        
            Cleaner::create($request->all());
        
            return redirect()->route('cleaners.index')
                            ->with('success','Cleaner created successfully.');
        }
        
        /**
         * Display the specified resource.
         *
         * @param  \App\Cleaner $cleaner
         * @return \Illuminate\Http\Response
         */
        public function show(Cleaner $cleaner)
        {
            return view('cleaners.show',compact('cleaner'));
        }
        
        /**
         * Show the form for editing the specified resource.
         *
         * @param  \App\Cleaner  $cleaner
         * @return \Illuminate\Http\Response
         */
        public function edit(Cleaner $cleaner)
        {
            return view('cleaners.edit',compact('cleaner'));
        }
        
        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \App\Cleaner  $cleaner
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Cleaner $cleaner)
        {
             request()->validate([
                'name' => 'required',
                'status'=> 'required',
            ]);
        
            $cleaner->update($request->all());
        
            return redirect()->route('cleaners.index')
                            ->with('success','Cleaner updated successfully');
        }
        
        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\Cleaner  $cleaner
         * @return \Illuminate\Http\Response
         */
        public function destroy(Cleaner $cleaner)
        {
            $cleaner->delete();
        
            return redirect()->route('cleaners.index')
                            ->with('success','Cleaner deleted successfully');