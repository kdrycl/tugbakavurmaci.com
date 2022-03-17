<!-- preloader 
<div class="loader-wrap">
  <div class="preloader">
    <div class="preloader-close">x</div>
    <div id="handle-preloader" class="handle-preloader home-12">
      <div class="animation-preloader">
        <div class="spinner"></div>
        <div class="txt-loading">
          <span data-text-preloader="a" class="letters-loading">
              a
          </span>
          <span data-text-preloader="t" class="letters-loading">
              t
          </span>
          <span data-text-preloader="r" class="letters-loading">
              r
          </span>
          <span data-text-preloader="i" class="letters-loading">
              i
          </span>
          <span data-text-preloader="x" class="letters-loading">
              x
          </span>
        </div>
      </div>  
    </div>
  </div>
</div>
 preloader end -->
<!-- main header -->
<header class="main-header header-style-two header-style-12">
	<div class="container">
		<!-- header-lower -->
		<div class="header-lower">
			<div class="outer-container">
				<div class="outer-box">
					<div class="logo-box">
						<figure class="logo"><a href="/"><img src="<?php echo $companyInfo['logo']; ?>" alt="<?php echo $companyInfo['companyName']; ?>"></a></figure>
					</div>
					<div class="menu-area clearfix">
							<!--Mobile Navigation Toggler-->
							<div class="mobile-nav-toggler">
								<i class="icon-bar"></i>
								<i class="icon-bar"></i>
								<i class="icon-bar"></i>
							</div>
							<nav class="main-menu navbar-expand-md navbar-light">
								<div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
									<ul class="navigation clearfix home-menu">
										<li><a href="/"><?php echo $functions->constDefinitions($dbclass,"HEDMENU","HDM003")[0]; ?></a></li>
										<?php
											$pages=$dbclass->cek("ASSOC_ALL","pages","uniqueId,pageName,pageSlug","WHERE recordStatus=? AND langCode=?",array(1,"TR"));
											foreach ($pages as $key => $value) {
										?>
										<li>
											<a href="<?php echo $pageMainSlug.'/'.$value['pageSlug']; ?>"><?php echo $value['pageName']; ?></a>
										</li>
									<?php } ?>
										<li class="dropdown">
											<a href="#">Hizmetlerimiz</a>
											<div class="megamenu">
													<div class="row clearfix">
														<?php
															$productsCount=$dbclass->cek("KAYITSAY","products","count(id)","WHERE products.recordStatus=? AND products.langCode=? AND products.showMenu=? AND products.mainProduct=?",array(1,"TR",1,0));
															if($productsCount>3) $limit= floor($productsCount/3);
															else{
																$limit=999;
																$categoryProductsGet2=array();
																$categoryProductsGet3=array();
															}
															$categoryProductsGet1=$dbclass->cek("ASSOC_ALL","products","products.uniqueId,products.productName,products.productSlug","WHERE products.recordStatus=? AND products.langCode=? AND products.showMenu=? AND products.mainProduct=? LIMIT 0, $limit",array(1,"TR",1,0));
														?>
														<div class="col-lg-4 column">
															<ul>
																<?php
																	foreach ($categoryProductsGet1 as $key => $values) {
																		echo '<li><a href="'. $productMainSlug.'/'.$values['productSlug'].'">'.$values['productName'].'</a></li>';
																	}
																?>
															</ul>
														</div>
														<?php
															$categoryProductsGet2=$dbclass->cek("ASSOC_ALL","products","products.uniqueId,products.productName,products.productSlug","WHERE products.recordStatus=? AND products.langCode=? AND products.showMenu=? AND products.mainProduct=? LIMIT $limit, $limit",array(1,"TR",1,0));
														?>
														<div class="col-lg-4 column">
															<ul>
																<?php
																	foreach ($categoryProductsGet2 as $key => $values) {
																		echo '<li><a href="'. $productMainSlug.'/'.$values['productSlug'].'">'.$values['productName'].'</a></li>';
																	}
																?>
															</ul>
														</div> 
														<?php
														$yenilimit = $limit*2;
															$categoryProductsGet3=$dbclass->cek("ASSOC_ALL","products","products.uniqueId,products.productName,products.productSlug","WHERE products.recordStatus=? AND products.langCode=? AND products.showMenu=? AND products.mainProduct=? LIMIT $yenilimit, $limit",array(1,"TR",1,0));
														?>
														<div class="col-lg-4 column">
															<ul>
																<?php
																	foreach ($categoryProductsGet3 as $key => $values) {
																		echo '<li><a href="'. $productMainSlug.'/'.$values['productSlug'].'">'.$values['productName'].'</a></li>';
																	}
																?>
															</ul>
														</div> 
													</div>                                            
											</div>
										</li>
										<li><a href="/tum-bloglar">Blog</a></li>  
										<li><a href="/iletisim-bilgilerimiz"><?php echo $functions->constDefinitions($dbclass,"HEDMENU","HDM004")[0]; ?></a></li>  
									</ul>
								</div>
							</nav>
					</div>
				</div>
			</div>
		</div>

		<!--sticky Header-->
		<div class="sticky-header">
			<div class="outer-container">
				<div class="outer-box">
					<div class="logo-box">
						<figure class="logo"><a href="/"><img src="<?php echo $companyInfo['logo']; ?>" alt="<?php echo $companyInfo['companyName']; ?>" class="img-fluid" style="max-width:200px;"></a></figure>
					</div>
					<div class="menu-area clearfix">
						<nav class="main-menu clearfix">
							<!--Keep This Empty / Menu will come through Javascript-->
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- main-header end -->
<!-- Mobile Menu  -->
<div class="mobile-menu">
	<div class="menu-backdrop"></div>
	<div class="close-btn"><i class="fas fa-times"></i></div>
    
	<nav class="menu-box">
		<div class="nav-logo"><a href="/"><img src="<?php echo $companyInfo['logo']; ?>" alt="<?php echo $companyInfo['companyName']; ?>"></a></div>
		<div class="menu-outer"><!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
		<div class="contact-info">
			<h4>Contact Info</h4>
			<ul>
				<li>Chicago 12, Melborne City, USA</li>
				<li><a href="tel:+8801682648101">+88 01682648101</a></li>
				<li><a href="mailto:info@example.com">info@example.com</a></li>
			</ul>
		</div>
		<div class="social-links">
			<ul class="clearfix">
				<li><a href="index-2.html"><span class="fab fa-twitter"></span></a></li>
				<li><a href="index-2.html"><span class="fab fa-facebook-square"></span></a></li>
				<li><a href="index-2.html"><span class="fab fa-pinterest-p"></span></a></li>
				<li><a href="index-2.html"><span class="fab fa-instagram"></span></a></li>
				<li><a href="index-2.html"><span class="fab fa-youtube"></span></a></li>
			</ul>
		</div>
	</nav>
</div><!-- End Mobile Menu -->