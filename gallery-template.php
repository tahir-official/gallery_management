<?php
/*
*
Template Name: Gallery Management Template
*/
get_header(); ?>
<style type="text/css">
   


#loadMore {
  width: 200px;
  color: #fff;
  display: block;
  text-align: center;
  margin: 20px auto;
  padding: 10px;
  border-radius: 10px;
  border: 1px solid transparent;
  background-color: blue;
  transition: .3s;
}
#loadMore:hover {
  color: blue;
  background-color: #fff;
  border: 1px solid blue;
  text-decoration: none;
}
.noContent {
  color: #000 !important;
  background-color: transparent !important;
  pointer-events: none;
}
</style>

<div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <div class="container">
              <div class="row">
                <div class="col-md-3">

                  <h3 style="padding-left: 42px;">Gallery Categories</h3>
                  <ul class="list-group nav">
                      <?php
                        $gallery_categories = get_terms('gallery-category', array('hide_empty' => 0, 'parent' =>0)); 
                       
                        if (!empty($gallery_categories) ){
                            $i=0;
                            foreach ( $gallery_categories as $gallery_category ) {
                                $activeclass='';
                                if($i==0){
                                $activeclass='active';    
                                }
                                
                                ?>
                                <a href="javascript:void(0)"  onclick="loadData('<?=$gallery_category->slug?>')"><li class="list-group-item <?=$activeclass?>"><?=$gallery_category->name?></li>
                                <?php
                            $i++;    
                            }
                        }else{
                                echo '<li class="list-group-item">No Data Found</li>';
                        }
                      ?>
                    </ul>
                </div>
                <div class="col-md-9">
                  <h3 >Gallery Images</h3>
                    <div  id="gallery_data">
                        
                    </div>
                    
                                         
                      
                    
                    
                    <a href="#" id="loadMore">Load More</a>
                    <!-- Gallery -->
                </div>
                
              </div>
            </div>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php

get_footer(); ?>
<script type="text/javascript">
    $(document).ready(function(){
        
      
      loadData('<?=$gallery_categories[0]->slug?>');


      $('.nav li').click(function(event){
        $('.active').removeClass('active');
        $(this).addClass('active');
        event.preventDefault();
      });
      
    })
    function loadData(cat_slug){
        $.ajax({
        url: "<?PHP echo admin_url('admin-ajax.php'); ?>",
        type: "post",
        data: {cat_slug:cat_slug,action:'load_gallery_data'},
        dataType:'json',
        beforeSend:function()
        {
            $("#gallery_data").html('<div style="text-align: center;"><i class="fa fa-spinner fa-spin" style="font-size:50px"></i></div>');
            $("#loadMore").css('display','none');
            
            
        },
        success: function(response){
           $("#gallery_data").html(response.html);
           $("#loadMore").css('display','block');
           $("#loadMore").text("Load More").removeClass("noContent");
           $(".content").slice(0, 6).show();
           $("#loadMore").on("click", function(e){
            e.preventDefault();
            $(".content:hidden").slice(0, 6).slideDown();
            if($(".content:hidden").length == 0) {
              $("#loadMore").text("No Gallery").addClass("noContent");
            }
           });

        }
        });
    }

</script>
