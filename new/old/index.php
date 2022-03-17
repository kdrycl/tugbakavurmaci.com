<?php include 'header.php';?>
    <main>
        <!-- hero-area start -->
        <section class="hero-area">
            <div class="hero-slider">
                <div class="slider-active">
                    <?php $sliders = $dbclass->cek("ASSOC_ALL","sliders","id,path,text1,text2,text3,link","where status=?",array(1));
                    foreach ($sliders as $keySlider => $sliders) {?>
                        <div class="single-slider slider-height d-flex align-items-center" data-background="<?php echo $sliders['path']?>">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-8 col-md-10">
                                        <div class="hero-text">
                                            <div class="hero-slider-caption ">
                                                <?php if($sliders['text1']!=null){ ?>
                                                    <h5 data-animation="fadeInUp" data-delay=".2s"><?php echo $sliders['text1'];?></h5>
                                                <?php } ?>
                                                <?php if($sliders['text2']!=null){ ?>
                                                    <p data-animation="fadeInUp" data-delay=".6s"><?php echo $sliders['text2'];?></p>
                                                <?php } ?>
                                            </div>
                                            <?php if($sliders['link']!=null){ ?>
                                                <div class="hero-slider-btn">
                                                    <a data-animation="fadeInLeft" data-delay=".6s" href="<?php echo $sliders['link'];?>" class="btn btn-icon ml-0"><span>+</span><?php echo $sliders['text3'];?></a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <!-- hero-area end -->
        <!-- services-area start -->
        <section class="servcies-area gray-bg pt-115 pb-90">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1">
                        <div class="section-title text-center pos-rel mb-75">
                            <div class="section-icon">
                                <img class="section-back-icon" src="theme/img/section/section-back-icon.png" alt="">
                            </div>
                            <div class="section-text pos-rel">
                                <h5>Hizmetlerimiz</h5>
                                <h2>Sağlık Hizmetlerimiz</h2>
                            </div>
                            <div class="section-line pos-rel">
                                <img src="assets/shape/section-title-line.png" alt="Şekil Çizgisi">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                <?php $services = $dbclass->cek("ASSOC_ALL","services","id,name,sorttext,icon,slug","where status=? ORDER BY sort ASC",array(1));
                foreach ($services as $keyservices => $servicesVal) { ?>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="service-box text-center mb-30">
                            <div class="service-thumb">
                                <img src="<?php echo $servicesVal['icon']; ?>" alt="<?php echo $servicesVal['alt']; ?>">
                            </div>
                            <div class="service-content">
                                <h3><a href="hizmetlerimiz/<?php echo $servicesVal['slug'];?>"><?php echo $servicesVal['name'];?></a></h3>
                                <p><?php echo $servicesVal['sorttext'];?></p>
                                <a class="service-link" href="hizmetlerimiz/<?php echo $servicesVal['slug'];?>">Devamını Oku</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
            </div>
        </section>
        <!-- services-area end -->
        <!-- latest-news-area start -->
        <section class="latest-news-area pt-115 pb-20">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 text-center">
                        <div class="section-title pos-rel mb-75">
                            <div class="section-icon">
                                <img class="section-back-icon back-icon-left" src="theme/img/section/section-back-icon.png" alt="">
                            </div>
                            <div class="section-text pos-rel">
                                <h5>Son Blog Yazılarımız</h5>
                                <h1>Blog</h1>
                            </div>
                            <div class="section-line pos-rel">
                                <img src="assets/shape/section-title-line.png" alt="Şekil Çizgisi">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-5 d-none d-lg-block">
                        <div class="section-button text-right pt-80">
                            <a data-animation="fadeInLeft" data-delay=".6s" href="blog" class="btn btn-icon ml-0"><span> + </span> Bloglara Git</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-8">
                        <div class="row">
                            <?php $detectedBlog = $dbclass->cek("ASSOC_ALL","blogs","id,blogName,blogSlug,uniqueId,blogShortDescription,blogImage","where recordStatus=?  ORDER BY id DESC LIMIT 0,2",array(1));
                            foreach ($detectedBlog as $keyBlog => $valueBlog) { ?>
                                <div class="col-xl-6 col-lg-6 col-md-6 text-center">
                                    <div class="latest-news-box mb-30">
                                        <div class="latest-news-thumb mb-35">
                                            <img src="<?php echo $valueBlog['blogImage']?>" alt="<?php echo $valueBlog['blogName'] ?> resmi">
                                        </div>
                                        <div class="latest-news-content">
                                            <div class="news-meta mb-10">
                                                <?php $countTags = $dbclass->cek("KAYITSAY","blogsvstags","count(id) as say","where blogId=?",array($valueBlog['id']));
                                                    if($countTags>0){
                                                        $detectedTags = $dbclass->cek("ASSOC_ALL","blogsvstags","tags.tagName as tagName,tags.tagSlug as tagSlug","INNER JOIN tags ON blogsvstags.tagId = tags.id WHERE blogsvstags.blogId=?",array($valueBlog['id']));
                                                        foreach ($detectedTags as $keyTags=> $valueTags) { ?>
                                                            <span><a href="blog/etiket/<?php echo $valueTags['tagSlug']; ?>" class="news-tag"><?php echo $valueTags['tagName']; ?></a></span>
                                                        <?php } ?>
                                                <?php } ?>
                                            </div>
                                            <h3><a href="blog/<?php echo $valueBlog['blogSlug'] ?>-<?php echo $valueBlog['uniqueId'] ?>"><?php echo $valueBlog['blogName'] ?></a></h3>
                                            <p><?php echo $valueBlog['blogShortDescription'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="col">
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
                           
                            
                        </div>
                    </div>
                </div>

                
            </div>
        </section>
        <!-- latest-news-area end -->
<?php include 'footer.php' ?>