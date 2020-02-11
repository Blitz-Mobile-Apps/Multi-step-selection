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

                $type = $wpdb->prefix.'dynamic_type as a';

                $gettype = $obj->getRows($type, ['order_by' => 'a.order ASC' ]);

                if ($gettype): ?>

                	<?php
                	// echo "<pre>";
                	// print_r($gettype); ?>

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

                                            	<?php
								                	// echo "<pre>";
								                	// print_r($getdata); ?>

                                                <?php foreach ($getdata as $key1): $thumbnail = wp_get_attachment_image_src($key1->img,'medium', true); ?>

                                                    <li>

                                                        <?php

                                                        $price = '';

                                                        $pricehtml  = '';

                                                        if (!empty($key1->price)):

                                                            $price = $key1->price;

                                                            $pricehtml  = '<ruby>£'.$price.'</ruby>';

                                                        endif;



                                                        $fieldtype = ($key->name =='Cake Filling') ? 'checkbox' : 'radio';

                                                        $required = ($key->name == '3d deco' || $key->name == '2d deco') ? '' : 'required=""';

                                                        $typemultiple = ($key->name =='Cake Filling') ? '[]' : '';



                                                        ?>

                                                        <input type="<?= $fieldtype;  ?>" <?php echo $required; ?> data-price="<?php echo $price; ?>" data-name="<?php echo str_replace(' ', '-', $key->name); ?>" style="opacity: 0;" value="<?php echo $key1->title; ?>" name="Ingredients[<?php echo str_replace(' ', '-', $key->name); ?>]<?php echo $typemultiple; ?>" id="<?php echo str_replace(' ', '-', $key1->title); ?>" class="valid">

                                                        <label for="<?php echo str_replace(' ', '-', $key1->title); ?>"><span data-dis="<?php echo $key1->discription; ?>" data-benefit="<?php echo $key1->benefits; ?>" data-img="<?php echo $thumbnail[0]; ?>"><?php echo $key1->title; ?></span>

                                                            <?php echo $pricehtml; ?>

                                                        </label>



                                                        <?php if ($key->name == 'Cake Base'): ?>

                                                            <ul class="cs-submenu">

                                                                <li><input type="radio" required name="size[<?php echo str_replace(' ', '-', $key->name); ?>]" data-name="Base Size" data-price="20" value="6 inches: 20 pounds" id="<?php echo str_replace(' ', '-', $key1->title); ?>01"><label for="<?php echo str_replace(' ', '-', $key1->title); ?>01">6 inches: 20 pounds</label></li>

                                                                <li><input type="radio" required name="size[<?php echo str_replace(' ', '-', $key->name); ?>]" data-name="Base Size" data-price="35" value="8 inches: 35 pounds" id="<?php echo str_replace(' ', '-', $key1->title); ?>02"><label for="<?php echo str_replace(' ', '-', $key1->title); ?>02">8 inches: 35 pounds</label></li>

                                                                <li><input type="radio" required name="size[<?php echo str_replace(' ', '-', $key->name); ?>]" data-name="Base Size" data-price="50" value="10 inches: 50 pounds" id="<?php echo str_replace(' ', '-', $key1->title); ?>03"><label for="<?php echo str_replace(' ', '-', $key1->title); ?>03">10 inches: 50 pounds</label></li>

                                                            </ul>

                                                        <?php endif ?>

                                                        <?php if ($key->name == 'Cake Topping'): ?>

                                                            <ul class="cs-submenu">

                                                                <li><input type="radio" name="topping_size[<?php echo str_replace(' ', '-', $key->name); ?>]" data-name="Cake Topping Size" data-price="0" value="6 inches cake: 10 pounds" id="<?php echo str_replace(' ', '-', $key1->title); ?>1"><label for="<?php echo str_replace(' ', '-', $key1->title); ?>1">6 inches cake: 10 pounds</label></li>

                                                                <li><input type="radio" name="topping_size[<?php echo str_replace(' ', '-', $key->name); ?>]" data-name="Cake Topping Size" data-price="0" value="8 inches cake: 15 pounds" id="<?php echo str_replace(' ', '-', $key1->title); ?>2"><label for="<?php echo str_replace(' ', '-', $key1->title); ?>2">8 inches cake: 15 pounds</label></li>

                                                                <li><input type="radio" name="topping_size[<?php echo str_replace(' ', '-', $key->name); ?>]" data-name="Cake Topping Size" data-price="0" value="10 inches cake: 20 pounds" id="<?php echo str_replace(' ', '-', $key1->title); ?>3"><label for="<?php echo str_replace(' ', '-', $key1->title); ?>3">10 inches cake: 20 pounds</label></li>

                                                            </ul>

                                                        <?php endif ?>

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

                                        <textarea name="optional_personal_message" class="form-control" rows="3" ></textarea>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <h3>Selected Ingredients:</h3>

                                <ul class="list-select personalized_data">

                                </ul>

                                <div style="clear: both;"></div>

                                <h2 class="amount-final">Amount: <strong id="amountcal">£00</strong></h2>

                            </div>

                        </div>

                    </div>

                </section>

            </div>

        </form>

    </div>

</section>