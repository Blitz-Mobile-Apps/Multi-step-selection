<section class="form" id="stepform">
    <div class="container">
        <form id="example-form" action="?submit=true" method="POST">
            <div>



                <h3>Select A Delivery Date</h3>
                <section>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <input type="text" name="delivery_date" id="delivery-date" class="form-control" required="required" placeholder="Select Delivery Date">
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
                                <br>
                            </div>
                        </div>
                    </div>
                </section>




                <?php
                global $obj,$wpdb;
                $form = $wpdb->prefix.'dynamic_form';
                $type = $wpdb->prefix.'dynamic_type';
                $gettype = $obj->getRows($type);
                if ($gettype): ?>
                <?php foreach ($gettype as $key):
                $getdata = $obj->getRows($form, ['where' =>['type' => $key->id ] ]); ?>
                <h3><?php echo $key->name; ?></h3>
                <section>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <!-- <h3>What Lorem ipsum dolor sit amet, consectetur adipisicing elit.?</h3> -->
                                <ul class="list-select">
                                    <?php if ($getdata): ?>
                                    <?php foreach ($getdata as $key1): $thumbnail = wp_get_attachment_image_src($key1->img,'medium', true); ?>
                                    <li>
                                        <?php
                                        $price = '';
                                        $pricehtml  = '';
                                        if (!empty($key1->price)):
                                        $price = $key1->price;
                                        $pricehtml  = '<ruby>$'.$price.'</ruby>';
                                        endif;
                                        ?>
                                        <input type="radio" required="" data-price="<?php echo $price; ?>" data-name="<?php echo str_replace(' ', '-', $key->name); ?>" style="opacity: 0;" value="<?php echo $key1->title; ?>" name="Ingredients[<?php echo str_replace(' ', '-', $key->name); ?>]" id="<?php echo str_replace(' ', '-', $key1->title); ?>" class="valid">
                                        <label for="<?php echo str_replace(' ', '-', $key1->title); ?>"><span data-dis="<?php echo $key1->discription; ?>" data-benefit="<?php echo $key1->benefits; ?>" data-img="<?php echo $thumbnail[0]; ?>"><?php echo $key1->title; ?></span>
                                        <?php echo $pricehtml; ?>
                                    </label>
                                </li>
                                <?php endforeach ?>
                                <?php endif ?>
                            </ul>
                        </div>
                        <div class="col-md-9" class="contentappend">
                            <div class="row">
                                <div class="col-md-5">
                                    <h4></h4>
                                    <h5>Disciption:</h5>
                                    <p></p>
                                    <h5>Health Benefit:</h5>
                                    <p></p>
                                </div>
                                <div class="col-md-7">
                                    <img src="" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php endforeach ?>
            <?php endif; ?>
            <h3>Personalise your Cake</h3>
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Personalise:</h3>
                            <div class="form-group">
                                <label for="input" class="col-sm-12 control-label">Name Your Blend:</label>
                                <div class="col-sm-12">
                                    <input type="text" name="name_your_blend" class="form-control" value="" required="required" placeholder="e.g My Magnificent Blend.">
                                </div>
                            </div>
                            <div style="clear: both;"></div>
                            <br>
                            <div class="form-group">
                                <label for="input" class="col-sm-12 control-label">Optional Personal Message:</label>
                                <div class="col-sm-12">
                                    <textarea name="optional_personal_message" class="form-control" rows="3" required="required"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3>Selected Ingredients:</h3>
                            <ul class="list-select personalized_data">
                            </ul>
                            <div style="clear: both;"></div>
                            <br>
                            <h2>Amount: <strong id="amountcal">$00</strong></h2>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </form>
</div>
</section>