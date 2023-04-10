<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= base_url('bootstrap-star-rating/css/star-rating.css') ?>" media="all" type="text/css"/>
    <link rel="stylesheet" href="<?= base_url('bootstrap-star-rating/themes/krajee-svg/theme.css') ?>" media="all" type="text/css"/>

    <title>Ratings System</title>

    <style type="text/css">
        .content{
            border:0px solid black;
            border-radius:3px;
            padding:5px;
            margin: 0 auto;
            width:50%;
        }
        .post{
            border-bottom: 1px solid black;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .post:last-child{
            border: 0;
        }
        .post h2{
            font-weight: normal;
            font-size: 30px;
        }
        .post-text{
            letter-spacing:1px;
            font-size: 15px;
            font-family: serif;
            color: gray;
            text-align: justify;
        }
        .post-action{
            margin-top: 15px;
            margin-bottom: 15px;
        }
    </style>

</head>
<body>
    <div class="content">
        <?php
        foreach($posts as $post){
        ?>
            <div class="post">
                <h2>
                    <a href="<?= $post['link'] ?>" class='link' target="_blank"><?= $post['title']?></a>
                </h2>
                <div class="post-text">
                    <?= $post['description']?>
                </div>
                <div class="post-action">
                    <!-- Rating bar -->
                    <input  class="rating rating-loading"
                    data-post_id = "<?= $post['id'] ?>"
                    data-min ="0"
                    data-max = "5"
                    data-step = "0.5"
                    data-show-clear = "false"
                    data-show-caption = "false"
                    data-size = "md"
                    value = "<?= $post['userRating'] ?>"
                    >

                    <div style='clear:both;'></div>
                    <!-- display average rating -->
                    Average Rating: <span id='avgRating_<?= $post['id']?>'><?= $post['avgRating']?></span>
                </div>
            </div>

            <?php
            }
            ?>
    </div>
    
    

<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url('bootstrap-star-rating/js/star-rating.min.js') ?>"></script>

<script type="text/javascript">
    $(document).ready(function(){

        //Detect Rating Change
        $('.rating').on(
            'change',function(){

                var rating = $(this).val();// Selceted Rating
                var post_id = $(this).data('post_id');

                // AJAX request 
                $.ajax({
                    url:"<?= site_url('post/updaterating')?>",
                    data:{post_id: post_id,rating: rating},
                    dataType:'json',
                    success:function(response){

                        //Update average rating
                        $('#avgrating_'+post_id).text(response.avgRating)
                    }
                });
            }
        );
    });
</script> 
</body>
</html>