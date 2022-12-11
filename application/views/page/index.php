<!-- about section -->
<section class="about_section layout_padding-bottom">
    <div class="square-box">
        <img src="<?= base_url() ?>public/app/images/square.png" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="img-box">
                    <img src="<?= base_url() ?>public/app/images/about-img.jpg" alt="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-box">
                    <div class="heading_container">
                        <h2>
                            Tentang Website
                        </h2>
                    </div>
                    <p>
                        Website data kepemilikan tanah dareah pemerintahan kota palangka raya
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="layout_padding-bottom">
    <div class="container">
        <div class="d-flex mb-3">
            <div class="col-form-label mr-3">Filter Status :</div>
            <button type="button" class="btn btn-outline-info mr-1 my-1 btn-sm btn-filter" data-status="ALL">Semua</button>
            <button type="button" class="btn btn-outline-info mr-1 my-1 btn-sm btn-filter" data-status="Fasos">Fasos</button>
            <button type="button" class="btn btn-outline-info mr-1 my-1 btn-sm btn-filter" data-status="Fasum">Fasum</button>
        </div>
        <div id="map"></div>
    </div>
</section>
<!-- end about section -->