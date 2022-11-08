<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?= $title ?></h4>
                <form class="edit-forms">
                    <div class="row">
                        <?php foreach ($forms as $form) :
                            $rowtype = $form[1];
                            $rowname = $form[0];
                            $placeholder = "Insert " . str_replace("_", " ", $form[0]);
                            $label   = strtoupper(str_replace("_", " ", $form[0]));

                            if ($rowtype == 'text') :
                        ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="<?= $rowname ?>"><?= $label ?></label>
                                        <input type="text" class="form-control" id="<?= $rowname ?>" name="<?= $rowname ?>" value="<?= $page->$rowname ?>" placeholder="<?= $placeholder ?>">
                                        <div class="invalid-feedback" for="<?= $rowname ?>"></div>
                                    </div>
                                </div>
                            <?php
                            elseif ($rowtype == 'number') :
                            ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="<?= $rowname ?>"><?= $label ?></label>
                                        <input type="number" class="form-control" id="<?= $rowname ?>" name="<?= $rowname ?>" value="<?= $page->$rowname ?>" placeholder="<?= $placeholder ?>">
                                        <div class="invalid-feedback" for="<?= $rowname ?>"></div>
                                    </div>
                                </div>
                            <?php
                            elseif ($rowtype == 'textarea') :
                            ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="<?= $rowname ?>"><?= $label ?></label>
                                        <textarea class="form-control" name="<?= $rowname ?>" id="<?= $rowname ?>" rows="4" placeholder="<?= $placeholder ?>"><?= $page->$rowname ?></textarea>
                                        <div class="invalid-feedback" for="<?= $rowname ?>"></div>
                                    </div>
                                </div>
                            <?php
                            elseif ($rowtype == 'year') :
                            ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="<?= $rowname ?>"><?= $label ?></label>
                                        <input type="text" class="form-control yearpicker" id="<?= $rowname ?>" name="<?= $rowname ?>" value="<?= $page->$rowname ?>" placeholder="<?= $placeholder ?>">
                                        <div class="invalid-feedback" for="<?= $rowname ?>"></div>
                                    </div>
                                </div>
                            <?php
                            elseif ($rowtype == 'select') :
                                $value = $form[2];
                            ?>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="<?= $rowname ?>"><?= $label ?></label>
                                        <select id="<?= $rowname ?>" name="<?= $rowname ?>" class="w-100 form-select select2">
                                            <option></option>
                                            <?php foreach ($value as $v) : ?>
                                                <option <?= ($v->id == $page->$rowname) ? 'selected' : '' ?> value="<?= $v->id; ?>"><?= $v->text; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback" for="<?= $rowname ?>"></div>
                                    </div>
                                </div>
                            <?php
                            elseif ($rowtype == 'date') :
                            ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="<?= $rowname ?>"><?= $label ?></label>
                                        <input type="text" autocomplete="off" class="form-control datepicker" id="<?= $rowname ?>" name="<?= $rowname ?>" value="<?= $page->$rowname ?>" placeholder="<?= $placeholder ?>">
                                        <div class="invalid-feedback" for="<?= $rowname ?>"></div>
                                    </div>
                                </div>
                            <?php
                            elseif ($rowtype == 'password') :
                            ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="<?= $rowname ?>"><?= $label ?></label>
                                        <input type="password" class="form-control" id="<?= $rowname ?>" name="<?= $rowname ?>" value="<?= $page->$rowname ?>" placeholder="<?= $placeholder ?>">
                                        <div class="invalid-feedback" for="<?= $rowname ?>"></div>
                                    </div>
                                </div>

                            <?php
                            elseif ($rowtype == 'location') :
                            ?>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="<?= $rowname ?>"><?= $label ?></label>
                                        <div id="map"></div>
                                    </div>
                                    <input type="hidden" name="longitude" value="<?= $page->longitude ?>" id="longitudes">
                                    <input type="hidden" name="latitude" value="<?= $page->latitude ?>" id="latitudes">
                                </div>
                                <script>
                                    const longitude = `<?= $page->longitude ?>`;
                                    const latitude = `<?= $page->latitude ?>`;
                                </script>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="<?= base_url($controller) ?>" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- content-wrapper ends -->