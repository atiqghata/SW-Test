<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * List Movies and Filter by title
     * @param Request $request
     * @return User 
     */
    public function index(Request $request) {
        try {
            $movies = Movie::orderBy('id', 'DESC');

            if(isset($request->search) && !empty($request->search)){
                $movies = $movies->where('title', 'like' ,'%'.$request->search.'%');
            }

            $movies = $movies->get();

            return response()->json([
                'status' => true,
                'movies' => $movies
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Add Movie
     * @param Request $request
     * @return User 
     */
    public function add(Request $request) {
        try{
            $movie = new Movie();
            $movie->title = $request->title;
            $movie->description = $request->description;
            if($movie->save()){
                return response()->json([
                    'status' => true,
                    'message' => 'Movie Created Successfully',
                    'movie'=> $movie,
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show Individual Movie by id
     * @param Request $request, $id
     * @return User 
     */
    public function show(Request $request, $id) {
        try{
            $movie = Movie::find($id);

            if(!isset($movie->id)){
                return response()->json([
                    'status' => false,
                    'message'=> 'Movie not found',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'movie'=> $movie,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Update Movie by id
     * @param Request $request, $id
     * @return User 
     */
    public function update(Request $request, $id) {
        try{
            $movie = Movie::find($id);

            if(!isset($movie->id)){
                return response()->json([
                    'status' => false,
                    'message'=> 'Movie not found',
                ], 404);
            }

            $movie->title = $request->title;
            $movie->description = $request->description;
            if($movie->save()){
                return response()->json([
                    'status' => true,
                    'message' => 'Movie Updated Successfully',
                    'movie'=> $movie,
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Delete Movie by id
     * @param Request $request, $id
     * @return User 
     */
    public function delete(Request $request, $id) {
        try{
            $movie = Movie::find($id);
            if(!isset($movie->id)){
                return response()->json([
                    'status' => false,
                    'message'=> 'Movie not found',
                ], 404);
            }
            $movie->delete();

            return response()->json([
                'status' => true,
                'message'=> 'Movie Deleted Successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
