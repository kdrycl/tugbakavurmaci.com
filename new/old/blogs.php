<?php include 'header.php'; 
if(isset($_GET['categorySlug'])){
    $getAllBlog = $dbclass->cek("ASSOC_ALL","blogsvscategories","blogs.*","INNER JOIN blogcategories ON blogcategories.id = blogsvscategories.categoryUniqueId INNER JOIN blogs ON blogs.uniqueId=blogsvscategories.blogUniqueId where blogcategories.slug=? ORDER BY blogs.id DESC",array($_GET['categorySlug']));
}
else if(isset($_GET['tagSlug'])){
    $getAllBlog = $dbclass->cek("ASSOC_ALL","blogsvstags","blogs.*","INNER JOIN tags ON tags.id = blogsvstags.tagId INNER JOIN blogs ON blogs.id = blogsvstags.blogId WHERE tags.tagSlug=? ORDER BY blogs.id DESC",array($_GET['tagSlug']));
}
else{
    $getAllBlog = $dbclass->cek("ASSOC_ALL","blogs","*","where recordStatus=? ORDER BY id DESC",array(1));
}
?>

<main>
        <!-- hero-area start -->
        <section class="breadcrumb-bg pt-200 pb-180" data-background="theme/img/page/page-bg.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="page-title">
                            <p class="small-text pb-15">Blog Yazılarımız</p>
                            <h1>Blog</h1>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 d-flex justify-content-start justify-content-md-end align-items-center">
                        <div class="page-breadcumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb ">
                                    <li class="breadcrumb-item">
                                        <a href="/">Anasayfa</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Blog</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- hero-area end -->

        <!-- blog-area start -->
        <section class="blog-area pt-120 pb-80">
            <div class="container">
                <div class="row">
                <div class="col-lg-4">
                       
                        
                       <div class="widget mb-40">
                           <div class="widget-title-box mb-30">
                               <span class="animate-border"></span>
                               <h3 class="widget-title">Popüler Yazılar</h3>
                           </div>
                           <ul class="recent-posts">
                               <?php 
                                $detectedCountB = $dbclass->cek("ASSOC_ALL","blogs","*","where recordStatus=? ORDER BY readcount DESC LIMIT 0,3",array(1));
                               foreach ($detectedCountB as $keyb => $valueB) { ?>
                                   <li>
                                       <div class="widget-posts-image">
                                           <a href="blog/<?php echo $valueB['blogSlug'];?>-<?php echo $valueB['uniqueId'];?>"><img src="<?php echo $valueB['blogImage'];?>" width="250px" height="250px" alt=""></a>
                                       </div>
                                       <div class="widget-posts-body">
                                           <h6 class="widget-posts-title"><a href="blog/<?php echo $valueB['blogSlug'];?>-<?php echo $valueB['uniqueId'];?>"><?php echo $valueB['blogName'];?></a></h6>
                                           <div class="widget-posts-meta"><?php echo $valueB['date'];?> </div>
                                       </div>
                                  </li>
                               <?php } ?>
                           </ul>
                       </div>
                       <div class="widget mb-40">
                           <div class="widget-title-box mb-30">
                               <span class="animate-border"></span>
                               <h3 class="widget-title">Kategoriler</h3>
                           </div>
                           <ul class="cat">
                           <?php $detectedBlogCategories = $dbclass->cek("ASSOC_ALL","blogcategories","id,adi,slug","where status=? ORDER BY sort ASC LIMIT 0,6",array(1));
                            foreach ($detectedBlogCategories as $keyblogcat => $valueblogcat) { 
                                $countCat = $dbclass->cek("KAYITSAY","blogsvscategories","count(id)","where categoryUniqueId=?",array($valueblogcat['id']));
                                if($countCat>0){ ?>
                                    <li><a href="blog/kategori/<?php echo $valueblogcat['slug'];?>"><?php echo $valueblogcat['adi'];?> <span class="f-right"><?php echo $countCat;?></span></a></li>   
                                <?php } ?>
                            <?php } ?>
                           </ul>
                       </div>
                       <div class="widget mb-40">
                           <div class="widget-title-box mb-30">
                               <span class="animate-border"></span>
                               <h3 class="widget-title">Sosyal Medya</h3>
                           </div>
                           <div class="social-profile">
                                   <?php 
                                   $socialmedia = $dbclass->cek("ASSOC_ALL","socialmedia","icon,link,status","where status=?",array(1));
                                   foreach ($socialmedia as $key => $value) { ?>
                                       <a target="_blank" href="<?php echo $value['link']?>"><i class="<?php echo $value['icon']?>"></i></a>
                                   <?php } ?>
                           </div>
                       </div>
                       
                       <div class="widget mb-40">
                           <div class="widget-title-box mb-30">
                               <span class="animate-border"></span>
                               <h3 class="widget-title">Etiketler</h3>
                           </div>
                           <div class="tag">
                               <?php 
                               $cekTag = $dbclass->cek("ASSOC_ALL","blogsvstags","tags.tagName,tags.tagSlug","INNER JOIN blogs ON blogs.id = blogsvstags.blogId INNER JOIN tags ON tags.id = blogsvstags.tagId WHERE blogs.recordStatus=? GROUP BY tags.id",array(1));
                               foreach ($cekTag as $keyTag => $valueTag) {
                                  echo ' <a href="blog/etiket/'.$valueTag['tagSlug'].'">'.$valueTag['tagName'].'</a>';
                               }
                               ?>
                           </div>
                       </div>
                       <div class="widget mb-40 p-0 b-0">
                           <div class="banner-widget">
                               <a href="#"><img src="img/blog/details/banner.png" alt=""></a>
                           </div>
                       </div>
                   </div>
                    <div class="col-lg-8">
                    <?php 
                        
                        foreach ($getAllBlog as $key => $value) { ?>
                            <article class="postbox post format-image mb-40">
                                <div class="postbox__thumb">
                                    <a href="blog/<?php echo $value['blogSlug'];?>-<?php echo $value['uniqueId'];?>">
                                        <img src="<?php echo $value['blogImage'];?>" alt="blog image">
                                    </a>
                                </div>
                                <div class="postbox__text p-50">
                                    <div class="post-meta mb-15">
                                        <span><i class="far fa-calendar-check"></i> <?php echo $value['date'];?> </span>
                                    </div>
                                    <h3 class="blog-title">
                                        <a href="blog/<?php echo $value['blogSlug'];?>-<?php echo $value['uniqueId'];?>"> <?php echo $value['blogName'];?></a>
                                    </h3>
                                    <div class="post-text mb-20">
                                        <p> <?php echo $value['blogShortDescription'];?></p>
                                    </div>
                                    <div class="read-more mt-30">
                                        <a href="blog/<?php echo $value['blogSlug'];?>-<?php echo $value['uniqueId'];?>" class="btn theme-btn">Devamını Oku</a>
                                    </div>
                                </div>
                            </article>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- blog-area end -->
    </main>

<?php include 'footer.php'; ?>
