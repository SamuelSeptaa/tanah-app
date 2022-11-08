<div class="content-wrapper">
    <div class="grid-margin stretch-card">
        <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?= $title ?></h4>
                    <div class="row mb-3 justify-content-end pr-3">
                        <a href="<?= $controller ?>/add" class="btn btn-primary">Tambah</a>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-lg-6 col-md-6 col-sm-12 form-group row">
                            <label class="col-sm-3 col-form-label">Search</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" name="search" id="search">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped" id="data-pemilik" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>
                                        Action
                                    </th>
                                    <th>
                                        Nama
                                    </th>
                                    <th>
                                        Total Tanah Dimiliki
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- content-wrapper ends -->