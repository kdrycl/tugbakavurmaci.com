<!-- footer-12 -->
        <footer class="footer-12">
            <div class="auto-container">
                <div class="footer-widget-section">
                    <div class="row clearfix">
                        <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget about-widget">
                                <figure class="footer-logo mb_10">
                                    <a href="/"><img src="<?php echo $companyInfo['logo']; ?>" style="max-width:250px; max-height:75px;" alt="<?php echo $companyInfo['companyName']; ?>"></a>
                                </figure>
                                <div class="text">
                                    <p><?php echo $functions->constDefinitions($dbclass,"FOOTER","FTR001")[0]; ?></p>
                                </div>
                                <ul class="footer-social-two clearfix">
                                    <li><a href="<?php echo $companyInfo['facebook']; ?>"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="<?php echo $companyInfo['twitter']; ?>"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="<?php echo $companyInfo['instagram']; ?>"><i class="fab fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget links-widget ml_80">
                                <div class="widget-title">
                                    <h4><?php echo $functions->constDefinitions($dbclass,"FOOTER","FTR002")[0]; ?></h4>
                                </div>
                                <div class="widget-content">
                                    <ul class="links-list clearfix">
                                        <?php
											$pages=$dbclass->cek("ASSOC_ALL","products","uniqueId,productName,productSlug","WHERE recordStatus=? AND langCode=? LIMIT 0, 6",array(1,"TR"));
											foreach ($pages as $key => $value) {
										?>
										<li>
											<a href="<?php echo $productMainSlug.'/'.$value['productSlug']; ?>"><?php echo $value['productName']; ?></a>
										</li>
									    <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget links-widget">
                                <div class="widget-title">
                                    <h4><?php echo $functions->constDefinitions($dbclass,"FOOTER","FTR003")[0]; ?></h4>
                                </div>
                                <div class="widget-content">
                                    <ul class="links-list clearfix">
                                        <?php
											$pages=$dbclass->cek("ASSOC_ALL","blogs","uniqueId,blogName,blogSlug","WHERE recordStatus=? LIMIT 0, 6",array(1));
											foreach ($pages as $key => $value) {
										?>
										<li>
											<a href="<?php echo $blogMainSlug.'/'.$value['blogSlug']; ?>"><?php echo $value['blogName']; ?></a>
										</li>
									    <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget contact-widget">
                                <div class="widget-title">
                                    <h4><?php echo $functions->constDefinitions($dbclass,"FOOTER","FTR004")[0]; ?></h4>
                                </div>
                                <div class="widget-content">
                                    <ul class="info-list clearfix">
                                        <li><?php echo $companyInfo['adress']; ?></li>
                                        <li><a href="tel:0<?php echo $companyInfo['phone1']; ?>">0<?php echo $companyInfo['phone1']; ?></a></li>
                                        <li><a href="mailto:<?php echo $companyInfo['mail1']; ?>"><?php echo $companyInfo['mail1']; ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="auto-container">
                    <div class="bottom-inner centred">
                        <div class="copyright">
                            <p>&copy; 2022 Tüm Hakları Saklıdır. Tasarım <a href="https://seratumedya.com">Konya Reklam Ajansı SERATU MEDYA</a> </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer-12 end -->


        <!--Scroll to top-->
        <div class="scroll-to-top">
            <div>
                <div class="scroll-top-inner">
                    <div class="scroll-bar">
                        <div class="bar-inner"></div>
                    </div>
                    <div class="scroll-bar-text g_color_2">Yukarı Çık</div>
                </div>
            </div>
        </div>
        <!-- Scroll to top end -->