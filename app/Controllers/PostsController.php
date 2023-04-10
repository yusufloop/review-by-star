<?php

namespace App\Controllers;

use App\Models\Posts;
use App\Models\PostRatings;
use App\Controllers\BaseController;

class PostsController extends BaseController
{
    public $userid = 2; //Replace this value with your user SESSION variable

    public function index()
    {
        // Declare obj
        $postObj = new Posts();
        $postRatingsObj = new PostRatings();

        // Fetch all posts
        $postData = $postObj->select('*')->findAll();
        foreach($postData as $key => $post){

            ## User rating . find first
            $postRatingData = $postRatingsObj-> select('rating')
                ->where('post_id', $post['id'])
                ->where('user_id', $this->userid)
                ->find();

            $userRating = 0;

            if(!empty($postRatingData)){
                $userRating = $postRatingData[0]['rating'];
            }

            ##posting average rating
            $postRatingData =$postRatingsObj->select('ROUND(AVG(rating),1) as averageRating')        
                ->where('post_id', $post['id'])
                ->find();

            $avgRating = $postRatingData[0]['averageRating']; // masukkanvalue dalam array ke $avgRating

            if($avgRating == ''){
                $avgRating = 0; //kalau masih kosong, set to zero
            }

            $postData[$key]['userRating'] = $userRating;
            $postData[$key]['avgRating'] = $avgRating;
        }
        $data['posts'] =$postData;

        return view('index', $data);
    }

    public function updateRating(){
        ## buat request
        $request =service('request');
        $getData = $request->getGet();

        $post_id = $getData['post_id'];
        $rating = $getData['rating'];
        //decalre object

        $postRatingsObj = new PostRatings();

        // Check user Rating
        $postRatingData = $postRatingsObj->select('id')
            ->where('post_id', $post_id)
            ->where('user_id',$this->userid)
            ->find();

            if(!empty($postRatingData)){

                ##Update user Rating
                $postRating_id = $postRatingData[0]['id'];

                $postRatingsObj->set('rating',$rating);
                $postRatingsObj->where('id', $postRating_id);
                $postRatingsObj->update();
            }else{
                ##insert data
                $insertData = [
                    'user_id' => $this->userid,
                    'post_id' =>$post_id,
                    'rating' =>$rating
                ];

                $postRatingsObj->insert($insertData);
            }

            //Calculate Average rating
            $postRatingData =$postRatingsObj->select('ROUND(AVG(rating),1) as averageRating')        
                ->where('post_id', $post_id)
                ->find();

            $avgRating = $postRatingData[0]['averageRating'];

            if($rating == ''){
                $avgRating = 0;
            }

            $data['avgRating'] = $avgRating;

            return $this->response->setJSON($data);
    }
}